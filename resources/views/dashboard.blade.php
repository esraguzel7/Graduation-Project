@extends('main')

@php
    $page = 'Dashboard';

    $breadcrumb = [
        'Dashboard',
    ];
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

            $currentMonthEventCount = \App\Models\Activity::where('user_id', auth()->id())
                ->whereHas('event', function ($query) use ($currentMonth) {
                    $query->whereBetween('planned_date', [$currentMonth, $currentMonth->copy()->endOfMonth()]);
                })
                ->count();

            $previousMonthEventCount = \App\Models\Activity::where('user_id', auth()->id())
                ->whereHas('event', function ($query) use ($previousMonth) {
                    $query->whereBetween('planned_date', [$previousMonth, $previousMonth->copy()->endOfMonth()]);
                })
                ->count();

            $currentMonthEventFees = \App\Models\Event::whereHas('activities', function ($query) use ($currentMonth) {
                $query->where('user_id', auth()->id());
            })
                ->whereBetween('planned_date', [$currentMonth, $currentMonth->copy()->endOfMonth()])
                ->sum('event_cost');

            $previousMonthEventFees = \App\Models\Event::whereHas('activities', function ($query) use ($previousMonth) {
                $query->where('user_id', auth()->id());
            })
                ->whereBetween('planned_date', [$previousMonth, $previousMonth->copy()->endOfMonth()])
                ->sum('event_cost');

            $eventDifference = $currentMonthEventCount - $previousMonthEventCount;
            $eventPercentageChange = $previousMonthEventCount > 0 ? ($eventDifference / $previousMonthEventCount) * 100 : 0;
            $eventTextClass = $eventDifference >= 0 ? 'text-success' : 'text-danger';
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
                    <div class="card-header__title text-muted mb-2">Monthly Event Participation</div>
                    <div class="text-amount">
                        {{ $currentMonthEventCount }}
                        <small>&#8378;{{ number_format($currentMonthEventFees, 2) }}</small>
                        <small class="text-muted">
                            {{ $previousMonthEventCount }}
                            <small>(&#8378;{{ number_format($previousMonthEventFees, 2) }})</small>
                        </small>
                    </div>
                    <div class="text-stats {{ $eventTextClass }}">
                        {{ number_format(abs($eventPercentageChange), 1) }}%
                        <i class="material-icons">
                            {{ $eventDifference >= 0 ? 'arrow_upward' : 'arrow_downward' }}
                        </i>
                    </div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">event</i></div>
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

    <div class="row">

        <div class="col-md-6 col-lg-7">

            <div class="px-4 pt-3">
                <h4 class="mb-4">Last Transactions</h4>
                <ul class="timeline">
                    @forelse (\App\Models\WalletTransaction::whereIn('wallet_id', auth()->user()->wallets->pluck('id'))->latest()->paginate(7) as $transaction)
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
                        {{ \App\Models\WalletTransaction::whereIn('wallet_id', auth()->user()->wallets->pluck('id'))->latest()->paginate(7)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-lg-5">
            <div class="row">
                <div class="col-md-12 card-group-row__col">
                    <div class="card w-100">
                        <div class="card-header card-header-large bg-white d-flex align-items-center">
                            <h4 class="card-header__title flex m-0">Upcoming Participations</h4>
                        </div>
                        <div class="list-group tab-content list-group-flush">
                            @php
                                $upcomingActivities = Auth::user()->upcomingActivities;
                            @endphp

                            @if ($upcomingActivities->isEmpty())
                                <div class="list-group-item text-center text-muted">
                                    <p>You have no upcoming participations.</p>
                                </div>
                            @else
                                @foreach ($upcomingActivities as $activity)
                                    @php
                                        $event = $activity->event;
                                    @endphp
                                    <div class="list-group-item list-group-item-action d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle">
                                                {{ $event->creator_shortname }}
                                            </span>
                                        </div>
                                        <div class="flex">
                                            <strong class="text-15pt">{{ $event->name }}</strong>
                                            <small class="text-muted">Planned Date:
                                                {{ \Carbon\Carbon::parse($event->planned_date)->format('d M Y') }}</small>
                                        </div>
                                        <a href="{{ route('events.show', $event->id) }}" class="ml-3">
                                            <i class="material-icons icon-muted">arrow_forward</i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 card-group-row__col">
                    <div class="card w-100">
                        <div class="card-header card-header-large bg-white d-flex align-items-center">
                            <h4 class="card-header__title flex m-0">Unpaid Participations</h4>
                        </div>
                        <div class="list-group tab-content list-group-flush">
                            @php
                                $unpaidActivities = \App\Models\Activity::where('user_id', auth()->id())
                                    ->whereHas('event', function ($query) {
                                        $query->where('event_cost', '>', 0);
                                    })
                                    ->where('has_paid', false)
                                    ->get();
                            @endphp

                            @if ($unpaidActivities->isEmpty())
                                <div class="list-group-item text-center text-muted">
                                    <p>No unpaid participations found.</p>
                                </div>
                            @else
                                @foreach ($unpaidActivities as $activity)
                                    @php
                                        $event = $activity->event;
                                    @endphp
                                    <div class="list-group-item list-group-item-action d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle bg-warning">
                                                <i class="material-icons">event</i>
                                            </span>
                                        </div>
                                        <div class="flex">
                                            <strong class="text-15pt">{{ $event->name }}</strong>
                                            <small class="text-muted">Planned Date:
                                                {{ \Carbon\Carbon::parse($event->planned_date)->format('d M Y') }}</small>
                                        </div>
                                        <div>&#8378;{{ number_format($event->event_cost, 2) }}</div>
                                        <a href="{{ route('events.show', $event->id) }}" class="ml-3">
                                            <i class="material-icons icon-muted">arrow_forward</i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 card-group-row__col">
                    <div class="card w-100">
                        <div class="card-header card-header-large bg-white d-flex align-items-center">
                            <h4 class="card-header__title flex m-0">Mandatory Events</h4>
                        </div>
                        <div class="list-group tab-content list-group-flush">
                            @php
                                $mandatoryEvents = \App\Models\Event::where('is_important', true)
                                    ->whereDoesntHave('activities', function ($query) {
                                        $query->where('user_id', auth()->id());
                                    })
                                    ->where('planned_date', '>=', \Carbon\Carbon::now())
                                    ->get();
                            @endphp

                            @if ($mandatoryEvents->isEmpty())
                                <div class="list-group-item text-center text-muted">
                                    <p>You have no mandatory events to confirm.</p>
                                </div>
                            @else
                                @foreach ($mandatoryEvents as $event)
                                    <div class="list-group-item list-group-item-action d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle bg-danger">
                                                <i class="material-icons">priority_high</i>
                                            </span>
                                        </div>
                                        <div class="flex">
                                            <strong class="text-15pt">{{ $event->name }}</strong>
                                            <small class="text-muted">Planned Date:
                                                {{ \Carbon\Carbon::parse($event->planned_date)->format('d M Y') }}</small>
                                        </div>
                                        <a href="{{ route('events.show', $event->id) }}" class="ml-3">
                                            <i class="material-icons icon-muted">arrow_forward</i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection