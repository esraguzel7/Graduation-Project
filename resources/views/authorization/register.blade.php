@extends('authorization.main')

{{-- Page title --}}
@section('pagename')
    Create Account
@endsection

{{-- Form content --}}
@section('content')
    <h4 class="m-0">Create Your Account</h4>
    <p class="mb-5">Fill in your details below to join Turnique.</p>

    <form action="{!! url('/') !!}" class="ajax-form" novalidate>
        <div class="form-group">
            <label class="text-label" for="user_name">Your First Name:</label>
            <div class="input-group input-group-merge">
                <input id="user_name" type="text" name="name" required="" class="form-control form-control-prepended"
                    placeholder="Your First Name">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-user"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="user_surname">Your Last Name:</label>
            <div class="input-group input-group-merge">
                <input id="user_surname" type="text" name="surname" required="" class="form-control form-control-prepended"
                    placeholder="Your Last Name">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-user"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="email_2">Email Address:</label>
            <div class="input-group input-group-merge">
                <input id="email_2" type="email" name="email" required="" class="form-control form-control-prepended"
                    placeholder="someone@mail.com">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="phone">Your Phone Number:</label>
            <div class="input-group input-group-merge">
                <input id="phone" type="text" name="phone" required="" class="form-control form-control-prepended"
                    placeholder="+90(555) 555 55 55">
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

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Sign Up</button><br>
            Already have an account? <a class="text-body text-underline" href="{!! route('login') !!}">Log In!</a>
        </div>
    </form>
@endsection
