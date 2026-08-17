<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thành viên CLB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">QUẢN LÝ VAI TRÒ CÂU LẠC BỘ</h2>
    <a href="{{ route('club_roles.create') }}" class="btn btn-success">Tạo vai trò</a>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Vai trò</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>
    </thead>
    <tbody>
    @forelse($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->role_name }}</td>
            <td>{{ $role->description }}</td>
            <td>
                <a href="{{ route('club_roles.show', $role->id) }}" class="btn btn-sm btn-info">Xem</a>
                <a href="{{ route('club_roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                <form action="{{ route('club_roles.destroy', $role->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">Chưa có dữ liệu</td>
        </tr>
    @endforelse
    </tbody>
</table>

</div>

</body>
</html>