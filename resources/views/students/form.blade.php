@include('partials.form-errors')
<form method="POST" action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}">
@csrf @isset($student) @method('PUT') @endisset
<div class="row g-3">
    <div class="col-md-6"><label class="form-label required">Mã sinh viên</label><input class="form-control" name="student_code" value="{{ old('student_code', $student->student_code ?? '') }}" required></div>
    <div class="col-md-6"><label class="form-label required">Họ và tên</label><input class="form-control" name="full_name" value="{{ old('full_name', $student->full_name ?? '') }}" required></div>
    <div class="col-md-6"><label class="form-label required">Email</label><input class="form-control" type="email" name="email" value="{{ old('email', $student->user->email ?? '') }}" required></div>
    <div class="col-md-3"><label class="form-label required">Lớp</label><input class="form-control" name="class" value="{{ old('class', $student->class ?? '') }}" required></div>
    <div class="col-md-3"><label class="form-label">Điện thoại</label><input class="form-control" name="phone" value="{{ old('phone', $student->phone ?? '') }}"></div>
    <div class="col-12"><label class="form-label required">Khoa</label><input class="form-control" name="faculty" value="{{ old('faculty', $student->faculty ?? '') }}" required></div>
</div>
<div class="mt-4 d-flex justify-content-end gap-2"><a class="btn btn-light border" href="{{ isset($student) ? route('students.show', $student) : route('students.index') }}">Hủy</a><button class="btn btn-primary"><i class="bi bi-save me-1"></i>Lưu</button></div>
</form>
