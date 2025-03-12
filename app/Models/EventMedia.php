<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMedia extends Model
{
    protected $fillable = [
        'event_id',
        'media_type',
        'media_path',
    ];
    
    /**
     * event
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
