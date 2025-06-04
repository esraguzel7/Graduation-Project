<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityReminer extends Model
{
    protected $fillable = [
        'activity_id',
        'send_email',
        'send_sms',
        'timer',
    ];

    /**
     * activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    
    /**
     * user
     *
     * @return User|null
     */
    public function user()
    {
        return $this->activity ? $this->activity->user : null;
    }
}
