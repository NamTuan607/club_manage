@extends('layouts.app')

@section('title', 'Check-in')

@section('content')
<h1 class=page-title>Lịch sử check-in {{ $checkins->count() }}</h1>
@endsection
