<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    // Mass assignment için izin verilen alanlar
    protected $fillable = ['role_id', 'rule'];

    /**
     * Bu izin, bir role aittir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
