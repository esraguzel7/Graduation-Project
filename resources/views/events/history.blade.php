@extends('main')

@php
    $page = 'Event History';

    $breadcrumb = [
        'Events' => '',
        'Event History',
    ];
@endphp

@section('content')
<div class="container">
    <h1>My Event History</h1>
    <ul class="list-group">
        <li class="list-group-item">Event X - <small>2023-10-01</small></li>
        <li class="list-group-item">Event Y - <small>2023-09-15</small></li>
        <li class="list-group-item">Event Z - <small>2023-08-20</small></li>
    </ul>
</div>
@endsection
