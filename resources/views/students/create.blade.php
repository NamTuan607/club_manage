@extends('layouts.app')
@section('title', 'Thêm sinh viên')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm sinh viên</h1><div class="page-subtitle">Tạo user sinh viên và hồ sơ sinh viên tương ứng.</div></div>
<div class="card"><div class="card-body">@include('students.form')</div></div>
@endsection
