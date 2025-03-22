@extends('authorization.main')

{{-- Sayfa başlığı --}}
@section('pagename')
    Giriş Yap
@endsection

{{-- Form içeriği --}}
@section('content')
    <h4 class="m-0">Tekrar Hoş Geldin!</h4>
    <p class="mb-5">Turnique hesabına giriş yap.</p>

    <form action="{!! url('/') !!}" novalidate>
        <div class="form-group">
            <label class="text-label" for="email_2">E-Posta Adresi:</label>
            <div class="input-group input-group-merge">
                <input id="email_2" type="email" required="" class="form-control form-control-prepended"
                    placeholder="birisi@mail.com">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="password_2">Parola:</label>
            <div class="input-group input-group-merge">
                <input id="password_2" type="password" required="" class="form-control form-control-prepended"
                    placeholder="Parolanızı girin">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-key"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Login</button><br>
            <a href="">Parolanı mı unuttun?</a> <br>
            Bir hesaba mı ihtiyacın var? <a class="text-body text-underline" href="{!! route('authorization.register.show') !!}">Üye Ol!</a>
        </div>
    </form>
@endsection
