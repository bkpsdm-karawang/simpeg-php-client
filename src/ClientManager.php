<?php

namespace SimpegClient;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use SimpegClient\Modules\Pegawai;
use SimpegClient\Modules\User;

class ClientManager extends Manager
{
    /**
     * ouath client.
     *
     * @var OauthClient
     */
    protected $oauthClient;

    /**
     * constructor.
     *
     * @param ClientInterface $client
     *
     * @return void
     */
    public function __construct(OauthClient $oauthClient)
    {
        $this->oauthClient = $oauthClient;
    }

    /**
     * ceate module.
     *
     * @return \SipmegClient\Modules\ModuleContract
     */
    public function module(string $name)
    {
        return $this->driver($name);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \SimpegClient\Modules\AbstractModule
     */
    protected function createUserDriver()
    {
        return new User($this->oauthClient);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \SimpegClient\Modules\AbstractModule
     */
    protected function createPegawaiDriver()
    {
        return new Pegawai($this->oauthClient);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No simpeg client driver was specified.');
    }
}
