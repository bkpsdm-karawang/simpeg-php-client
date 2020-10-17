<?php

namespace SimpegClient\Laravel;

use GuzzleHttp\Client;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;
use SimpegClient\ClientManager;
use SimpegClient\Oauth;

class SimpegClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config.php' => config_path('simpeg.php'),
            ], 'simpeg-config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'simpeg');
        $config = $this->app->make(Config::class)->get('simpeg');

        $this->app->singleton('simpeg.oauth', function () use ($config) {
            return new Oauth($this->createGuzzleClient($config));
        });

        $this->app->singleton('simpeg.client', function () use ($config) {
            return new ClientManager($this->createGuzzleClient($config));
        });

        $this->app->singleton('simpeg.route', function () use ($config) {
            return new Router($config);
        });
    }

    /**
     * create guzzle client
     *
     * @param array $config
     * @return \GuzzleHttp\Client
     */
    protected function createGuzzleClient(array $config)
    {
        return new Client([
            'verify' => false,
            'base_uri' => $config['client_uri']
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'simpeg.oauth',
            'simpeg.client',
            'simpeg.route'
        ];
    }
}
