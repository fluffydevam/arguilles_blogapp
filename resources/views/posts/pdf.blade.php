<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Posts Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Blog Posts Report</h2>
    <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Published Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category }}</td>
                    <td>{{ $post->author }}</td>
                    <td>{{ $post->published_at ? $post->published_at->format('M d, Y H:i') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
