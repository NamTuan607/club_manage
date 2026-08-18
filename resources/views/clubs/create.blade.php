@extends('layouts.app')
@section('title', 'Thêm câu lạc bộ')
@section('content')
<div class="mb-4">
    <h1 class="page-title">Thêm câu lạc bộ</h1>
    <div class="page-subtitle">Nhập thông tin cơ bản của câu lạc bộ</div>
</div>
<div class="card">
    <div class="card-body p-4">@include('clubs.form')</div>
</div>
@endsection
