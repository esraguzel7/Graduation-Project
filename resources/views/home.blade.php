@extends('main')

@php
    $page = 'Dashboard';
@endphp

@section('content')


    @if(
            \App\Models\CardRequest::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->first()
        )
        <div class="alert alert-soft-info d-flex align-items-center card-margin" role="alert">
            <i class="material-icons mr-3">info</i>
            <div class="text-body">
                Your card application has not been approved yet. You can contact your administrator for more information.
            </div>
        </div>
    @endif

    <div class="row card-group-row">
        @php

            $currentMonth = \Carbon\Carbon::now()->startOfMonth();
            $previousMonth = \Carbon\Carbon::now()->subMonth()->startOfMonth();

            $currentMonthTotal = \App\Models\WalletTransaction::whereHas('wallet', function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('id', auth()->id());
                });
            })
                ->whereBetween('created_at', [$currentMonth, $currentMonth->copy()->endOfMonth()])
                ->sum('amount');

            $previousMonthTotal = \App\Models\WalletTransaction::whereHas('wallet', function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('id', auth()->id());
                });
            })
                ->whereBetween('created_at', [$previousMonth, $previousMonth->copy()->endOfMonth()])
                ->sum('amount');

            $difference = $currentMonthTotal - $previousMonthTotal;
            $percentageChange = $previousMonthTotal > 0 ? ($difference / $previousMonthTotal) * 100 : 0;
            $textClass = $difference >= 0 ? 'text-success' : 'text-danger';
        @endphp

        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Monthly Transactions</div>
                    <div class="text-amount">
                        &#8378;{{ number_format($currentMonthTotal, 2) }}
                        <small class="text-muted">&#8378;{{ number_format($previousMonthTotal, 2) }}</small>
                    </div>
                    <div class="text-stats {{ $textClass }}">
                        {{ number_format(abs($percentageChange), 1) }}%
                        <i class="material-icons">
                            {{ $difference >= 0 ? 'arrow_upward' : 'arrow_downward' }}
                        </i>
                    </div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">account_balance_wallet</i></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">-</div>
                    <div class="text-amount">&dollar;-</div>
                    <div class="text-stats text-success">-% <i class="material-icons">arrow_upward</i></div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">-</i></div>
            </div>
        </div>

        @php
            $totalBalance = \App\Models\Wallet::whereHas('user', function ($query) {
                $query->where('id', auth()->id());
            })->sum('balance');
        @endphp

        <div class="col-lg-4 col-md-12 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Total Wallet Balance</div>
                    <div class="text-amount">&#8378;{{ number_format($totalBalance, 2) }}</div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">account_balance</i></div>
            </div>
        </div>
    </div>

@endsection