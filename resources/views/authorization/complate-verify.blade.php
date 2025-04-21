@extends('authorization.main')

{{-- Page Title --}}
@section('pagename')
    Email Verification
@endsection

{{-- Content --}}
@section('content')
    <h4 class="m-0">{{ $status ? 'Email Verified Successfully!' : 'Email Verification Required!' }}</h4>
    <p class="mb-5">{{ $message }}</p>

    @if ($status)
        <a href="{{ url('/') }}" class="btn btn-success">Go to Homepage</a>
    @else
        <form class="ajax-form" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>
    @endif
@endsection
