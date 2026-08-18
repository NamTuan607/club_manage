@include('partials.form-errors')

<form method="POST" action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}">
    @csrf 
    
    @isset($event) 
        @method('PUT') 
    @endisset

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label required">Tên sự kiện</label>
            <input class="form-control" name="title" value="{{ old('title', $event->title ?? '') }}" required>
        </div>
        
        <div class="col-md-3">
            <label class="form-label required">CLB tổ chức</label>
            <select class="form-select" name="club_id" required>
                <option value="">-- Chọn CLB --</option>
                @foreach($clubs as $club)
                    <option value="{{ $club->id }}" @selected(old('club_id', $event->club_id ?? '') == $club->id)>
                        {{ $club->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-3">
            <label class="form-label required">Loại sự kiện</label>
            <select class="form-select" name="category_id" required>
                <option value="">-- Chọn loại --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $event->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-6">
            <label class="form-label required">Thời gian bắt đầu</label>
            <input class="form-control" type="datetime-local" name="start_time" value="{{ old('start_time', isset($event) ? $event->start_time->format('Y-m-d\TH:i') : '') }}" required>
        </div>
        
        <div class="col-md-6">
            <label class="form-label required">Thời gian kết thúc</label>
            <input class="form-control" type="datetime-local" name="end_time" value="{{ old('end_time', isset($event) ? $event->end_time->format('Y-m-d\TH:i') : '') }}" required>
        </div>
        
        <div class="col-md-8">
            <label class="form-label required">Địa điểm</label>
            <input class="form-control" name="location" value="{{ old('location', $event->location ?? '') }}" required>
        </div>
        
        <div class="col-md-4">
            <label class="form-label required">Sức chứa</label>
            <input class="form-control" type="number" min="1" name="capacity" value="{{ old('capacity', $event->capacity ?? 50) }}" required>
        </div>
        
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" rows="5">{{ old('description', $event->description ?? '') }}</textarea>
        </div>
    </div>
    
    <div class="alert alert-info mt-3 mb-0 small">
        <i class="bi bi-info-circle me-1"></i>Sự kiện mới hoặc được sửa sẽ ở trạng thái <strong>chờ duyệt</strong>.
    </div>
    
    <div class="mt-4 d-flex justify-content-end gap-2">
        <a class="btn btn-light border" href="{{ isset($event) ? route('events.show', $event) : route('events.index') }}">Hủy</a>
        <button class="btn btn-primary">Lưu sự kiện</button>
    </div>
</form>