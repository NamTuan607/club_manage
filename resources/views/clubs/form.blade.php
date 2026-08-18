@include('partials.form-errors')

<form method="POST" action="{{ isset($club) ? route('clubs.update', $club) : route('clubs.store') }}" enctype="multipart/form-data">
    @csrf 
    
    @isset($club) 
        @method('PUT') 
    @endisset

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label required">Tên câu lạc bộ</label>
            <input class="form-control" name="name" value="{{ old('name', $club->name ?? '') }}" required>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Viết tắt</label>
            <input class="form-control" name="short_name" value="{{ old('short_name', $club->short_name ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $club->email ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input class="form-control" name="phone" value="{{ old('phone', $club->phone ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Địa điểm</label>
            <input class="form-control" name="location" value="{{ old('location', $club->location ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Ngày thành lập</label>
            <input class="form-control" type="date" name="founding_date" value="{{ old('founding_date', $club->founding_date ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Chủ nhiệm</label>
            <input class="form-control" name="president" value="{{ old('president', $club->president ?? '') }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Cố vấn</label>
            <input class="form-control" name="advisor" value="{{ old('advisor', $club->advisor ?? '') }}">
        </div>
        
        <div class="col-md-4">
            <label class="form-label required">Số thành viên tối đa</label>
            <input class="form-control" type="number" min="1" name="max_members" value="{{ old('max_members', $club->max_members ?? 100) }}" required>
        </div>
        
        <div class="col-md-4">
            <label class="form-label required">Trạng thái</label>
            <select class="form-select" name="status">
                <option value="active" @selected(old('status', $club->status ?? 'active') === 'active')>Hoạt động</option>
                <option value="inactive" @selected(old('status', $club->status ?? '') === 'inactive')>Tạm dừng</option>
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Logo</label>
            <input class="form-control" type="file" name="logo" accept="image/*">
            @if(!empty($club?->logo))
                <div class="small mt-1">
                    <a href="{{ asset($club->logo) }}" target="_blank">Xem logo hiện tại</a>
                </div>
            @endif
        </div>
        
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" rows="4">{{ old('description', $club->description ?? '') }}</textarea>
        </div>
    </div>
    
    <div class="mt-4 d-flex justify-content-end gap-2">
        <a class="btn btn-light border" href="{{ isset($club) ? route('clubs.show', $club) : route('clubs.index') }}">Hủy</a>
        <button class="btn btn-primary">
            <i class="bi bi-save me-1"></i>Lưu
        </button>
    </div>
</form>