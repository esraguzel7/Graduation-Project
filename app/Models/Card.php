<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'card_id',
        'balance',
    ];
    
    /**
     * user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * histories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany(CardHistory::class);
    }
    
    /**
     * passHistories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passHistories()
    {
        return $this->hasMany(CardPassHistory::class);
    }
}
