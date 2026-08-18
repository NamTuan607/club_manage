@extends('layouts.app')
@section('title', 'Thêm chức vụ')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm chức vụ CLB</h1><div class="page-subtitle">Khai báo vai trò cho từng câu lạc bộ</div></div><div class="card"><div class="card-body p-4">@include('club_roles.form')</div></div>
@endsection
