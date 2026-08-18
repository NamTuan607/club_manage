@extends('layouts.app')
@section('title', 'Sửa sinh viên')
@section('content')
<div class="mb-4"><h1 class="page-title">Cập nhật sinh viên</h1><div class="page-subtitle">{{ $student->student_code }}</div></div>
<div class="card"><div class="card-body">@include('students.form')</div></div>
@endsection
