<?php

namespace App\Models;

use Domain\User\Status\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserConnection extends Model
{
    use HasFactory;

	public $appends = ['status_label'];

	/**
	 * @var string[]
	 */
	protected $hidden   = ['created_at', 'updated_at'];

	/**
	 * @return BelongsToMany
	 */
	public function userIdA(): BelongsToMany
	{
		return $this->belongsToMany(User::class, null, 'user_id_a');
	}

	/**
	 * @return Attribute
	 */
	protected function statusLabel(): Attribute
	{
		return Attribute::make(
			get: fn ($value, $attributes) => Status::getLabel($attributes['status'] ?? null)
		);
	}

}
