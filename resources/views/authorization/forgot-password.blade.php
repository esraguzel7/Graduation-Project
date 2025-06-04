@extends('authorization.main')

{{-- Page Title --}}
@section('pagename')
    Forgot Password
@endsection

{{-- Form content --}}
@section('content')
    <h4 class="m-0">Forgot Your Password?</h4>
    <p class="mb-5">Enter your email address to reset your password.</p>

    <form action="javascript:void(0);" data-action="{!! route('password.email.perform') !!}" class="ajax-form" novalidate>
        <div class="form-group">
            <label class="text-label" for="email">Email Address:</label>
            <div class="input-group input-group-merge">
                <input id="email" type="email" name="email" required="" class="form-control form-control-prepended"
                    placeholder="someone@mail.com">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Send Reset Link</button><br>
            Remembered your password? <a class="text-body text-underline" href="{!! route('login') !!}">Log In!</a>
        </div>
    </form>
@endsection
