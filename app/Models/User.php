<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * get user role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * check user permission for single route name
     *
     * @param  mixed $routeName
     * @return bool
     */
    public function hasPermission(string $routeName): bool
    {
        // Eğer kullanıcıya ait role yoksa false döner.
        if (!$this->role) {
            return false;
        }

        // Kullanıcının role'ü altında, belirtilen rule'a sahip bir izin var mı?
        return $this->role->permissions()->where('rule', $routeName)->exists();
    }

    /**
     * get possitive point history for user
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function possitivePoint()
    {
        return $this->hasMany(PossitivePoint::class, 'user');
    }

    /**
     * possitivePointNotes
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function possitivePointNotes()
    {
        return $this->hasManyThrough(
            PossitivePointNote::class,  // Son model
            PossitivePoint::class,      // Ara model
            'user',                     // PossitivePoint tablosunda kullanıcıyı belirten sütun
            'history',                  // PossitivePointNote tablosunda PossitivePoint kaydını belirten sütun
            'id',                       // User tablosundaki yerel anahtar
            'id'                        // PossitivePoint tablosundaki yerel anahtar
        );
    }

    /**
     * getNotesByLevel
     *
     * @param  mixed $level
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNotesByLevel(string $level)
    {
        return $this->possitivePointNotes()->where('level', $level)->get();
    }

    /**
     * countNotesByLevel
     *
     * @param  mixed $level
     * @return int
     */
    public function countNotesByLevel(string $level): int
    {
        return $this->possitivePointNotes()->where('level', $level)->count();
    }

    /**
     * reminer
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * upcomingActivities
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function upcomingActivities()
    {
        return $this->activities()
            ->where('join_date', '>', Carbon::now())
            ->get();
    }
}
