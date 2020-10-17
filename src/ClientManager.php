<?php

namespace SipmegClient;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Manager;
use InvalidArgumentException;

class ClientManager extends Manager
{
    /**
     * guzzle client interface
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * constructor
     *
     * @param ClientInterface $client
     *
     * @return void
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * ceate module
     *
     * @param string $name
     * @return \SipmegClient\Modules\ModuleContract
     */
    public function module(string $name)
    {
        return $this->driver($name);
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
