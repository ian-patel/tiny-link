<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_user_id', 'owner', 'avatar', 'account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the account that owns the user.
     */
    public function account(): Relation
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Scope a query to only include provider.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvider($query, $provider): Builder
    {
        return $query->where('provider', $provider);
    }

    /**
     * Create AuthToken and associate with this user.
     *
     * @param Carbon $expiration
     * @return string $token
     */
    public function createToken(Carbon $expiration): string
    {
        $token = (new AuthToken)->newInstance(['expire_at' => $expiration]);
        $token->user()->associate($this);
        $token->save();

        return $token->token;
    }
}
