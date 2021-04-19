<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'gender', 'country', 'birthday',
    ];

    // Inverse of One-to-One (Profile belongs to One User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
