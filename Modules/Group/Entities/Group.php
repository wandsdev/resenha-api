<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Entities\User;

class Group extends Model
{
    use HasFactory;

	/**
	 * @var string[]
	 */
	protected $hidden   = ['created_at', 'updated_at'];

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)->withPivot('is_admin');
	}
}
