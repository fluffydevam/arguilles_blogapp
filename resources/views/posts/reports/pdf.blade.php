<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Post Report</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 10px;
            color: #222;
            line-height: 1.4;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
            color: #1f2937;
        }
        .subtitle {
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 15px;
            background: #f9fafb;
            padding: 10px;
            border: 1px solid #e5e7eb;
        }
        .details p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #9ca3af;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }
        th {
            background-color: #e5e7eb;
            font-weight: bold;
            color: #111827;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <h1>Blog Post Summary Report</h1>
    <div class="subtitle">Generated Application Analytics</div>

    <div class="details">
        <p><strong>Prepared by:</strong> {{ Auth::check() ? Auth::user()->name : 'System Administrator' }}</p>
        <p>
            <strong>Date Range:</strong>
            @if (!$startDate && !$endDate)
                All Available Dates
            @else
                {{ $startDate ?: 'Beginning' }} to {{ $endDate ?: 'Present' }}
            @endif
        </p>
        <p><strong>Generated At:</strong> {{ $generatedAt }}</p>
        <p><strong>Total Matching Posts:</strong> {{ $totalPosts }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th style="width: 24%;">Title</th>
                <th style="width: 16%;">Category</th>
                <th style="width: 16%;">Author</th>
                <th style="width: 22%;">Body Preview</th>
                <th style="width: 16%;">Published At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category ?? 'N/A' }}</td>
                    <td>{{ $post->author ?? 'Unknown' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->body, 45) }}</td>
                    <td>{{ $post->published_at ? $post->published_at->format('M d, Y H:i') : $post->created_at->format('M d, Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #6b7280; padding: 15px;">
                        No posts found for the selected date filters.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
