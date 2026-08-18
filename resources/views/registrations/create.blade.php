@extends('layouts.app')
@section('title', 'Tạo đăng ký sự kiện')
@section('content')
<div class="mb-4"><h1 class="page-title">Tạo đăng ký sự kiện</h1><div class="page-subtitle">Chỉ hiển thị sự kiện đã duyệt; hệ thống từ chối đăng ký trùng hoặc vượt sức chứa.</div></div>
<div class="card"><div class="card-body"><form method="POST" action="{{ route('registrations.store') }}">@csrf
@include('partials.form-errors')
<div class="row g-3"><div class="col-md-6"><label class="form-label required">Sự kiện</label><select class="form-select" name="event_id" required><option value="">-- Chọn sự kiện --</option>@foreach($events as $event)<option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }} ({{ $event->club->short_name ?? $event->club->name }})</option>@endforeach</select></div><div class="col-md-6"><label class="form-label required">Sinh viên</label><select class="form-select" name="student_id" required><option value="">-- Chọn sinh viên --</option>@foreach($students as $student)<option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->student_code }} - {{ $student->full_name }}</option>@endforeach</select></div></div><div class="mt-4 d-flex justify-content-end gap-2"><a class="btn btn-light border" href="{{ route('registrations.index') }}">Hủy</a><button class="btn btn-primary">Lưu đăng ký</button></div>
</form></div></div>
@endsection
