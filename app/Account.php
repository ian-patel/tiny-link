<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Account extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'name',
	];

	/**
	 * Get the users for the account.
	 */
	public function users(): Relation
	{
	    return $this->hasMany(User::class);
	}

	/**
	 * Get the domains for the account.
	 */
	public function domains(): Relation
	{
	    return $this->hasMany(Domain::class);
	}

	/**
	 * Set the user who created this account
	 * @param  User   $user
	 * @return bool
	 */
	public function createdBy(User $user): bool
	{
		$this->created_by = $user->id;
		return $this->save();
	}
}
