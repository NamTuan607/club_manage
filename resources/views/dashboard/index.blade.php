@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Dashboard</h1>
    <div class="page-subtitle">Tổng quan hoạt động của hệ thống</div>
</div>
<div class="row g-3 mb-4">
    @foreach([['CLB','clubs','bi-people'], ['Sinh viên','students','bi-person-vcard'], ['Sự kiện','events','bi-calendar-event'], ['Đăng ký','registrations','bi-clipboard-check'], ['Check-in','checkins','bi-box-arrow-in-right'], ['Tổng điểm','points','bi-award'], ['Chứng nhận','certificates','bi-patch-check']] as [$label, $key, $icon])
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="text-secondary small">{{ $label }}</div><div class="stat-value">{{ $statistics[$key] }}</div></div><i class="bi {{ $icon }} fs-2 text-primary opacity-75"></i></div></div>
        </div>
    @endforeach
</div>
<div class="row g-3 mb-4">
    @foreach([['Yêu cầu CLB chờ duyệt', 'pending_memberships', 'membership-requests.index'], ['Sự kiện chờ duyệt', 'pending_events', 'event-approvals.index'], ['Check-in chờ duyệt', 'pending_checkins', 'checkins.index']] as [$label, $key, $route])
        <div class="col-md-4"><a class="card text-decoration-none" href="{{ route($route) }}"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="text-secondary small">{{ $label }}</div><div class="stat-value text-warning">{{ $statistics[$key] }}</div></div><i class="bi bi-hourglass-split fs-2 text-warning opacity-75"></i></div></a></div>
    @endforeach
</div>
<div class="row g-4">
    <div class="col-lg-7"><div class="card"><div class="card-body"><div class="d-flex justify-content-between mb-3"><h2 class="h6 mb-0">Sự kiện gần đây</h2><a href="{{ route('events.index') }}">Xem tất cả</a></div><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Sự kiện</th><th>CLB</th><th>Thời gian</th><th>Trạng thái</th></tr></thead><tbody>@forelse($upcomingEvents as $event)<tr><td><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a><div class="small text-secondary">{{ $event->category->name }}</div></td><td>{{ $event->club->short_name ?? $event->club->name }}</td><td>{{ $event->start_time->format('d/m/Y H:i') }}</td><td><span class="badge text-bg-{{ $event->status === 'approved' ? 'success' : 'warning' }}">{{ $event->status === 'approved' ? 'Đã duyệt' : 'Chờ duyệt' }}</span></td></tr>@empty<tr><td colspan="4" class="empty-state text-center">Chưa có sự kiện.</td></tr>@endforelse</tbody></table></div></div></div></div>
    <div class="col-lg-5"><div class="card"><div class="card-body"><h2 class="h6 mb-3">Đăng ký mới</h2>@forelse($recentRegistrations as $registration)<div class="border-bottom py-2"><strong>{{ $registration->student->full_name }}</strong><div class="small text-secondary">{{ $registration->event->title }} · {{ $registration->registered_at->format('d/m/Y H:i') }}</div></div>@empty<div class="text-secondary">Chưa có đăng ký.</div>@endforelse</div></div></div>
</div>
@endsection
