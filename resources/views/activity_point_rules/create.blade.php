@extends('layouts.app')
@section('title', 'Thêm quy tắc điểm')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm quy tắc điểm hoạt động</h1><div class="page-subtitle">Điểm không được vượt mức tối đa của loại sự kiện</div></div><div class="card"><div class="card-body p-4">@include('activity_point_rules.form')</div></div>
@endsection
