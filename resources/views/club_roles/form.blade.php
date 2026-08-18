@include('partials.form-errors')

<form method="POST" action="{{ isset($clubRole) ? route('club_roles.update', $clubRole) : route('club_roles.store') }}">
    @csrf 
    
    @isset($clubRole) 
        @method('PUT') 
    @endisset

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label required">Câu lạc bộ</label>
            <select class="form-select" name="club_id" required>
                <option value="">-- Chọn CLB --</option>
                @foreach($clubs as $club)
                    <option value="{{ $club->id }}" @selected(old('club_id', $clubRole->club_id ?? '') == $club->id)>
                        {{ $club->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label required">Tên chức vụ</label>
            <input class="form-control" name="role_name" value="{{ old('role_name', $clubRole->role_name ?? '') }}" required>
        </div>

        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" rows="4">{{ old('description', $clubRole->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end gap-2">
        <a class="btn btn-light border" href="{{ isset($clubRole) ? route('club_roles.show', $clubRole) : route('club_roles.index') }}">Hủy</a>
        <button class="btn btn-primary">Lưu</button>
    </div>
</form>