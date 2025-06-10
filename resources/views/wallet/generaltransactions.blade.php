@extends('main')

@php
    $page = 'General Transactions';
    $breadcrumb = [
        'My Wallets' => route('wallet.mywallets.show'),
        'General Transactions'
    ];
@endphp

@section('content')

    <div class="container mt-4">

        <div class="px-4 pt-3">
            <h4 class="mb-4">Transaction History</h4>
            <ul class="timeline">
                @forelse (\App\Models\WalletTransaction::whereIn('wallet_id', auth()->user()->wallets->pluck('id'))->latest()->paginate(15) as $transaction)
                    <li class="timeline-item {{ $transaction->amount > 0 ? 'item-green' : 'item-red' }}">
                        <div class="timeline-item-header">
                            <strong>{{ $transaction->created_at->format('d M Y H:i') }}</strong>
                            <span class="badge badge-{{ $transaction->amount > 0 ? 'success' : 'danger' }}">
                                {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }} ₺
                            </span>
                        </div>
                        <div class="timeline-item-body">
                            <p><strong>Wallet:</strong> <span class="badge badge-primary"
                                    style="font-size: 1em;">{{ $transaction->wallet->name ?? 'Unknown Wallet' }}</span></p>
                            <p><strong>Message:</strong> {{ $transaction->message ?? 'No message provided' }}</p>
                            <p><strong>Note:</strong> {{ $transaction->user_note ?? 'No note provided' }}</p>
                            <p><strong>New Balance:</strong> {{ number_format($transaction->new_balance, 2) }} ₺</p>
                        </div>
                    </li>
                @empty
                    <li class="timeline-item item-yellow">
                        <div class="timeline-item-body">
                            <p>No transactions found for this wallet.</p>
                        </div>
                    </li>
                @endforelse
            </ul>

            <div class="d-flex justify-content-center mt-4">
                <div class="pagination-rounded">
                    {{ \App\Models\WalletTransaction::whereIn('wallet_id', auth()->user()->wallets->pluck('id'))->latest()->paginate(15)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>

@endsection