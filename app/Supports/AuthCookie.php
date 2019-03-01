<?php

namespace App\Supports;

use App\User;
use Carbon\Carbon;
use App\Auth\Passport\Passport;
use Symfony\Component\HttpFoundation\Cookie;

class AuthCookie
{
    /**
     * Lifetime for the cookie token.
     * that lasts "forever" (five years).
     *
     * @var int
     */
    const LIFETIME = 2628000;

    /**
     * Create a new Auth token cookie.
     *
     * @param  User  $User
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public static function make(User $user): Cookie
    {
        $config = config('session');

        $expiration = Carbon::now()->addMinutes(self::LIFETIME);
        $token = $user->createToken($expiration);

        return new Cookie(
            Passport::cookie(),
            $token,
            $expiration,
            $config['path'],
            $config['domain'],
            $config['secure'],
            true
        );
    }
}
