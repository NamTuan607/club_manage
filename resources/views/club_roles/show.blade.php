@extends('layouts.app')
@section('title', $clubRole->role_name)
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4"><div><h1 class="page-title">{{ $clubRole->role_name }}</h1><div class="page-subtitle">{{ $clubRole->club->name ?? '-' }}</div></div><a class="btn btn-primary" href="{{ route('club_roles.edit', $clubRole) }}"><i class="bi bi-pencil me-1"></i>Sửa</a></div>
<div class="card"><div class="card-body"><dl class="row"><dt class="col-sm-3">Câu lạc bộ</dt><dd class="col-sm-9">{{ $clubRole->club->name ?? '-' }}</dd><dt class="col-sm-3">Mô tả</dt><dd class="col-sm-9">{{ $clubRole->description ?: '-' }}</dd></dl><hr><h2 class="h6">Thành viên sử dụng chức vụ này</h2><ul class="mb-0">@forelse($clubRole->members as $member)<li>{{ $member->student->full_name }} ({{ $member->status }})</li>@empty<li class="text-secondary">Chưa có thành viên.</li>@endforelse</ul></div></div>
@endsection
