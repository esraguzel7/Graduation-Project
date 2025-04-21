@extends('authorization.main')

{{-- Sayfa başlığı --}}
@section('pagename')
    E-Posta Doğrulama
@endsection

{{-- İçerik --}}
@section('content')
    <h4 class="m-0">{{ $status ? 'E-Posta Başarıyla Doğrulandı!' : 'E-Posta Doğrulaması Gerekli!' }}</h4>
    <p class="mb-5">{{ $message }}</p>

    @if ($status)
        <a href="{{ url('/') }}" class="btn btn-success">Anasayfaya Git</a>
    @else
        <form class="ajax-form" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Doğrulama E-postasını Yeniden Gönder</button>
        </form>
    @endif
@endsection
