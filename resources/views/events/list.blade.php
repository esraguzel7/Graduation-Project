@extends('main')

@php
    $page = 'Events';

    $breadcrumb = [
        'Events',
    ];

    $breadcrumb_button = [
        'New Event' => route('events.create'),
    ];
@endphp

@section('content')
    <div class="mb-3"><strong class="text-dark-gray">My Events</strong></div>
    @php
        $myEvents = \App\Models\Event::where('created_by', Auth::id())
            ->where('planned_date', '>=', \Carbon\Carbon::now())
            ->get();
    @endphp

    @if($myEvents->isEmpty())
        <div class="alert alert-secondary" role="alert">
            You have not created any events yet. Start by clicking the "New Event" button above to create your first event.
        </div>
    @else
        <div class="stories-cards mb-4">
            @foreach($myEvents as $event)
                <div class="card stories-card">
                    <div class="stories-card__content d-flex align-items-center flex-wrap">
                        <div class="avatar avatar-lg mr-3">
                            <a href="{{ route('events.show', $event->id) }}">
                                <img src="/{{ $event->medias->where('media_type', 'image')->first()?->media_path ?? 'assets/images/default-event.jpg' }}" alt="avatar"
                                    class="avatar-img rounded">
                            </a>
                        </div>
                        <div class="stories-card__title flex">
                            <h5 class="card-title m-0">
                                <a href="{{ route('events.show', $event->id) }}" class="headings-color">
                                    {{ $event->name }}
                                </a>
                            </h5>
                            <small class="text-dark-gray">{{ ucwords($event->event_category) }}</small>
                        </div>
                        <div class="d-flex align-items-center flex-column flex-sm-row stories-card__meta">
                            <div class="mr-3 text-dark-gray text-uppercase stories-card__tag d-flex align-items-center">
                                <i class="material-icons text-muted-light mr-2">person_add</i>
                                {{ $event->activities()->count() }}
                            </div>
                            <div class="mr-3 text-dark-gray stories-card__date">
                                <small>{{ \Carbon\Carbon::parse($event->planned_date)->format('d M, Y') }} at
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->planned_time)->format('h:i A') }}</small>
                            </div>
                        </div>
                        <div class="dropdown ml-auto">
                            <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('events.edit', $event->id) }}" class="dropdown-item">Edit</a>
                                <form data-action="{{ route('events.delete.perform', $event->id) }}" class="ajax-form" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    <button type="submit" class="dropdown-item">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mb-3"><strong class="text-dark-gray">Company Events</strong></div>
    @php
        $importantEvents = \App\Models\Event::where('is_important', 1)
            ->where('planned_date', '>=', \Carbon\Carbon::now())
            ->get();
    @endphp
    @if($importantEvents->isEmpty())
        <div class="alert alert-secondary" role="alert">
            There are no important upcoming events.
        </div>
    @else
        <div class="stories-cards mb-4">
            @foreach($importantEvents as $event)
                <div class="card stories-card">
                    <div class="stories-card__content d-flex align-items-center flex-wrap">
                        <div class="avatar avatar-lg mr-3">
                            <a href="{{ route('events.show', $event->id) }}">
                                <img src="/{{ $event->medias->where('media_type', 'image')->first()?->media_path ?? 'assets/images/default-event.jpg' }}" alt="avatar"
                                    class="avatar-img rounded">
                            </a>
                        </div>
                        <div class="stories-card__title flex">
                            <h5 class="card-title m-0">
                                <a href="{{ route('events.show', $event->id) }}" class="headings-color">
                                    {{ $event->name }}
                                </a>
                            </h5>
                            <small class="text-dark-gray">{{ ucwords($event->event_category) }}</small>
                        </div>
                        <div class="d-flex align-items-center flex-column flex-sm-row stories-card__meta">
                            <div class="mr-3 text-dark-gray text-uppercase stories-card__tag d-flex align-items-center">
                                <i class="material-icons text-muted-light mr-2">person_add</i>
                                {{ $event->activities()->count() }}
                            </div>
                            <div class="mr-3 text-dark-gray stories-card__date">
                                <small>{{ \Carbon\Carbon::parse($event->planned_date)->format('d M, Y') }} at
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $event->planned_time)->format('h:i A') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="my-3"><strong class="text-dark-gray">Other Events</strong></div>
    <div class="row">

        @php
            $otherEvents = \App\Models\Event::where('is_important', 0)
                ->where('planned_date', '>=', \Carbon\Carbon::now())
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
                <div class="col-sm-6 col-md-4">
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