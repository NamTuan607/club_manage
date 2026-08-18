@extends('layouts.app')
@section('title', 'Sự kiện')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title">Danh sách sự kiện</h1>
        <div class="page-subtitle">CLB đề xuất sự kiện, cán bộ thực hiện duyệt</div>
    </div>
    <a class="btn btn-primary" href="{{ route('events.create') }}">
        <i class="bi bi-plus-lg me-1"></i>Thêm sự kiện
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sự kiện</th>
                        <th>CLB tổ chức</th>
                        <th>Thời gian</th>
                        <th>Sức chứa</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>
                                <strong>{{ $event->title }}</strong>
                                <div class="small text-secondary">{{ $event->category->name }} · {{ $event->location }}</div>
                            </td>
                            <td>{{ $event->club->short_name ?? $event->club->name }}</td>
                            <td>
                                {{ $event->start_time->format('d/m/Y H:i') }}
                                <div class="small text-secondary">đến {{ $event->end_time->format('d/m/Y H:i') }}</div>
                            </td>
                            <td>{{ $event->registered_count }}/{{ $event->capacity }}</td>
                            <td>
                                @php($class = ['approved'=>'success','pending'=>'warning','rejected'=>'danger','completed'=>'primary'][$event->status] ?? 'secondary')
                                <span class="badge text-bg-{{ $class }}">
                                    {{ ['approved'=>'Đã duyệt','pending'=>'Chờ duyệt','rejected'=>'Từ chối','completed'=>'Đã hoàn thành'][$event->status] ?? $event->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('events.show', $event) }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('events.edit', $event) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form class="d-inline" method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Xóa sự kiện này?')">
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
                            <td colspan="6" class="empty-state text-center">Chưa có sự kiện.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection