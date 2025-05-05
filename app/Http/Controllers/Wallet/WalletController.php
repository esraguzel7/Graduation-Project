<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function show($id)
    {
        $wallet = Wallet::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$wallet) {
            abort(404);
        }

        return view('wallet.wallet', compact('wallet'));
    }

    public function payment(Request $request, $id)
    {
        $request->validate([
            'card_number' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
            'cardholder_name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $wallet = Wallet::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$wallet) {
            return response()->json(['status' => false, 'message' => 'Wallet not found'], 404);
        }

        $amount = $request->input('amount');
        $currentBalance = $wallet->balance;
        $newBalance = $currentBalance + $amount;

        // Update wallet balance
        $wallet->balance = $newBalance;
        $wallet->save();

        // Log the transaction
        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'current_balance' => $currentBalance,
            'amount' => $amount,
            'new_balance' => $newBalance,
            'message' => 'Balance loaded via credit card',
            'user_note' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Balance successfully loaded',
            'reload' => true,
        ]);
    }
}
