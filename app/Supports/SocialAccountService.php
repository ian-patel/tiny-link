<?php

namespace App\Supports;

use App\User;
use App\Account;
use App\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    /**
     * Create/Get the soical user
     *
     * @param  string       $provider
     * @param  ProviderUser $providerUser
     * @return User         $user
     */
    public function createOrGetUser(string $provider, ProviderUser $providerUser): User
    {
        $user = User::query()
            ->provider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if (null !== $user) {
            return $user;
        }

        // Create account for the user
        $account = Account::create([
            'name' => $providerUser->getName(),
        ]);

        // Create Instance of the user
        $user = (new User)->newInstance([
            'role' => 'owner',
            'provider' => $provider,
            'name' => $providerUser->getName(),
            'email' => $providerUser->getEmail(),
            'avatar' => $providerUser->getAvatar(),
            'provider_user_id' => $providerUser->getId(),
        ]);

        // Associate user to the account
        $user->account()->associate($account);
        $user->save();

        $account->createdBy($user);

        return $user;
    }
}
