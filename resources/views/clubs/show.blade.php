<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết CLB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">CHI TIẾT CÂU LẠC BỘ</h2>
    <div class="card bg-white p-4">
        <div class="mb-3">
            <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Quay lại</a>
            <a href="{{ route('clubs.edit', $club->id) }}" class="btn btn-primary">Chỉnh sửa</a>
        </div>
        <table class="table">
            <tr><th>ID</th><td>{{ $club->id }}</td></tr>
            <tr><th>Tên</th><td>{{ $club->name }}</td></tr>
            <tr><th>Viết tắt</th><td>{{ $club->short_name }}</td></tr>
            <tr><th>Mô tả</th><td>{{ $club->description }}</td></tr>
            <tr><th>Email</th><td>{{ $club->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $club->phone }}</td></tr>
            <tr><th>Địa điểm</th><td>{{ $club->location }}</td></tr>
            <tr><th>Ngày thành lập</th><td>{{ $club->founding_date }}</td></tr>
            <tr><th>Chủ nhiệm</th><td>{{ $club->president }}</td></tr>
            <tr><th>Cố vấn</th><td>{{ $club->advisor }}</td></tr>
            <tr><th>SL tối đa</th><td>{{ $club->max_members }}</td></tr>
            <tr><th>Trạng thái</th><td>{{ $club->status }}</td></tr>
            <tr><th>Logo</th><td>@if($club->logo)<img src="{{ asset($club->logo) }}" width="150" class="rounded">@else Không có @endif</td></tr>
        </table>
        <div class="card bg-white p-4 mt-4">
            <h4>Thành viên CLB</h4>

            @if($club->members->isEmpty())
                <div class="text-muted">Chưa có thành viên.</div>
            @else
                <table class="table table-sm table-bordered mt-2">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Sinh viên</th>
                            <th>Vai trò</th>
                            <th>Ngày tham gia</th>
                            <th>Trạng thái</th>
                            <th>Năm học</th>
                            <th>Ghi chú</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($club->members as $m)
                        <tr>
                            <td>{{ $m->id }}</td>
                            <td>{{ $m->student->full_name ?? '-' }}</td>
                            <td>{{ $m->clubRole->role_name ?? '-' }}</td>
                            <td>{{ $m->join_date }}</td>
                            <td>{{ $m->status }}</td>
                            <td>{{ $m->academic_year }}</td>
                            <td>{{ Str::limit($m->note,50) }}</td>
                            <td>
                                <a href="{{ route('club_members.show', $m->id) }}" class="btn btn-sm btn-info">Xem</a>
                                <a href="{{ route('club_members.edit', $m->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
</body>
</html>
