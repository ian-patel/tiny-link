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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_by',
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
     * Get the links for the account.
     */
    public function links(): Relation
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Set the user who created this account
     * @param  User   $user
     * @return bool
     */
    public function createdBy(User $user): bool
    {
        $this->created_by_id = $user->id;
        return $this->save();
    }
}
