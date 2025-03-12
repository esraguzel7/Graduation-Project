<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardHistory extends Model
{
    protected $fillable = [
        'card_id',
        'old_balance',
        'new_balance',
        'details',
    ];
    
    /**
     * card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
