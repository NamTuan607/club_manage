<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Vai trò CLB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h2 class="text-center mb-4">QUẢN LÝ VAI TRÒ CÂU LẠC BỘ</h2>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Vai trò</th>
            <th>Mô tả</th>
            <th>Cấp quyền</th>
            <th>Quản lý TV</th>
            <th>Tạo sự kiện</th>
            <th>Duyệt TV</th>
        </tr>
        </thead>

        <tbody>

        @forelse($roles as $role)

        <tr>

            <td>{{ $role->id }}</td>

            <td>{{ $role->role_name }}</td>

            <td>{{ $role->description }}</td>

            <td>
                <span class="badge bg-primary">
                    {{ $role->permission_level }}
                </span>
            </td>

            <td>
                {!! $role->can_manage_members
                    ? '<span class="badge bg-success">Có</span>'
                    : '<span class="badge bg-secondary">Không</span>' !!}
            </td>

            <td>
                {!! $role->can_create_events
                    ? '<span class="badge bg-success">Có</span>'
                    : '<span class="badge bg-secondary">Không</span>' !!}
            </td>

            <td>
                {!! $role->can_approve_members
                    ? '<span class="badge bg-success">Có</span>'
                    : '<span class="badge bg-secondary">Không</span>' !!}
            </td>

        </tr>

        @empty

        <tr>
            <td colspan="7" class="text-center">
                Chưa có dữ liệu
            </td>
        </tr>

        @endforelse

        </tbody>
    </table>

</div>

</body>
</html>