<?php

namespace App\Auth\Passport;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Facades\Cookie as CookieJar;

class CookieFactory
{
    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * Lifetime for the cookie token.
     *
     * @var int
     */
    protected $lifetime;

    /**
     * Create an API token cookie factory instance.
     *
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * Create a new API token cookie.
     *
     * @param  mixed  $userId
     * @param  string  $csrfToken
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function make($userId)
    {
        $config = config('session');

        $expiration = Carbon::now()->addMinutes($this->lifetime ?? $config['lifetime']);

        return new Cookie(
            Passport::cookie(),
            $this->createToken($userId, request()->session()->token(), $expiration),
            $expiration,
            $config['path'],
            $config['domain'],
            $config['secure'],
            true
        );
    }

    /**
     * Create a new JWT token for the given user ID and CSRF token.
     *
     * @param  mixed  $userId
     * @param  string  $csrfToken
     * @param  \Carbon\Carbon  $expiration
     * @return string
     */
    protected function createToken($userId, $csrfToken, Carbon $expiration)
    {
        return JWT::encode([
            'sub' => $userId,
            'csrf' => $csrfToken,
            'expiry' => $expiration->getTimestamp(),
        ], $this->encrypter->getKey());
    }

    /**
     * Set token lifetime and create remember cookie based on lifetime.
     *
     * @param string|int $lifetime
     * @return App\Auth\Passport\CookieFactory
     */
    public function remember($lifetime = null)
    {
        $this->setCookieLifetime($lifetime);

        $this->createRememberCookie();

        return $this;
    }

    /**
     * Set lifetime for a token.
     *
     * @param string|int $lifetime
     */
    protected function setCookieLifetime($lifetime = null)
    {
        if ($lifetime == 'forever') {
            // that lasts "forever" (five years).
            $this->lifetime = 2628000;
        } else {
            $this->lifetime = $lifetime;
        }
    }

    /**
     * Create remember cookie
     *
     * @param string|int $lifetime
     */
    protected function createRememberCookie()
    {
        CookieJar::queue(Passport::remember(), csrf_token(), $this->lifetime);
    }
}
