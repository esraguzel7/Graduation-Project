@extends('authorization.main')

{{-- Sayfa başlığı --}}
@section('pagename')
    Hesap Oluştur
@endsection

{{-- Form içeriği --}}
@section('content')
    <h4 class="m-0">Tekrar Hoş Geldin!</h4>
    <p class="mb-5">Turnique hesabına giriş yap.</p>

    <form action="{!! url('/') !!}" class="ajax-form" novalidate>
        <div class="form-group">
            <label class="text-label" for="user_name">Adınız:</label>
            <div class="input-group input-group-merge">
                <input id="user_name" type="text" name="name" required="" class="form-control form-control-prepended"
                    placeholder="Adınız">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-user"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="user_surname">Soyadınız:</label>
            <div class="input-group input-group-merge">
                <input id="user_surname" type="text" name="surname" required="" class="form-control form-control-prepended"
                    placeholder="Soyadınız">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-user"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="email_2">E-Posta Adresi:</label>
            <div class="input-group input-group-merge">
                <input id="email_2" type="email" name="email" required="" class="form-control form-control-prepended"
                    placeholder="birisi@mail.com">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="phone">Telefon Numaranız:</label>
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
            <label class="text-label" for="password">Parola:</label>
            <div class="input-group input-group-merge">
                <input id="password" type="password" name="password" required="" class="form-control form-control-prepended"
                    placeholder="Parolanızı girin">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-key"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Üye Ol</button><br>
            Zaten bir hesaba sahip misin? <a class="text-body text-underline" href="{!! route('authorization.login.show') !!}">Giriş Yap!</a>
        </div>
    </form>
@endsection
