@extends('layouts.app')

@section('title', 'Duyệt yêu cầu tham gia CLB')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title">Duyệt yêu cầu tham gia CLB</h1>
        <div class="page-subtitle">Chỉ duyệt khi CLB còn sức chứa; hệ thống cũng kiểm tra lại ở backend.</div></div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
<thead>
    <tr>
        <th>Sinh viên</th>
        <th>Câu lạc bộ</th>
        <th>Sức chứa</th>
        <th>Ngày gửi</th>
        <th>Trạng thái</th>
        <th class="text-end">Xử lý</th>
    </tr>
</thead>
<tbody>
    @forelse($requests as $membershipRequest)
    @php($isFull = $membershipRequest->club->members_count >= $membershipRequest->club->capacity)
    <tr>
        <td><strong>{{ $membershipRequest->student->full_name }}</strong><div class="small text-secondary">{{ $membershipRequest->student->student_code }} · {{ $membershipRequest->student->class }}</div></td>
        <td>{{ $membershipRequest->club->name }}</td>
        <td><strong>{{ $membershipRequest->club->members_count }}/{{ $membershipRequest->club->capacity }}</strong>@if($isFull)<div><span class="badge text-bg-danger">CLB đã đầy</span></div>@endif</td>
        <td>{{ $membershipRequest->requested_at?->format('d/m/Y H:i') }}</td>
        <td>@php($badge = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'][$membershipRequest->status])<span class="badge text-bg-{{ $badge }}">{{ ['pending' => 'Chờ duyệt', 'approved' => 'Đã duyệt', 'rejected' => 'Từ chối'][$membershipRequest->status] }}</span>
    </td>
        <td class="text-end">@if($membershipRequest->status === 'pending')
            <form class="d-inline" method="POST" action="{{ route('membership-requests.approve', $membershipRequest) }}">
                @csrf
                <button class="btn btn-sm btn-success" @disabled($isFull) title="{{ $isFull ? 'CLB đã đầy' : 'Duyệt yêu cầu' }}">Duyệt</button>
            </form>
            <form class="d-inline" method="POST" action="{{ route('membership-requests.reject', $membershipRequest) }}">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Từ chối</button></form>
        @else 
        <span class="text-secondary small">{{ $membershipRequest->reviewer?->name ?? 'Admin' }}</span>
        @endif
    </td>
    </tr>
@empty<tr><td colspan="6" class="empty-state text-center">Chưa có yêu cầu tham gia.</td></tr>@endforelse</tbody>
</table></div><div class="mt-3">{{ $requests->links() }}</div></div></div>
@endsection
