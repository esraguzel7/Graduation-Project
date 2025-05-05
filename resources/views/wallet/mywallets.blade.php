@extends('main')

@php
    $page = 'My Wallets';
    $breadcrumb = [
        'My Wallets',
    ];

    $breadcrumb_button = [
        'Create New Wallet' => route('wallet.create.show'),
    ];
@endphp

@section('content')

    <div class="container mt-4">
        <div class="row">
            @foreach(Auth::user()->wallets->chunk(2) as $walletRow)
                <div class="row w-100 mb-4">
                    @foreach($walletRow as $wallet)
                        <div class="col-md-6">
                            <div class="card mb-4 shadow-sm d-flex flex-row align-items-center">
                                <div class="p-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-wallet fa-2x"></i>
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">{{ $wallet->name }}</h5>
                                        <p class="card-text">
                                            <strong>Balance:</strong> {{ number_format($wallet->balance, 2) }} ₺<br>
                                            <strong>Created At:</strong> {{ $wallet->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <a href="{!! route('wallet.show', $wallet->id) !!}" class="d-flex align-items-center text-muted" style="font-size: 1.5rem;">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    
@endsection
