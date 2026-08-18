@extends('layouts.app')
@section('title', 'Sửa sự kiện')
@section('content')
<div class="mb-4"><h1 class="page-title">Sửa sự kiện</h1><div class="page-subtitle">{{ $event->title }}</div></div><div class="card"><div class="card-body p-4">@include('events.form')</div></div>
@endsection
