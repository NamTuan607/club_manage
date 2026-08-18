@extends('layouts.app')
@section('title', 'Cập nhật chứng nhận')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Cập nhật chứng nhận</h1>
    <div class="page-subtitle">{{ $certificate->studentPoint->student->full_name }} · {{ $certificate->studentPoint->event->title }}</div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('certificates.update', $certificate) }}">
            @csrf 
            @method('PUT') 
            @include('partials.form-errors')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label required">Mã chứng nhận</label>
                    <input class="form-control" name="certificate_code" value="{{ old('certificate_code', $certificate->certificate_code) }}" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Ngày cấp</label>
                    <input class="form-control" type="date" name="issued_at" value="{{ old('issued_at', $certificate->issued_at->format('Y-m-d')) }}" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="valid" @selected(old('status', $certificate->status) === 'valid')>Có hiệu lực</option>
                        <option value="revoked" @selected(old('status', $certificate->status) === 'revoked')>Thu hồi</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a class="btn btn-light border" href="{{ route('certificates.show', $certificate) }}">Hủy</a>
                <button class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection