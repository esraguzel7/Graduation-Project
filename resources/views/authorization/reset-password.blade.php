@extends('authorization.main')

{{-- Page Title --}}
@section('pagename')
    Reset Password
@endsection

{{-- Form content --}}
@section('content')
    <h4 class="m-0">Reset Your Password</h4>
    <p class="mb-5">Enter your new password below.</p>

    <form action="javascript:void(0);" data-action="{!! route('password.reset.perform') !!}" class="ajax-form" novalidate>
        <input type="hidden" name="token" value="{{ $token }}">

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

        <div class="form-group">
            <label class="text-label" for="password">New Password:</label>
            <div class="input-group input-group-merge">
                <input id="password" type="password" name="password" required="" class="form-control form-control-prepended"
                    placeholder="Enter new password">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="text-label" for="password_confirmation">Confirm Password:</label>
            <div class="input-group input-group-merge">
                <input id="password_confirmation" type="password" name="password_confirmation" required=""
                    class="form-control form-control-prepended" placeholder="Confirm new password">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Reset Password</button><br>
            Remembered your password? <a class="text-body text-underline" href="{!! route('login') !!}">Log In!</a>
        </div>
    </form>
@endsection
