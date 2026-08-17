@if(isset($club))
<form method="POST" action="{{ route('clubs.update', $club->id) }}" enctype="multipart/form-data">
    @method('PUT')
@else
<form method="POST" action="{{ route('clubs.store') }}" enctype="multipart/form-data">
@endif
    @csrf

    <div class="mb-3">
        <label class="form-label">Tên CLB</label>
        <input name="name" value="{{ old('name', $club->name ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Viết tắt</label>
        <input name="short_name" value="{{ old('short_name', $club->short_name ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control">{{ old('description', $club->description ?? '') }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input name="email" value="{{ old('email', $club->email ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input name="phone" value="{{ old('phone', $club->phone ?? '') }}" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Địa điểm</label>
        <input name="location" value="{{ old('location', $club->location ?? '') }}" class="form-control">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Ngày thành lập</label>
            <input type="date" name="founding_date" value="{{ old('founding_date', isset($club->founding_date) ? 
                \Carbon\Carbon::parse($club->founding_date)->format('Y-m-d') : '') }}" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Chủ nhiệm</label>
            <input name="president" value="{{ old('president', $club->president ?? '') }}" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Cố vấn</label>
            <input name="advisor" value="{{ old('advisor', $club->advisor ?? '') }}" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Số tối đa thành viên</label>
        <input type="number" name="max_members" value="{{ old('max_members', $club->max_members ?? '') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Logo (image)</label>
        <input type="file" name="logo" class="form-control">
        @if(!empty($club->logo))
            <div class="mt-2">
                <img src="{{ asset($club->logo) }}" width="100" class="rounded">
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="active" {{ old('status', $club->status ?? '')=='active' ? 'selected':'' }}>Hoạt động</option>
            <option value="inactive" {{ old('status', $club->status ?? '')=='inactive' ? 'selected':'' }}>Tạm dừng</option>
        </select>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Quay lại</a>
        <button class="btn btn-primary">Lưu</button>
    </div>

</form>
