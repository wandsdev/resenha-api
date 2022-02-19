<?php

namespace Support\User\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
		'user_name',
        'email',
        'password',
		'validation_code',
		'validation_code_validation_date',
		'email_verified'
    ];

    protected $hidden = [
        'password',
        'remember_token',
		'validation_code',
		'validation_code_validation_date',
		'email_verified',
		'updated_at',
		'created_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
		'email_verified' => 'boolean'
    ];
}
