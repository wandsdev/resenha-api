<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventUser extends Model
{
    use HasFactory;

	/**
	 * @var string[]
	 */
	protected $hidden   = ['created_at', 'updated_at'];

	/**
	 * @return BelongsToMany
	 */
	public function events(): BelongsToMany
	{
		return $this->belongsToMany(Event::class)->withPivot('confirmed');
	}

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)->withPivot('confirmed');
	}
}
