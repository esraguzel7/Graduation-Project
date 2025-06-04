<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReaderSensor extends Model
{
    protected $fillable = [
        'reader_id',
        'datas',
        'message',
        'is_critical',
    ];
    
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
