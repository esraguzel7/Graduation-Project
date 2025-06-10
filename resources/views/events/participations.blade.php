@extends('main')

@php
    $page = 'My Participations';

    $breadcrumb = [
        'Events' => '',
        'My Participations',
    ];

    $futureEvents = Auth::user()->upcomingActivities->sortBy('planned_date');
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="stories-cards mb-4">

                @if ($futureEvents->isEmpty())
                    <div class="text-center text-muted">
                        <p>You are not participating in any upcoming events.</p>
                    </div>
                @else
                    @foreach ($futureEvents as $activity)
                        @php
                            $event = $activity->event;
                        @endphp
                        <div class="card">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="m-4">
                                    <a href="{{ route('events.show', $event->id) }}" class="d-flex align-items-center text-muted">
                                        <!-- LOGO -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48">
                                            <g stroke="currentColor" fill="none" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M26.09 37.272l-7.424 1.06 1.06-7.424 19.092-19.092c1.758-1.758 4.606-1.758 6.364 0s1.758 4.606 0 6.364L26.09 37.272zM12 1.498h12c.828 0 1.5.672 1.5 1.5v3c0 .828-.672 1.5-1.5 1.5H12c-.828 0-1.5-.672-1.5-1.5v-3c0-.828.672-1.5 1.5-1.5zM25.5 4.498h6c1.656 0 3 1.344 3 3"
                                                    stroke-width="3"></path>
                                                <path
                                                    d="M34.5 37.498v6c0 1.656-1.344 3-3 3h-27c-1.656 0-3-1.344-3-3v-36c0-1.656 1.344-3 3-3h6M10.5 16.498h15M10.5 25.498h6"
                                                    stroke-width="3"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                                <div class="stories-card__title flex">
                                    <h5 class="card-title m-0">
                                        <a href="{{ route('events.show', $event->id) }}" class="text-body">{{ $event->name }}</a>
                                    </h5>
                                    <small class="text-muted">
                                        Planned Date: {{ \Carbon\Carbon::parse($event->planned_date)->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="ml-auto d-flex align-items-center">
                                    @if (!$activity->has_paid && $event->event_cost > 0)
                                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-warning mr-3">Need Payment</a>
                                    @endif
                                    <div class="badge badge-soft-primary badge-pill mr-3">{{ $event->event_category }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection