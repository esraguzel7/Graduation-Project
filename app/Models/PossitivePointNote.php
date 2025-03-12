<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PossitivePointNote extends Model
{
    // İzin verilen alanlar
    protected $fillable = [
        'history',
        'level',
        'message',
        'need_help',
    ];

    /**
     * Bu notun ait olduğu PossitivePoint kaydı.
     */
    public function possitivePoint()
    {
        return $this->belongsTo(PossitivePoint::class, 'history');
    }
}
