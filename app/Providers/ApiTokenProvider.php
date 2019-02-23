<?php

namespace App\Providers;

use App\Auth\Passport\CookieFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Encryption\Encrypter;

class ApiTokenProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Encrypter $encrypter)
    {
        $this->app->when(CookieFactory::class)
            ->needs(Encrypter::class)
            ->give(function () use ($encrypter) {
                return $encrypter;
            });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
