@extends('layouts.app')
@section('title', 'Chi tiết phê duyệt sự kiện')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Chi tiết phê duyệt sự kiện</h1>
    <div class="page-subtitle">{{ $eventApproval->event->title }}</div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Sự kiện</dt>
            <dd class="col-sm-9">
                <a href="{{ route('events.show', $eventApproval->event) }}">{{ $eventApproval->event->title }}</a>
            </dd>
            
            <dt class="col-sm-3">CLB</dt>
            <dd class="col-sm-9">{{ $eventApproval->event->club->name }}</dd>
            
            <dt class="col-sm-3">Loại sự kiện</dt>
            <dd class="col-sm-9">{{ $eventApproval->event->category->name }}</dd>
            
            <dt class="col-sm-3">Người xử lý</dt>
            <dd class="col-sm-9">{{ $eventApproval->approver->name }}</dd>
            
            <dt class="col-sm-3">Kết quả</dt>
            <dd class="col-sm-9">{{ $eventApproval->status === 'approved' ? 'Đã duyệt' : 'Từ chối' }}</dd>
            
            <dt class="col-sm-3">Thời gian</dt>
            <dd class="col-sm-9">{{ $eventApproval->approved_at?->format('d/m/Y H:i') }}</dd>
            
            <dt class="col-sm-3">Ghi chú</dt>
            <dd class="col-sm-9">{{ $eventApproval->note ?: '-' }}</dd>
        </dl>
    </div>
</div>
@endsection