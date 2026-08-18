@extends('layouts.app')
@section('title', 'Thêm thành viên')
@section('content')
<div class="mb-4"><h1 class="page-title">Thêm thành viên vào CLB</h1><div class="page-subtitle">Chọn sinh viên và chức vụ tương ứng</div></div><div class="card"><div class="card-body p-4">@include('club_members.form')</div></div>
@endsection
