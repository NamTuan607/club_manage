@extends('layouts.app')
@section('title', 'Sửa chức vụ')
@section('content')
<div class="mb-4"><h1 class="page-title">Sửa chức vụ CLB</h1><div class="page-subtitle">{{ $clubRole->role_name }}</div></div><div class="card"><div class="card-body p-4">@include('club_roles.form')</div></div>
@endsection
