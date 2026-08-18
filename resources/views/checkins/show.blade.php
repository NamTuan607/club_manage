@extends('layouts.app')
@section('title', 'Chi tiết check-in')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title">Chi tiết check-in</h1>
        <div class="page-subtitle">{{ $checkin->registration->student->full_name }} · {{ $checkin->registration->event->title }}</div>
    </div>
    @if($checkin->status === 'pending')
        <form method="POST" action="{{ route('checkins.approve', $checkin) }}">
            @csrf
            <button class="btn btn-success">Duyệt & tự động cộng điểm</button>
        </form>
    @endif
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5">Sinh viên</dt>
                    <dd class="col-7">{{ $checkin->registration->student->full_name }}</dd>
                    
                    <dt class="col-5">Sự kiện</dt>
                    <dd class="col-7">{{ $checkin->registration->event->title }}</dd>
                    
                    <dt class="col-5">Loại</dt>
                    <dd class="col-7">{{ $checkin->registration->event->category->name }}</dd>
                    
                    <dt class="col-5">Thời gian</dt>
                    <dd class="col-7">{{ $checkin->checkin_time->format('d/m/Y H:i') }}</dd>
                    
                    <dt class="col-5">Trạng thái</dt>
                    <dd class="col-7">{{ $checkin->status === 'approved' ? 'Đã duyệt' : 'Chờ duyệt' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h6">Lịch sử check-in của sinh viên</h2>
                <ul class="list-group list-group-flush">
                    @forelse($history as $item)
                        <li class="list-group-item px-0">
                            <strong>{{ $item->registration->event->title }}</strong>
                            <div class="small text-secondary">{{ $item->checkin_time->format('d/m/Y H:i') }} · {{ $item->status }}</div>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-secondary">Chưa có lịch sử.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection