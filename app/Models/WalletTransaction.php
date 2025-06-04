<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'current_balance',
        'amount',
        'new_balance',
        'message',
        'user_note',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
