<?php

namespace SimpegClient\Laravel;

use Illuminate\Support\Facades\Route;

class Router
{
    /**
     * configuration.
     *
     * @var array
     */
    protected static $config = [];

    /**
     * constructor.
     *
     * @return void
     */
    public function __construct(array $config)
    {
        static::$config = $config;
    }

    /**
     * Binds the SOTK routes into the controller.
     *
     * @param callable|null $callback
     *
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'namespace' => '\SimpegClient\Laravel\Http\Controllers',
        ];

        if (isset(static::$config['prefix'])) {
            $defaultOptions['prefix'] = static::$config['prefix'];
        }

        if (isset(static::$config['middleware'])) {
            $defaultOptions['middleware'] = static::$config['middleware'];
        }

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
