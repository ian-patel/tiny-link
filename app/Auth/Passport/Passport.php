<?php

namespace App\Auth\Passport;

class Passport
{
    /**
     * The name for API token cookies.
     *
     * @var string
     */
    public static $cookie = 'auth_token';

    /**
     * The name for remember cookie.
     *
     * @var string
     */
    public static $remember = 'remember';

    /**
     * Get or set the name for API auth token cookies.
     *
     * @param  string|null  $cookie
     * @return string|static
     */
    public static function cookie($cookie = null)
    {
        if (null === $cookie) {
            return static::$cookie;
        }

        static::$cookie = $cookie;

        return new static;
    }

    /**
     * Get or set the name for remember cookie.
     *
     * @param  string|null  $remember
     * @return string|static
     */
    public static function remember($remember = null)
    {
        if (null === $remember) {
            return static::$remember;
        }

        static::$remember = $remember;

        return new static;
    }
}
