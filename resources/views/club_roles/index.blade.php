@extends('layouts.app')
@section('title', 'Chức vụ CLB')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title">Danh sách chức vụ CLB</h1>
        <div class="page-subtitle">Mỗi chức vụ thuộc một câu lạc bộ</div>
    </div>
    <a class="btn btn-primary" href="{{ route('club_roles.create') }}">
        <i class="bi bi-plus-lg me-1"></i>Thêm chức vụ
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Chức vụ</th>
                        <th>CLB</th>
                        <th>Mô tả</th>
                        <th>Thành viên</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $clubRole)
                        <tr>
                            <td>
                                <strong>{{ $clubRole->role_name }}</strong>
                            </td>
                            <td>{{ $clubRole->club->name ?? 'Dữ liệu cũ chưa gán CLB' }}</td>
                            <td>{{ $clubRole->description ?: '-' }}</td>
                            <td>{{ $clubRole->members_count }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('club_roles.show', $clubRole) }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('club_roles.edit', $clubRole) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form class="d-inline" action="{{ route('club_roles.destroy', $clubRole) }}" method="POST" onsubmit="return confirm('Xóa chức vụ này?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state text-center">Chưa có chức vụ.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection