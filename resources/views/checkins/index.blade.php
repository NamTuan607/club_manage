@extends('layouts.app')
@section('title', 'Check-in và duyệt hoạt động')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title">Check-in và duyệt hoạt động</h1>
        <div class="page-subtitle">Duyệt check-in sẽ tự tìm quy tắc điểm và tạo điểm sinh viên, không nhập điểm thủ công.</div>
    </div>
    <a class="btn btn-primary" href="{{ route('checkins.create') }}">
        <i class="bi bi-plus-lg me-1"></i>Tạo check-in
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sinh viên</th>
                        <th>Sự kiện</th>
                        <th>Check-in lúc</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Xử lý</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checkins as $checkin)
                        <tr>
                            <td>
                                <strong>{{ $checkin->registration->student->full_name }}</strong>
                                <div class="small text-secondary">{{ $checkin->registration->student->student_code }}</div>
                            </td>
                            <td>
                                {{ $checkin->registration->event->title }}
                                <div class="small text-secondary">{{ $checkin->registration->event->club->short_name ?? $checkin->registration->event->club->name }}</div>
                            </td>
                            <td>{{ $checkin->checkin_time->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge text-bg-{{ $checkin->status === 'approved' ? 'success' : 'warning' }}">
                                    {{ $checkin->status === 'approved' ? 'Đã duyệt' : 'Chờ duyệt' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('checkins.show', $checkin) }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($checkin->status === 'pending')
                                    <form class="d-inline" method="POST" action="{{ route('checkins.approve', $checkin) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Duyệt & cộng điểm</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state text-center">Chưa có check-in.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $checkins->links() }}
        </div>
    </div>
</div>
@endsection