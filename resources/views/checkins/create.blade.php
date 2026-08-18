@extends('layouts.app')
@section('title', 'Tạo check-in')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Tạo check-in</h1>
    <div class="page-subtitle">Mỗi sinh viên chỉ check-in một lần cho một sự kiện.</div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('checkins.store') }}">
            @csrf 
            @include('partials.form-errors')
            
            <label class="form-label required">Đăng ký sự kiện</label>
            <select class="form-select" name="registration_id" required>
                <option value="">-- Chọn đăng ký --</option>
                @foreach($registrations as $registration)
                    <option value="{{ $registration->id }}" @selected(old('registration_id') == $registration->id)>
                        {{ $registration->student->student_code }} - {{ $registration->student->full_name }} · {{ $registration->event->title }}
                    </option>
                @endforeach
            </select>
            
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a class="btn btn-light border" href="{{ route('checkins.index') }}">Hủy</a>
                <button class="btn btn-primary">Tạo check-in</button>
            </div>
        </form>
    </div>
</div>
@endsection