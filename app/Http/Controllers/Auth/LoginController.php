<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use App\Supports\AuthCookie;
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
        // Auth::login($user);

        return redirect()->to('/')
            ->withCookie(AuthCookie::make($user));
    }

    /**
     * Test Login
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return [type]           [description]
     */
    public function testLogin(Request $request, User $user)
    {
        // Login user in session
        // Auth::login($user);

        // Login user in session
        return response()->json($user)
            ->withCookie(AuthCookie::make($user));
    }
}
