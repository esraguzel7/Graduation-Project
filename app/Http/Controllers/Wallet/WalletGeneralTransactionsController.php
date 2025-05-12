<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletGeneralTransactionsController extends Controller
{
    public function show()
    {
        return view('wallet.generaltransactions');
    }
}
