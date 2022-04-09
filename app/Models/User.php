<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
		'email_verified',
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

	public function groups(): BelongsToMany
	{
		return $this->belongsToMany(Group::class)->withPivot('is_admin');
	}

	public function events(): BelongsToMany
	{
		return $this->belongsToMany(Event::class)->withPivot('confirmed');
	}

	public function userConnections(): HasMany
	{
		return $this->hasMany(UserConnection::class, 'user_id_a');
	}
}
