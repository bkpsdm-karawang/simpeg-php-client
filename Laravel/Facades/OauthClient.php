<?php

namespace SimpegClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimpegClient\Oauth setToken(): void
 * @method static \SimpegClient\Oauth getToken()
 * @method static \SimpegClient\Oauth getUser(array $credentials = null)
 * @see \SimpegClient\Oauth
 */
class OauthClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simpeg.oauth-client';
    }
}
