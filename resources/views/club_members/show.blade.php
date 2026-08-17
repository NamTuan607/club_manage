<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết thành viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h2 class="text-center mb-4">CHI TIẾT THÀNH VIÊN</h2>

    <div class="card bg-white p-4">

        <div class="mb-3">
            <a href="{{ route('club_members.index') }}" class="btn btn-secondary">Quay lại</a>
            <a href="{{ route('club_members.edit', $member->id) }}" class="btn btn-primary">Chỉnh sửa</a>
        </div>

        <table class="table">
            <tr><th>ID</th><td>{{ $member->id }}</td></tr>
            <tr><th>CLB</th><td>{{ $member->club->name ?? '-' }}</td></tr>
            <tr><th>Sinh viên</th><td>{{ $member->student->full_name ?? '-' }}</td></tr>
            <tr><th>Vai trò</th><td>{{ $member->clubRole->role_name ?? '-' }}</td></tr>
            <tr><th>Ngày tham gia</th><td>{{ $member->join_date }}</td></tr>
            <tr><th>Ngày rời</th><td>{{ $member->leave_date ?? '-' }}</td></tr>
            <tr><th>Trạng thái</th><td>{{ $member->status }}</td></tr>
            <tr><th>Năm học</th><td>{{ $member->academic_year }}</td></tr>
            <tr><th>Ghi chú</th><td>{{ $member->note }}</td></tr>
        </table>

    </div>

</div>

</body>
</html>
