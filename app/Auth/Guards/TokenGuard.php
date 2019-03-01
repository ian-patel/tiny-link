<?php

namespace App\Auth\Guards;

use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use App\Auth\Passport\Passport;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Auth\TokenGuard as BaseTokenGuard;

class TokenGuard extends BaseTokenGuard
{
    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $storageKey = 'api_token';

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if ($this->user) {
            return $this->user;
        }

        if ($this->request->bearerToken()) {
            return $this->authenticateViaBearerToken();
        } elseif ($this->request->cookie(Passport::cookie())) {
            return $this->authenticateViaCookie();
        }
    }

    /**
     * Authenticate the incoming request via the token cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function authenticateViaCookie()
    {
        // If we need to retrieve the token from the cookie, it'll be encrypted so we must
        // first decrypt the cookie and then attempt to find the token value within the
        // database. If we can't decrypt the value we'll bail out with a null return.
        try {
            $token = $this->decodeJwtTokenCookie();
        } catch (Exception $e) {
            return;
        }

        // If this user exists, we will return this user and attach a "transient" token to
        // the user model. The transient token assumes it has all scopes since the user
        // is physically logged into the application via the application's interface.
        if ($user = $this->provider->retrieveById($token['sub'])) {
            $this->user = $user;
            return $user;
        }
    }

    /**
     * Decode and decrypt the JWT token cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function decodeJwtTokenCookie()
    {
        $encrypter = getEncrypter();

        return (array) JWT::decode(
            $this->decryptCookie($this->request->cookie(Passport::cookie())),
            $encrypter->getKey(),
            ['HS256']
        );
    }

    /**
     * Authenticate the incoming request via the Bearer token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function authenticateViaBearerToken()
    {
        $token = $this->request->bearerToken();

        if (! empty($token)) {
            $user = $this->provider->retrieveByCredentials(
                [$this->storageKey => $token]
            );
        }

        return $this->user = $user;
    }

    /**
     * Log the user out of the application.
     *
     * @return bool
     */
    public function logout()
    {
        $this->request->session()->invalidate();

        Cookie::queue(Cookie::forget(Passport::cookie()));
        Cookie::queue(Cookie::forget(Passport::remember()));

        return true;
    }

    /**
     * Decrypt Cookie
     *
     * @param  string $value
     * @return string
     */
    public function decryptCookie($cookie)
    {
        return getEncrypter()->decrypt($cookie, false);
    }
}
