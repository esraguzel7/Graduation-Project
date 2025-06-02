<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardRequest;

class OrderNewCardController extends Controller
{
    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('card.ordernewcard');
    }

    public function order(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'card_type' => 'required|string|max:255',
            'wallet' => 'required|exists:wallets,id',
        ]);

        CardRequest::create([
            'user_id' => $request->user()->id,
            'reason' => $request->input('reason'),
            'card_type' => $request->input('card_type'),
            'wallet_id' => $request->input('wallet'),
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Your new card application has been received. Your application will be reviewed.',
            'reload' => true,
        ]);
    }
}
