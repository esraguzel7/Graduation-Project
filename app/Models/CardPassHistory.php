<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPassHistory extends Model
{
    protected $fillable = [
        'card_id',
        'reader_id',
        'is_succesful',
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
    
    /**
     * reader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }
}
