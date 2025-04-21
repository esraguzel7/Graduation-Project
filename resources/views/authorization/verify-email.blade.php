@extends('authorization.main')

{{-- Page Title --}}
@section('pagename')
    Login
@endsection

{{-- Form content --}}
@section('content')
    <h4 class="m-0">Email Verification Required!</h4>
    <p class="mb-5">Complete the verification to activate your account.</p>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form class="ajax-form" method="POST">
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
@endsection
