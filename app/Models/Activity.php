<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'points_earned',
        'join_date',
        'complate_date',
        'has_paid', // Add has_paid to fillable attributes
        'wallet_id', // Add wallet_id to fillable attributes
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

    /**
     * Define the relationship with the Wallet model.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the short name of the user who created the event.
     *
     * @return string|null
     */
    public function getUserShortnameAttribute()
    {
        return $this->user ? $this->user->get_shortname() : null;
    }

    /**
     * Get the name of the user who created the event.
     *
     * @return string|null
     */
    public function getUserFullNameAttribute()
    {
        return $this->user ? $this->user->get_fullname() : null;
    }
}
