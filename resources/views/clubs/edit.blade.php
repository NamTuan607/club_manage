@extends('layouts.app')
@section('title', 'Sửa câu lạc bộ')
@section('content')
<div class="mb-4">
    <h1 class="page-title">Sửa câu lạc bộ</h1>
    <div class="page-subtitle">{{ $club->name }}</div>
</div>
<div class="card">
    <div class="card-body p-4">@include('clubs.form')</div>
</div>
@endsection
