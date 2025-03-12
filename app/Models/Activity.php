<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'points_earned',
        'join_date',
        'complate_date',
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
     * event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    /**
     * reminer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminer()
    {
        return $this->hasMany(ActivityReminer::class);
    }
}
