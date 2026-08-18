@extends('layouts.app')
@section('title', 'Thêm loại sự kiện')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm loại sự kiện</h1><div class="page-subtitle">Khai báo loại và số điểm tối đa được áp dụng</div></div><div class="card"><div class="card-body p-4">@include('event_categories.form')</div></div>
@endsection
