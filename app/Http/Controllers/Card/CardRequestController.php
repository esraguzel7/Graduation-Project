<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardRequest;

class CardRequestController extends Controller
{
    public function cancel(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:card_requests,id',
        ]);

        $cardRequest = CardRequest::where('id', $request->id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->first();

        if (!$cardRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to cancel the request. Either it does not exist or is not pending.',
            ], 400);
        }

        $cardRequest->update(['status' => 'cancelled']);

        return response()->json([
            'status' => true,
            'message' => 'The card request has been successfully cancelled.',
            'reload' => true,
        ]);
    }
}
