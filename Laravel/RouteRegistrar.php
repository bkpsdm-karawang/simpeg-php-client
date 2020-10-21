<?php

namespace SimpegClient\Laravel;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct($router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->modulePegawai();
        $this->moduleUser();
    }

    /**
     * Register the routes for module pegawai.
     *
     * @return void
     */
    public function modulePegawai()
    {
        $this->router->get('/pegawai', ['uses' => 'PegawaiController@getList', 'as' => 'simpeg.pegawai.list']);
        $this->router->get('/pegawai/{id}', ['uses' => 'PegawaiController@getDetail', 'as' => 'simpeg.pegawai.detail']);
    }

    /**
     * Register the routes for module pegawai.
     *
     * @return void
     */
    public function moduleUser()
    {
        $this->router->get('/user', ['uses' => 'UserController@getList', 'as' => 'simpeg.user.list']);
        $this->router->get('/user/{id}', ['uses' => 'UserController@getDetail', 'as' => 'simpeg.user.detail']);
    }
}
