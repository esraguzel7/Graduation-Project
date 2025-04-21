@extends('authorization.main')

{{-- Page Title --}}
@section('pagename')
    Login
@endsection

{{-- Form content --}}
@section('content')
    <h4 class="m-0">Welcome Back!</h4>
    <p class="mb-5">Log in to your Turnique account.</p>

    <form action="{!! url('/') !!}" class="ajax-form" novalidate>
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
            <label class="text-label" for="password">Password:</label>
            <div class="input-group input-group-merge">
                <input id="password" type="password" name="password" required="" class="form-control form-control-prepended"
                    placeholder="Enter your password">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-key"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-5">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" checked="" name="remember" id="remember">
                <label class="custom-control-label" for="remember">Remember me</label>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Login</button><br>
            <a href="">Forgot your password?</a> <br>
            Need an account? <a class="text-body text-underline" href="{!! route('register.show') !!}">Sign Up!</a>
        </div>
    </form>
@endsection
