<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnectionStatus extends Model
{
    use HasFactory;

	/**
	 * @var string
	 */
    protected $table = 'user_connection_status';

	/**
	 * @var string[]
	 */
	protected $hidden   = ['created_at', 'updated_at'];

	/**
	 * Get the comments for the blog post.
	 */
	public function userConnections(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(UserConnection::class);
	}
}
