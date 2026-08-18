@extends('layouts.app')

@section('title', 'Câu lạc bộ')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4"><div><h1 class="page-title">Danh sách câu lạc bộ</h1><div class="page-subtitle">Quản lý thông tin, thành viên và sự kiện của CLB</div></div><a class="btn btn-primary" href="{{ route('clubs.create') }}"><i class="bi bi-plus-lg me-1"></i>Thêm câu lạc bộ</a></div>
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>CLB</th><th>Liên hệ</th><th>Thành viên</th><th>Sự kiện</th><th>Trạng thái</th><th class="text-end">Thao tác</th></tr></thead><tbody>
@forelse($clubs as $club)
<tr><td><div class="d-flex align-items-center gap-2">@if($club->logo)<img src="{{ asset($club->logo) }}" class="rounded-circle object-fit-cover" width="38" height="38">@else<div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:38px;height:38px"><i class="bi bi-people"></i></div>@endif<div><strong>{{ $club->name }}</strong><div class="small text-secondary">{{ $club->short_name ?: 'Chưa có viết tắt' }}</div></div></div></td><td>{{ $club->email ?: '-' }}<div class="small text-secondary">{{ $club->phone }}</div></td><td>{{ $club->members_count }}/{{ $club->max_members }}</td><td>{{ $club->events_count }}</td><td><span class="badge text-bg-{{ $club->status === 'active' ? 'success' : 'secondary' }}">{{ $club->status === 'active' ? 'Hoạt động' : 'Tạm dừng' }}</span></td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('clubs.show', $club) }}"><i class="bi bi-eye"></i></a><a class="btn btn-sm btn-outline-secondary" href="{{ route('clubs.edit', $club) }}"><i class="bi bi-pencil"></i></a><form class="d-inline" action="{{ route('clubs.destroy', $club) }}" method="POST" onsubmit="return confirm('Xóa câu lạc bộ này?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
@empty<tr><td colspan="6" class="empty-state text-center">Chưa có câu lạc bộ.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $clubs->links() }}</div></div></div>
@endsection
