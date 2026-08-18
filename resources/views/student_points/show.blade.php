@extends('layouts.app')
@section('title', 'Chi tiết điểm hoạt động')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4"><div><h1 class="page-title">Chi tiết điểm hoạt động</h1><div class="page-subtitle">{{ $studentPoint->student->full_name }} · {{ $studentPoint->event->title }}</div></div>@if(!$studentPoint->certificate)<a class="btn btn-success" href="{{ route('certificates.create', ['student_point_id' => $studentPoint->id]) }}">Cấp chứng nhận</a>@endif</div>
<div class="row g-4"><div class="col-lg-4"><div class="card"><div class="card-body"><div class="text-secondary">Điểm được cộng</div><div class="stat-value">{{ $studentPoint->points }}</div><div class="small text-secondary mt-2">Tổng điểm của sinh viên: {{ $totalPoints }}</div></div></div></div><div class="col-lg-8"><div class="card"><div class="card-body"><dl class="row mb-0"><dt class="col-sm-4">Sinh viên</dt><dd class="col-sm-8">{{ $studentPoint->student->full_name }} ({{ $studentPoint->student->student_code }})</dd><dt class="col-sm-4">Sự kiện</dt><dd class="col-sm-8">{{ $studentPoint->event->title }}</dd><dt class="col-sm-4">Quy tắc</dt><dd class="col-sm-8">{{ $studentPoint->rule->event_name ?: $studentPoint->rule->category->name }} · {{ $studentPoint->rule->points }} điểm</dd><dt class="col-sm-4">Ngày cộng</dt><dd class="col-sm-8">{{ $studentPoint->awarded_at->format('d/m/Y H:i') }}</dd><dt class="col-sm-4">Chứng nhận</dt><dd class="col-sm-8">
@if($studentPoint->certificate)
<a href="{{ route('certificates.show', $studentPoint->certificate) }}">{{ $studentPoint->certificate->certificate_code }}</a>
@else
Chưa cấp
@endif
</dd></dl></div></div></div></div>
@endsection
