@extends('layouts.app')
@section('title', $club->name)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title">{{ $club->name }}</h1>
        <div class="page-subtitle">{{ $club->short_name }} · {{ $club->status === 'active' ? 'Đang hoạt động' : 'Tạm dừng' }}</div>
    </div>
    <a class="btn btn-primary" href="{{ route('clubs.edit', $club) }}">
        <i class="bi bi-pencil me-1"></i>Sửa
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 mb-3">Thông tin CLB</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Email</dt>
                    <dd class="col-7">{{ $club->email ?: '-' }}</dd>
                    
                    <dt class="col-5">Điện thoại</dt>
                    <dd class="col-7">{{ $club->phone ?: '-' }}</dd>
                    
                    <dt class="col-5">Địa điểm</dt>
                    <dd class="col-7">{{ $club->location ?: '-' }}</dd>
                    
                    <dt class="col-5">Thành lập</dt>
                    <dd class="col-7">{{ $club->founding_date ?: '-' }}</dd>
                    
                    <dt class="col-5">Chủ nhiệm</dt>
                    <dd class="col-7">{{ $club->president ?: '-' }}</dd>
                    
                    <dt class="col-5">Cố vấn</dt>
                    <dd class="col-7">{{ $club->advisor ?: '-' }}</dd>
                </dl>
                <hr>
                <p class="mb-0">{{ $club->description ?: 'Chưa có mô tả.' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2 class="h6">Thành viên ({{ $club->members->count() }})</h2>
                    <a href="{{ route('club_members.create') }}">Thêm thành viên</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Sinh viên</th>
                                <th>Chức vụ</th>
                                <th>Ngày tham gia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($club->members as $member)
                                <tr>
                                    <td>{{ $member->student->full_name }}</td>
                                    <td>{{ $member->clubRole->role_name }}</td>
                                    <td>{{ $member->join_date->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-secondary">Chưa có thành viên.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h2 class="h6">Sự kiện của CLB</h2>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Sự kiện</th>
                                <th>Loại</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($club->events as $event)
                                <tr>
                                    <td>
                                        <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                                    </td>
                                    <td>{{ $event->category->name }}</td>
                                    <td>{{ $event->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-secondary">Chưa có sự kiện.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection