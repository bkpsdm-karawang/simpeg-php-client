<?php

namespace SimpegClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OauthClient
{
    /**
     * client configruation.
     *
     * @var array
     */
    protected $config;

    /**
     * storage token file.
     *
     * @var string
     */
    protected $tokenFile;

    /**
     * guzzle client interface.
     *
     * @var Client
     */
    protected $client;

    /**
     * token response from simpeg.
     *
     * @var array
     */
    protected $token = null;

    /**
     * constructor.
     *
     * @param ClientInterface $client
     *
     * @return void
     */
    public function __construct(Client $client, array $config, string $file = 'app/client.json')
    {
        $this->config = $config;
        $this->client = $client;
        $this->tokenFile = storage_path($file);
        $this->initToken();
    }

    /**
     * initial client token.
     */
    protected function initToken()
    {
        if (file_exists($this->tokenFile)) {
            $this->setToken(json_decode(file_get_contents($this->tokenFile), true));

            return;
        }

        $this->getToken();
    }

    /**
     * set client token.
     */
    public function setToken(array $token): void
    {
        $this->token = $token;
    }

    /**
     * get token from simpeg.
     */
    public function getToken()
    {
        if (isset($this->token)) {
            return $this->token;
        }

        $response = null;

        $credentials = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope' => isset($this->config['client_scope']) ? explode(',', $this->config['client_scope']) : ['*'],
        ];

        try {
            $response = $this->client->post($this->config['issue_token_url'], ['form_params' => $credentials]);
        } catch (ClientException $err) {
            $response = $err->getResponse();
        }

        if (isset($response)) {
            $token = $this->handleResponse($response);
            $writeData = json_encode($token);
            file_put_contents($this->tokenFile, $writeData);

            return $this->token = $token;
        }

        throw new \Exception('Invalid response');
    }

    /**
     * make request.
     */
    public function makeRequest($method = 'GET', string $endpoint, array $options = [])
    {
        try {
            if (!isset($options['headers']) && !isset($options['headers']['Authorization'])) {
                $headers = $this->createTokenHeader($this->token);
                $options = array_merge(['headers' => $headers], $options);
            }

            return $this->client->request($method, $endpoint, $options);
        } catch (ClientException $error) {
            return $error->getResponse();
        }
    }

    public function handleResponse(Response $response)
    {
        $body = $response->getBody();
        $content = $body->getContents();
        $data = json_decode($content, true);

        if (200 === $response->getStatusCode()) {
            return $data;
        }

        throw new HttpException($response->getStatusCode(), $data['hint'] ?? $data['message']);
    }

    /**
     * generate bearer token authorization.
     */
    protected function createTokenHeader(): array
    {
        if (!$this->token) {
            throw new InvalidArgumentException('Not token availbale');
        }

        return [
            'Authorization' => "{$this->token['token_type']} {$this->token['access_token']}",
        ];
    }
}
