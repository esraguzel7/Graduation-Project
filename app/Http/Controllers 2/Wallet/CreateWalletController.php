<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateWalletController extends Controller
{
    public function show(){
        return view('wallet.createwallet');
    }

    public function create(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Create a new wallet (assuming you have a Wallet model)
        $wallet = new \App\Models\Wallet();
        $wallet->user_id = auth()->user()->id; // Assuming you have user authentication
        $wallet->name = $validatedData['name'];
        $wallet->description = $validatedData['description'];
        $wallet->balance = 0;
        $wallet->save();

        // Return a JSON response
        return response()->json([
            'status' => true,
            'message' => 'Wallet created successfully',
            'reload' => route('wallet.mywallets.show'),
        ]);
    }
}
