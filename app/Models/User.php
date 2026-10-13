<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'phone',
    'bio',
    'age',
    'gender',
    'location',
    'profile_image',
    'gallery',
    'likes',
    'comments',
    'views',
])]

#[Hidden([
    'password',
    'remember_token',
])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

            // JSON fields
            'gallery' => 'array',
            'comments' => 'array',
            'likes' => 'array',

            // Normal numbers
            'age' => 'integer',
            'views' => 'integer',
        ];
    }
}