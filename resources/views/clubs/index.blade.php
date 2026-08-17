<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Câu lạc bộ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-4 text-center">QUẢN LÝ CÂU LẠC BỘ</h2>

    {{-- Dashboard --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h6>Tổng CLB</h6>
                    <h3>{{ $clubs->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h6>Đang hoạt động</h6>
                    <h3>{{ $clubs->where('status','active')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h6>Tổng sức chứa</h6>
                    <h3>{{ $clubs->sum('max_members') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-info">
                <div class="card-body">
                    <h6>Cố vấn</h6>
                    <h3>{{ $clubs->count() }}</h3>
                </div>
            </div>
        </div>

    </div>

    <table class="table table-bordered table-hover align-middle bg-white">

        <thead class="table-dark">

        <tr>
            <th>ID</th>
            <th>Logo</th>
            <th>Tên CLB</th>
            <th>Viết tắt</th>
            <th>Chủ nhiệm</th>
            <th>Cố vấn</th>
            <th>Phòng</th>
            <th>Email</th>
            <th>Ngày thành lập</th>
            <th>SL tối đa</th>
            <th>Trạng thái</th>
        </tr>

        </thead>

        <tbody>

        @forelse($clubs as $club)

            <tr>

                <td>{{ $club->id }}</td>

                <td>
                    @if($club->logo)
                        <img src="{{ asset($club->logo) }}"
                             width="50"
                             height="50"
                             class="rounded">
                    @else
                        Không có
                    @endif
                </td>

                <td>{{ $club->name }}</td>

                <td>{{ $club->short_name }}</td>

                <td>{{ $club->president }}</td>

                <td>{{ $club->advisor }}</td>

                <td>{{ $club->location }}</td>

                <td>{{ $club->email }}</td>

                <td>{{ $club->founding_date }}</td>

                <td>{{ $club->max_members }}</td>

                <td>

                    @if($club->status=='active')

                        <span class="badge bg-success">
                            Hoạt động
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Tạm dừng
                        </span>

                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="11" class="text-center">
                    Chưa có dữ liệu.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>