<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // One-to-One (User has one Profile)
    public function profile()
    {
        return $this->hasOne(
            Profile::class, // Related model
            'user_id',      // FK for current model in the related model
            'id'            // PK in the current model
        )->withDefault();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->withDefault();
    }

    public function hasAbility($ability)
    {
        return $this->role->abilities()->where('code', $ability)->exists();
    }

    public function posts()
    {
        // posts.user_id = users.id
        return $this->hasMany(Post::class);
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }
}
