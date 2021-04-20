<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'roles_abilities', 'role_id', 'ability_id', 'id', 'id');
    }
}
