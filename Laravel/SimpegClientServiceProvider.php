<?php

namespace SimpegClient\Laravel;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use SimpegClient\ClientManager;
use SimpegClient\Oauth;
use SimpegClient\OauthClient;

class SimpegClientServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'simpeg');
        $config = $this->app->make('config')->get('simpeg');

        $this->app->singleton('simpeg.oauth', function () use ($config) {
            return new Oauth($this->createGuzzleClient($config), $config);
        });

        $this->app->singleton('simpeg.oauth-client', function () use ($config) {
            return new OauthClient($this->createGuzzleClient($config), $config);
        });

        $this->app->singleton('simpeg.client', function () {
            return new ClientManager($this->app->make('simpeg.oauth-client'));
        });

        $this->app->singleton('simpeg.route', function () use ($config) {
            return new Router($config);
        });
    }

    /**
     * create guzzle client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function createGuzzleClient(array $config)
    {
        return new Client([
            'verify' => false,
            'base_uri' => $config['server_url'],
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
            'simpeg.oauth-client',
            'simpeg.client',
            'simpeg.route',
        ];
    }
}
