<?php

namespace SimpegClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

class Oauth
{
    /**
     * client configruation.
     *
     * @var array
     */
    protected $config;

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
     * user simpeg.
     *
     * @var array
     */
    protected $user = null;

    /**
     * constructor.
     *
     * @param ClientInterface $client
     *
     * @return void
     */
    public function __construct(Client $client, array $config = [])
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * get token from simpeg.
     */
    public function getToken(string $code = null)
    {
        if (isset($this->token)) {
            return $this->token;
        }

        $response = null;

        $credentials = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['client_callback_url'],
            'scope' => $this->config['user_scope'],
            'code' => $code,
        ];

        try {
            $response = $this->client->post($this->config['issue_token_url'], ['form_params' => $credentials]);
        } catch (ClientException $err) {
            $response = $err->getResponse();
        }

        if (isset($response)) {
            return $this->token = $this->handleResponse($response);
        }

        throw new \Exception('Invalid response');
    }

    /**
     * set token from local.
     */
    public function setToken(string $accessToken, string $refreshToken, $expiresIn = 0): void
    {
        $this->token = [
            'token_type' => 'Bearer',
            'expires_in' => $expiresIn,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
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

    /**
     * get user simpeg.
     */
    public function getUser(string $code = null)
    {
        if (isset($this->user)) {
            return $this->user;
        }

        if (!$this->token && !is_null($$code)) {
            $this->getToken($code);
        }

        $response = $this->makeRequest('GET', $this->config['get_profile_url']);

        if (isset($response)) {
            return $this->user = $this->handleResponse($response);
        }

        return null;
    }

    protected function handleResponse(Response $response)
    {
        $body = $response->getBody();
        $content = $body->getContents();
        $data = json_decode($content, true);

        if (200 === $response->getStatusCode()) {
            return $data;
        }

        throw new \Exception($data['hint'] ?? $data['message']);
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
