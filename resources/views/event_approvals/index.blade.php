@extends('layouts.app')
@section('content')
<h1>Duyệt sự kiện</h1>
@foreach($approvals as $approval)<p>{{ $approval->event->title }}</p>@endforeach
@endsection
