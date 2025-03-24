@extends('authorization.main')

{{-- Sayfa başlığı --}}
@section('pagename')
    Giriş Yap
@endsection

{{-- Form içeriği --}}
@section('content')
    <h4 class="m-0">E-Posta Doğrulaması Gerekli!</h4>
    <p class="mb-5">Hesabını aktifleştirmek için doğrulamayı tamamlayın.</p>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form class="ajax-form" method="POST">
        <button type="submit" class="btn btn-primary">Doğrulama E-postasını Yeniden Gönder</button>
    </form>
@endsection
