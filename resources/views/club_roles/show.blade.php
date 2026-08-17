<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết vai trò</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4 text-center">CHI TIẾT VAI TRÒ</h2>

    <div class="card bg-white p-4">
        <div class="mb-3">
            <a href="{{ route('club_roles.index') }}" class="btn btn-secondary">Quay lại</a>
            <a href="{{ route('club_roles.edit', $role->id) }}" class="btn btn-primary">Chỉnh sửa</a>
        </div>

        <table class="table">
            <tr><th>ID</th><td>{{ $role->id }}</td></tr>
            <tr><th>Tên vai trò</th><td>{{ $role->role_name }}</td></tr>
            <tr><th>Mô tả</th><td>{{ $role->description }}</td></tr>
            <tr><th>Thời gian tạo</th><td>{{ $role->created_at }}</td></tr>
        </table>
    </div>
</div>
</body>
</html>
