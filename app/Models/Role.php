<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the users associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // Ensure 'role_id' is the correct foreign key
    }

    /**
     * Bu role ait tüm izinler.
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
