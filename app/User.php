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
        'name',
        'owner',
        'email',
        'avatar',
        'provider',
        'password',
        'account_id',
        'provider_user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'updated_at',
        'account_id',
        'remember_token',
        'provider_user_id',
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

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if (!$this->uuid) {
            $this->uuid = uuid();
        }

        return parent::save($options);
    }
}
