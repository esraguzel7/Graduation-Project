<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'type',
        'last_connection',
    ];
    
    /**
     * cardPassHistories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cardPassHistories()
    {
        return $this->hasMany(CardPassHistory::class);
    }
    
    /**
     * readerSensors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readerSensors()
    {
        return $this->hasMany(ReaderSensor::class);
    }
}
