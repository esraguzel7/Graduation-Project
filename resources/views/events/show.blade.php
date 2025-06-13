@extends('main')

@php
    $page = $event->name;

    $breadcrumb = [
        'Events' => route('events.list'),
        $event->name,
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div id="mediaSlider" class="carousel slide mb-4 shadow-sm rounded overflow-hidden" data-ride="carousel"
                data-interval="false">
                <div class="carousel-inner ratio-wrapper">

                    @forelse ($event->medias as $index => $media)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            @if ($media->media_type === 'video')
                                <video class="d-block w-100 media-object" controls>
                                    <source src="{{ asset($media->media_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <img class="d-block w-100 media-object" src="{{ asset($media->media_path) }}"
                                    alt="Media {{ $index + 1 }}">
                            @endif
                        </div>
                    @empty
                        {{-- Varsayılan içerik --}}
                        <div class="carousel-item active">
                            <img class="d-block w-100 media-object" src="{{ asset('assets/images/default-event.jpg') }}"
                                alt="Default media">
                        </div>
                    @endforelse

                </div>

                {{-- Oklar --}}
                <a class="carousel-control-prev" href="#mediaSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#mediaSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div>
                <h2 class="mb-4"><strong>Description</strong></h2>
                <p class="mb-4">
                    {!! nl2br(e(ucfirst(strtolower($event->description ?? 'No description has been provided')))) !!}
                </p>
                <hr>
                <div class="row card-group-row">
                    <div class="col-12 mb-3">
                        <h2 class="mb-4"><strong>Participants</strong></h2>
                    </div>
                    @forelse ($event->activities as $activity)
                        <div class="col-lg-3 col-md-4 card-group-row__col">
                            <div class="card card-group-row__card">
                                <div class="p-2 d-flex flex-row align-items-center">
                                    <div class="avatar avatar-xs mr-2">
                                        <span class="avatar-title rounded-circle text-center">
                                            {{ strtoupper(substr($activity->user_shortname, 0, 2)) }}
                                        </span>
                                    </div>
                                    <strong class="text-dark">{{ $activity->user_fullname }}</strong>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No participants have been added yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <strong>{{ $event->creator_name }}</strong>
                    </div>
                    <div class="ml-auto h2 mb-0"><strong>{{ number_format($event->event_cost, 2) }}₺</strong></div>
                </div>

                <div class="mb-4">
                    @if ($event->activities->contains('user_id', auth()->id()))
                        <form action="" method="POST" data-action="{{ route('events.leave.perform', $event->id) }}"
                            class="ajax-form">
                            <button class="btn btn-danger btn-block">Cancel Participation</button>
                        </form>
                    @else
                        <form action="" data-action="{{ route('events.join.perform', $event->id) }}" class="ajax-form"
                            method="POST">
                            <button class="btn btn-success btn-block">Join Event</button>
                        </form>
                    @endif
                </div>

                <div class="list-group list-group-flush mb-4">
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Important</strong>
                        <div class="ml-auto">{{ $event->is_important ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Category</strong>
                        <div class="ml-auto">{{ $event->event_category }}</div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Planned Date</strong>
                        <div class="ml-auto">{{ \Carbon\Carbon::parse($event->planned_date)->format('d M Y') }}</div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Planned Time</strong>
                        <div class="ml-auto">{{ \Carbon\Carbon::parse($event->planned_time)->format('H:i') }}</div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Max Participants</strong>
                        <div class="ml-auto">{{ $event->max_participants }}</div>
                    </div>
                    <div class="list-group-item bg-transparent d-flex align-items-center px-0">
                        <strong>Location</strong>
                        <div class="ml-auto">{{ $event->location }}</div>
                    </div>
                </div>

                <div class="card card-body bg-dark text-white mb-0">
                    <h5 class="text-white text-center mb-0">
                        {{ $event->activities()->count() }}/{{ $event->max_participants ?? 'Limitless' }} participants
                    </h5>
                </div>
            </div>

            @if ($event->activities->contains('user_id', auth()->id()) && !$event->activities->where('user_id', auth()->id())->first()->has_paid)
                <div class="card card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <strong>Pay:</strong>
                        </div>
                        <div class="ml-auto h2 mb-0"><strong>{{ number_format($event->event_cost, 2) }}₺</strong></div>
                    </div>

                    <div class="mb-4">
                        <form action="" data-action="{{ route('events.payment.perform', $event->id) }}" class="ajax-form"
                            method="POST">
                            <div class="form-group">
                                <label for="form_select_wallet">Your Wallets</label>
                                <select id="form_select_wallet" name="wallet" data-toggle="select"
                                    class="form-control">
                                    <option value="" disabled selected>Select a wallet</option>
                                    @foreach (Auth::user()->wallets as $wallet)
                                        <option value="{{ $wallet->id }}">{{ number_format($wallet->balance, 2) }}₺ - {{ $wallet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-success btn-block">Pay Now</button>
                        </form>
                    </div>

                    <p class="mb-0 text-dark-gray">
                        To confirm your participation in this event, you need to complete the payment of
                        <strong>{{ number_format($event->event_cost, 2) }}₺</strong>. Please proceed with the payment to secure
                        your spot.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection