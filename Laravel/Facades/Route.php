<?php

namespace SimpegClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimpegClient\Client routes($callback = null, array $options = [])
 * @see \SimpegClient\Laravel\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simpeg.route';
    }
}
