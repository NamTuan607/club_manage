<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Thành viên CLB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">QUẢN LÝ THÀNH VIÊN CÂU LẠC BỘ</h2>
        <a href="{{ route('club_members.create') }}" class="btn btn-success">Thêm thành viên</a>
    </div>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>CLB</th>
            <th>Sinh viên</th>
            <th>Vai trò</th>
            <th>Ngày tham gia</th>
            <th>Trạng thái</th>
            <th>Năm học</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
        </thead>

        <tbody>

        @forelse($members as $member)

            <tr>

                <td>{{ $member->id }}</td>

                <td>{{ $member->club->name ?? '-' }}</td>

                <td>{{ $member->student->full_name ?? '-' }}</td>

                <td>{{ $member->clubRole->role_name ?? '-' }}</td>

                <td>{{ $member->join_date }}</td>

                <td>

                    @if($member->status=='active')

                        <span class="badge bg-success">Hoạt động</span>

                    @elseif($member->status=='pending')

                        <span class="badge bg-warning">Đang chờ</span>

                    @else

                        <span class="badge bg-danger">Ngừng</span>

                    @endif

                </td>

                <td>{{ $member->academic_year }}</td>

                <td>{{ Str::limit($member->note,50) }}</td>

                <td>
                    <a href="{{ route('club_members.show', $member->id) }}" class="btn btn-sm btn-info">Xem</a>
                    <a href="{{ route('club_members.edit', $member->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <form action="{{ route('club_members.destroy', $member->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="9" class="text-center">Chưa có dữ liệu.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

</div>

</body>
</html>
