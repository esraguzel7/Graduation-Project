@extends('main')

@php
    $page = $wallet->name;
    $breadcrumb = [
        'My Wallets' => route('wallet.mywallets.show'),
        $wallet->name
    ];
@endphp

@section('content')

    <div class="container mt-4">
        <div class="row">
            <!-- Balance Load Form -->
            <div class="col-12">
                <div class="card card-form">
                    <div class="row no-gutters">
                        <div class="col-lg-4 card-body">
                            <p><strong class="headings-color">Load Balance</strong></p>
                            <p class="text-muted">
                                You can use this field to add balance to this wallet or you can make transactions at
                                authorized tellers of your institution.
                            </p>
                        </div>
                        <div class="col-lg-8 card-form__body card-body">
                            <form action="" method="post" class="ajax-form">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="card_number">Card Number</label>
                                        <input type="text" class="form-control" id="card_number" name="card_number"
                                            placeholder="XXXX XXXX XXXX XXXX" data-mask="0000 0000 0000 0000" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" name="expiry_date"
                                            placeholder="MM/YY" data-mask="00/00" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="cvv">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="XXX"
                                            data-mask="000" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="cardholder_name">Cardholder Name</label>
                                        <input type="text" class="form-control" id="cardholder_name" name="cardholder_name"
                                            placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="amount">Amount (₺)</label>
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="0.00"
                                            data-mask="#0.00" data-mask-reverse="true" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Load Balance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Balance Load Form -->
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-large bg-white">
                        <h4 class="card-header__title">Wallet Details</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $wallet->name }}</p>
                        <p><strong>Description:</strong> {{ $wallet->description ?? 'No description provided' }}</p>
                        <p><strong>Balance:</strong> {{ number_format($wallet->balance, 2) }} ₺</p>
                        <p><strong>Minimum Balance:</strong> {{ number_format($wallet->minimum_balance, 2) }} ₺</p>
                        <p><strong>Created At:</strong> {{ $wallet->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="px-4 pt-3">
                    <h4 class="mb-4">Transaction History</h4>
                    <ul class="timeline">
                        @forelse ($wallet->transactions()->latest()->limit(15)->get() as $transaction)
                            <li class="timeline-item {{ $transaction->amount > 0 ? 'item-green' : 'item-red' }}">
                                <div class="timeline-item-header">
                                    <strong>{{ $transaction->created_at->format('d M Y H:i') }}</strong>
                                    <span class="badge badge-{{ $transaction->amount > 0 ? 'success' : 'danger' }}">
                                        {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }} ₺
                                    </span>
                                </div>
                                <div class="timeline-item-body">
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
                </div>

            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Update Minimum Balance Form -->
                <div class="card">
                    <div class="card-header card-header-large bg-white">
                        <h4 class="card-header__title">Update Minimum Balance</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="put" class="ajax-form">
                            <div class="form-group">
                                <label for="minimum_balance">Minimum Balance (₺)</label>
                                <input type="number" step="0.01" class="form-control" id="minimum_balance"
                                    name="minimum_balance" value="{{ $wallet->minimum_balance }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
                    </div>
                </div>

                <!-- Delete Wallet Form -->
                <div class="card mt-4">
                    <div class="card-header card-header-large bg-white">
                        <h4 class="card-header__title">Delete Wallet</h4>
                    </div>
                    <div class="card-body">
                        @if ($wallet->balance == 0)
                            <form action="" method="delete" class="ajax-form">
                                <p class="text-danger">This action cannot be undone.</p>
                                <button type="submit" class="btn btn-danger btn-block">Delete Wallet</button>
                            </form>
                        @else
                            <div class="alert alert-danger">Wallet balance must be <strong>0.00 ₺</strong> for deletion</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection