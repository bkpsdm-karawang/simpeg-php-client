<?php

namespace SipmegClient;

use GuzzleHttp\ClientInterface;

class Oauth
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
}
