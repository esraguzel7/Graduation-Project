@extends('main')

@php
    $page = 'Create Wallet';
    $breadcrumb = [
        'My Wallets' => route('wallet.mywallets.show'),
        'Create New Wallet',
    ];
@endphp

@section('content')
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-4 card-body">
                <p><strong class="headings-color">Create New Wallet</strong></p>
                <p class="text-muted">
                    This form is used to create a new wallet and submit a request to change the minimum balance value.
                    Please fill out the required fields to proceed with your request.
                </p>
            </div>
            <div class="col-lg-8 card-form__body card-body">
                <form class="ajax-form">
                    <div class="form-group">
                        <label for="wallet_name">Wallet Name</label>
                        <input type="text" name="name" id="wallet_name" class="form-control"
                            placeholder="Enter wallet name" required>
                    </div>
                    <div class="form-group">
                        <label for="wallet_description">Wallet Description</label>
                        <textarea name="description" id="wallet_description" class="form-control"
                            placeholder="Enter wallet description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Wallet</button>
                </form>
            </div>
        </div>
    </div>
@endsection