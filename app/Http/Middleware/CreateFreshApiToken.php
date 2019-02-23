<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Auth\Passport\Passport;
use App\Auth\Passport\CookieFactory;

class CreateFreshApiToken
{
    /**
     * The API token cookie factory instance.
     *
     * @var \App\Auth\Passport\CookieFactory
     */
    protected $cookieFactory;

    /**
     * The authentication guard.
     *
     * @var string
     */
    protected $guard;

    /**
     * Create a new middleware instance.
     *
     * @param  \App\Auth\Passport\CookieFactory  $cookieFactory
     * @return void
     */
    public function __construct(CookieFactory $cookieFactory)
    {
        $this->cookieFactory = $cookieFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->guard = $guard;

        $response = $next($request);

        if ($this->shouldReceiveFreshToken($request, $response)) {
            $response->withCookie($this->cookieFactory->make(
                $request->user($this->guard)->getKey()
            ));
        }

        return $response;
    }

    /**
     * Determine if the given request should receive a fresh token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return bool
     */
    protected function shouldReceiveFreshToken($request, $response)
    {
        return $this->requestShouldReceiveFreshToken($request) &&
               $this->responseShouldReceiveFreshToken($response);
    }

    /**
     * Determine if the request should receive a fresh token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function requestShouldReceiveFreshToken($request)
    {
        return ! $this->isTokenRemembered($request) and $request->user($this->guard);
    }

    /**
     * Determine if the response should receive a fresh token.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return bool
     */
    protected function responseShouldReceiveFreshToken($response)
    {
        return ! $this->alreadyContainsToken($response);
    }

    /**
     * Determine if the given response already contains an API token.
     *
     * This avoids us overwriting a just "refreshed" token.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return bool
     */
    protected function alreadyContainsToken($response)
    {
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() === Passport::cookie()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the given request already remembered an API token.
     *
     * This avoids us overwriting a just "refreshed" token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isTokenRemembered($request)
    {
        return $request->cookie(Passport::remember()) and
               $request->cookie(Passport::cookie());
    }
}
