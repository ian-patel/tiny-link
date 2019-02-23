<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use Illuminate\Http\Request;
use App\Auth\Passport\CookieFactory;
use App\Http\Controllers\Controller;
use App\Supports\SocialAccountService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The API token cookie factory instance.
     *
     * @var App\Auth\Passport\CookieFactory
     */
    protected $cookieFactory;

    /**
     * Create a new controller instance.
     *
     * @param  App\Auth\Passport\CookieFactory  $cookieFactory
     * @return void
     */
    public function __construct(CookieFactory $cookieFactory)
    {
        $this->cookieFactory = $cookieFactory;
    }

    /**
     * Redirect to social website
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Redirect callback
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, string $provider, SocialAccountService $service)
    {
        if ($request->has('denied')) {
            return redirect('/');
        }

        $providerUser = Socialite::driver($provider)->user();
        $user = $service->createOrGetUser($provider, $providerUser);

        // Login user in session
        Auth::login($user);

        return redirect()->to('/')
            ->withCookie($this->createCookie($request, $user));
    }

    /**
     * Create cookie after the user is authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed $user
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    protected function createCookie(Request $request, $user)
    {
        $this->cookieFactory->remember('forever');

        return $this->cookieFactory->make(
            $user->getKey()
        );
    }
}
