<?php

namespace SimpegClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimpegClient\Oauth setToken(string $accessToken, string $refreshToken, $expiresIn = 0): void
 * @method static \SimpegClient\Oauth getToken(string $code = null)
 * @method static \SimpegClient\Oauth getUser(string $code = null)
 * @see \SimpegClient\Oauth
 */
class Oauth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simpeg.oauth';
    }
}
