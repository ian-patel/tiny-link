<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Illuminate\Http\Request;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

        // todo with token
        auth()->login($user);

        return redirect()->to('/');
    }
}
