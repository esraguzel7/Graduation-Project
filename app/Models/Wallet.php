<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'balance',
        'minimum_balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function cardRequests()
    {
        return $this->hasMany(CardRequest::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
