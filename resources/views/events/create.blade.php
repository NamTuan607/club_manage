@extends('layouts.app')
@section('title', 'Thêm sự kiện')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm sự kiện</h1><div class="page-subtitle">Sự kiện sẽ được chuyển tới cán bộ để duyệt</div></div><div class="card"><div class="card-body p-4">@include('events.form')</div></div>
@endsection
