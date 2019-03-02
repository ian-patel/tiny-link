<?php

namespace App;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class AuthToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'expire_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    /**
     * Get the user that owns the token.
     */
    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the device of the token.
     */
    public function device(): Relation
    {
        return $this->hasOne(Device::class);
    }

    /**
     * Get the location of the token.
     */
    public function location(): Relation
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Scope a query to only which are not expired.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expire_at', '>', now());
    }

    /**
     * Create a new JWT token for the given user
     *
     * @param  User  $user
     * @param  \Carbon\Carbon  $expiration
     * @return string
     */
    private function createToken($userId, Carbon $expiration)
    {
        $token = JWT::encode([
            'sub' => $userId,
            'csrf' => csrf_token(),
            'expiry' => $expiration->getTimestamp(),
        ], getEncrypter()->getKey());

        return $token;
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if (!$this->exists) {
            $this->token = $this->createToken($this->user_id, $this->expire_at);
            $this->location_id = Location::create(getGeoIP()->get())->id;
            $this->device_id = Device::create()->id;
        }

        // Save
        return parent::save($options);
    }
}
