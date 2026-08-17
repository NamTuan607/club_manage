@if(isset($role))
    <form action="{{ route('club_roles.update', $role->id) }}" method="POST">
        @method('PUT')
@else
    <form action="{{ route('club_roles.store') }}" method="POST">
@endif
    @csrf

    <div class="mb-3">
        <label class="form-label">Tên vai trò</label>
        <input name="role_name" value="{{ old('role_name', $role->role_name ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control">{{ old('description', $role->description ?? '') }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('club_roles.index') }}" class="btn btn-secondary">Quay lại</a>
        <button class="btn btn-primary">Lưu</button>
    </div>

</form>
