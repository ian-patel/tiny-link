<?php

namespace App\Auth\Guards;

use App\User;
use App\AuthToken;
use Firebase\JWT\JWT;
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

        // Currently only coockie based authentication implemented
        if (false and $this->request->bearerToken()) {
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
    protected function authenticateViaCookie(): ?User
    {
        // If we need to retrieve the token from the cookie, it'll be encrypted so we must
        // first decrypt the cookie and then attempt to find the token value within the
        // database. If we can't decrypt the value we'll bail out with a null return.
        try {
            $payload = $this->decodeJwtTokenCookie();
            $userId = $payload['sub'];
        } catch (Exception $e) {
            return null;
        }

        // User id not found in token's payload
        if (null === $userId) {
            return null;
        }

        // Get all user's tokens and check token is valid
        $token = $this->request->cookie(Passport::cookie());
        if (false === $this->isValidAuthToken($userId, $token)) {
            return null;
        }

        // If this user exists, we will return this user and attach a "transient" token to
        // the user model. The transient token assumes it has all scopes since the user
        // is physically logged into the application via the application's interface.
        if ($user = $this->provider->retrieveById($userId)) {
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
            $this->request->cookie(Passport::cookie()), // decrypted cookie
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
        // Delete the token
        $token = $this->request->cookie(Passport::cookie());
        AuthToken::query()->token($token)->delete();

        Cookie::queue(Cookie::forget(Passport::cookie()));

        return true;
    }

    /**
     * Determine weather Authtoken is valid.
     *
     * @param integer $userId
     * @param string $token
     * @return boolean
     */
    private function isValidAuthToken(int $userId, string $token): bool
    {
        return AuthToken::query()
            ->where('user_id', $userId)
            ->token($token)
            ->notExpired()
            ->count() >=1;
    }
}
