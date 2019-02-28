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
        return [
            'auth' => [
                'user' => request()->user(),
            ]
        ];
    }
}
