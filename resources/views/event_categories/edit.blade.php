@extends('layouts.app')
@section('title', 'Sửa loại sự kiện')
@section('content')
<div class="mb-4">
    <h1 class="page-title">Sửa loại sự kiện</h1>
    <div class="page-subtitle">{{ $eventCategory->name }}</div>
</div>
<div class="card">
    <div class="card-body p-4">@include('event_categories.form')</div>
</div>
@endsection
