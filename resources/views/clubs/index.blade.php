<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách Câu lạc bộ</title>
</head>
<body>

    <h2>Danh sách Câu lạc bộ</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Tên CLB</th>
            <th>Mô tả</th>
        </tr>

        @forelse($clubs as $club)
            <tr>
                <td>{{ $club->id }}</td>
                <td>{{ $club->name }}</td>
                <td>{{ $club->description }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Chưa có dữ liệu.</td>
            </tr>
        @endforelse
    </table>

</body>
</html>