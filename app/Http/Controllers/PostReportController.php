<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PostReportController extends Controller
{
    // Display the report page (if you choose to have an index page for reports)
    public function index(Request $request)
{
    $data = $this->getReportData($request);

    return view('posts.reports.index', $data); // <--- Change 'posts.index' to 'posts.reports.index'
}

    // Download the report as PDF.
    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('posts.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('posts-report.pdf');
    }

    // Download the report as CSV.
    public function exportCsv(Request $request)
    {
        $data = $this->getReportData($request);
        $posts = $data['posts'];

        return response()->streamDownload(function () use ($posts) {
            $file = fopen('php://output', 'w');

            // Helps spreadsheet applications recognize UTF-8 text.
            fwrite($file, "\xEF\xBB\xBF");

            // CSV column headings updated to match your database columns.
            fputcsv($file, [
                'ID',
                'Title',
                'Category',
                'Author',
                'Body',
                'Published At',
            ], ',', '"', '');

            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $this->csvText($post->title),
                    $this->csvText($post->category),
                    $this->csvText($post->author),
                    $this->csvText($post->body),
                    $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : 'N/A',
                ], ',', '"', '');
            }

            fclose($file);
        }, 'posts-report.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    // Reuse the same validation and filters for all report formats based on published_at/created_at.
    private function getReportData(Request $request): array
    {
        $endDateRules = ['nullable', 'date_format:Y-m-d'];

        if ($request->filled('start_date')) {
            $endDateRules[] = 'after_or_equal:start_date';
        }

        $validated = $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => $endDateRules,
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $query = Post::query();

        // Filter using published_at (or created_at if published_at is null)
        if ($startDate) {
            $query->whereDate('published_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('published_at', '<=', $endDate);
        }

        $posts = $query->latest('published_at')->orderByDesc('id')->get();

        return [
            'posts' => $posts,
            'totalPosts' => $posts->count(),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
        ];
    }

    // Prevent spreadsheet formulas from running in user-entered text.
    private function csvText(?string $value): string
    {
        if (empty($value)) {
            return '';
        }

        if (preg_match('/^[\s\x{FEFF}]*[=+\-@]/u', $value)) {
            return "'" . $value;
        }

        return $value;
    }
}
