<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thành viên CLB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-4">

<h2 class="text-center mb-4">
DANH SÁCH THÀNH VIÊN CÂU LẠC BỘ
</h2>

<table class="table table-bordered table-hover bg-white">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>CLB</th>

<th>Sinh viên</th>

<th>Vai trò</th>

<th>Ngày tham gia</th>

<th>Trạng thái</th>

</tr>

</thead>

<tbody>

@forelse($members as $member)

<tr>

<td>{{ $member->id }}</td>

<td>{{ $member->club->name }}</td>

<td>{{ $member->student->full_name }}</td>

<td>

<span class="badge bg-info">

{{ $member->clubRole->role_name }}

</span>

</td>

<td>

{{ $member->join_date }}

</td>

<td>

@if($member->status=='active')

<span class="badge bg-success">

Hoạt động

</span>

@elseif($member->status=='pending')

<span class="badge bg-warning">

Đang chờ

</span>

@else

<span class="badge bg-danger">

Ngừng

</span>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center">

Chưa có dữ liệu

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</body>
</html>