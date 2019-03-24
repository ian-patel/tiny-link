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
        return [
            'auth' => [
                'user' => $user,
                'account' => $user->account ?? null,
            ],
            'domains' => $user->account->domains ?? null,
            'links' => [
                'data' => $user->account->links()->limit(10)->latest()->get() ?? null,
                'activeLink' => null,
            ],
        ];
    }
}
