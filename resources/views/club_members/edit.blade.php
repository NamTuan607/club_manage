@extends('layouts.app')
@section('title', 'Sửa thành viên')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Sửa thành viên CLB</h1>
    <div class="page-subtitle">{{ $clubMember->student->full_name ?? '' }}</div>
</div>

<div class="card">
    <div class="card-body p-4">
        @include('club_members.form')
    </div>
</div>
@endsection