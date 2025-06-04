<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAnnouncement extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'message',
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
