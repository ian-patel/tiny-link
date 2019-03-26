<?php

namespace App\Supports;

class VuexInitialState
{
    /**
     * Undocumented function
     *
     * @return array
     */
    public static function session(): array
    {
        $user = request()->user();
        $account = $user->account ?? null;
        return [
            'auth' => [
                'user' => $user,
                'account' => $account ?? null,
            ],
            'domains' => $account->domains ?? null,
            'links' => [
                'data' => $account ? $account->links()->limit(10)->latest()->get()->keyBy('uuid') ?? null : null,
                'activeLink' => null,
            ],
        ];
    }
}
