<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserConnection extends Model
{
    use HasFactory;

	/**
	 * @var string[]
	 */
	protected $hidden   = ['created_at', 'updated_at'];

	/**
	 * @return BelongsTo
	 */
	public function userConnectionStatus(): BelongsTo
	{
		return $this->belongsTo(UserConnectionStatus::class, 'user_connection_status_id');
	}

	/**
	 * @return BelongsToMany
	 */
	public function userIdA(): BelongsToMany
	{
		return $this->belongsToMany(User::class, null, 'user_id_a');
	}

//	/**
//	 * @return BelongsToMany
//	 */
//	public function userIdB(): BelongsToMany
//	{
//		return $this->belongsToMany(User::class, 'users', 'user_id_b');
//	}

}
