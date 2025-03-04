<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // "roles" tablosu varsayılan olarak kullanılır.
    // Mass assignment için izin verilen alanlar:
    protected $fillable = ['name'];

    /**
     * Bu role ait tüm kullanıcılar.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Bu role ait tüm izinler.
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
