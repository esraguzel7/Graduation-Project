<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PossitivePoint extends Model
{
    // İzin verilen alanlar
    protected $fillable = [
        'user',
        'start_date',
        'end_date',
        'joined_event_count',
        'total_earned',
        'history_period',
    ];

    /**
     * Bu kaydın sahibi kullanıcı.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * Bu PossitivePoint kaydına ait notlar.
     */
    public function notes()
    {
        return $this->hasMany(PossitivePointNote::class, 'history');
    }
}
