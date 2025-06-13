@extends('main')

@php
    $page = 'Home';
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

    <div class="my-3"><strong class="text-dark-gray">Upcoming Events</strong></div>
    <div class="row">

        @php
            $otherEvents = \App\Models\Event::where('planned_date', '>=', \Carbon\Carbon::now())
                ->take(8)
                ->get();
        @endphp

        @if($otherEvents->isEmpty())
            <div class="col-12">
                <div class="alert alert-secondary" role="alert">
                    There are no other upcoming events.
                </div>
            </div>
        @else
            @foreach($otherEvents as $event)
                <div class="col-sm-4 col-md-3">
                    <div class="card stories-card-popular">
                        <img src="/{{ $event->medias->where('media_type', 'image')->first()?->media_path ?? 'assets/images/default-event.jpg' }}"
                            alt="" class="card-img">
                        <div class="stories-card-popular__content">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar-group flex">
                                    <div class="avatar avatar-xs" data-toggle="tooltip" data-placement="top"
                                        title="{{ $event->creator_name }}">
                                        <span class="avatar-title rounded-circle">{{ $event->creator_shortname }}</span>
                                    </div>
                                </div>
                                @if ($event->is_important)
                                    <div class="stories-card-popular__tag badge badge-danger mr-2">Important</div>
                                @endif
                                <a style="text-decoration: none;" class="d-flex align-items-center"
                                    href="{{ route('events.show', $event->id) }}">
                                    <i class="material-icons mr-1" style="font-size: inherit;">person_add</i>
                                    <small>{{ $event->activities()->count() }}</small>
                                </a>
                            </div>
                            <div class="stories-card-popular__title card-body">
                                <small class="text-muted text-uppercase">{{ ucwords($event->event_category) }}</small>
                                <h4 class="card-title m-0"><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

@endsection