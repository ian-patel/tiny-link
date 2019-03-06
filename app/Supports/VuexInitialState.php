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
                'account' => optional($user)->account,
            ]
        ];
    }
}
