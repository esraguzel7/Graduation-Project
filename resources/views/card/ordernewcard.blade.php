@extends('main')

@php
    $page = 'Order New Card';

    $breadcrumb = [
        'My Cards' => '',
        'Order New Card',
    ];
@endphp

@section('content')
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-4 card-body">
                <p><strong class="headings-color">Apply for new card</strong></p>
                <p class="text-muted">
                    This application will be reviewed by the account managers and, if deemed necessary, approved.
                </p>
            </div>
            <div class="col-lg-8 card-form__body card-body">
                <form class="ajax-form" method="POST" action="">
                    <div class="form-group">
                        <label for="select01">Reason for Request</label>
                        <select id="select01" name="reason" data-toggle="select" class="form-control">
                            <option selected="">Reason for Request</option>
                            <option value="Additional card request">Additional card request</option>
                            <option value="Instead of a lost card">Instead of a lost card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select01">Card Type</label>
                        <select id="select01" name="card_type" data-toggle="select" class="form-control">
                            <option selected="">Card Type</option>
                            <option value="general_type">General</option>
                            <option value="only_access">Only Access</option>
                            <option value="only_payment">Only Payment</option>
                            <option value="only_event">Only Event</option>
                            <option value="access_and_payment">Access and Payment</option>
                            <option value="access_and_event">Access and Event</option>
                            <option value="payment_and_event">Payment and Event</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select02">Wallet to Connect</label>
                        <select id="select02" name="wallet" data-toggle="select" class="form-control">
                            <option selected="">Wallet to Connect</option>
                            @foreach (Auth::user()->wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-header-large bg-white">
            <h5 class="mb-0">Previous Card Requests</h5>
        </div>
        <div class="card-body p-0">
            @php
                $cardRequests = \App\Models\CardRequest::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
            @endphp

            @if ($cardRequests->isEmpty())
                <p class="text-muted">You have no previous card requests.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Reason</th>
                                <th>Card Type</th>
                                <th>Wallet</th>
                                <th>Status</th>
                                <th>Requested At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cardRequests as $request)
                                <tr>
                                    <td class="py-4">{{ $request->reason }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $request->card_type)) }}</td>
                                    <td>{{ $request->wallet->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($request->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif ($request->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection