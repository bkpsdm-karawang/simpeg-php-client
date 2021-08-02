<?php

namespace SimpegClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimpegClient\Client module(string $module)
 *
 * @see \SimpegClient\Client
 */
class SimpegClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simpeg.client';
    }
}
