@include('partials.form-errors')

<form method="POST" action="{{ isset($eventCategory) ? route('event-categories.update', $eventCategory) : route('event-categories.store') }}">
    @csrf 
    
    @isset($eventCategory) 
        @method('PUT') 
    @endisset

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label required">Tên loại sự kiện</label>
            <input class="form-control" name="name" value="{{ old('name', $eventCategory->name ?? '') }}" required>
        </div>
        
        <div class="col-md-3">
            <label class="form-label required">Điểm tối đa</label>
            <input class="form-control" type="number" min="1" name="max_points" value="{{ old('max_points', $eventCategory->max_points ?? 50) }}" required>
        </div>
        
        <div class="col-md-3">
            <label class="form-label required">Trạng thái</label>
            <select class="form-select" name="status">
                <option value="active" @selected(old('status', $eventCategory->status ?? 'active') === 'active')>Hoạt động</option>
                <option value="inactive" @selected(old('status', $eventCategory->status ?? '') === 'inactive')>Tạm dừng</option>
            </select>
        </div>
        
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="4" name="description">{{ old('description', $eventCategory->description ?? '') }}</textarea>
        </div>
    </div>
    
    <div class="mt-4 d-flex justify-content-end gap-2">
        <a class="btn btn-light border" href="{{ isset($eventCategory) ? route('event-categories.show', $eventCategory) : route('event-categories.index') }}">Hủy</a>
        <button class="btn btn-primary">Lưu</button>
    </div>
</form>