<?php

namespace SimpegClient\Modules;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\InvalidArgumentException;
use SimpegClient\OauthClient;

abstract class BaseModule
{
    /**
     * ouath client
     *
     * @var \SimpegClient\OauthClient
     */
    protected $oauthClient;

    /**
     * base endpoint of module
     *
     * @var string
     */
    protected $endpoint;

    /**
     * query params
     *
     * @var array
     */
    protected $query = [];

    /**
     * constructor
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
     * with query string
     * @param string $relation
     * @return ModuleAbstract
     */
    public function with(string $relation)
    {
        if (isset($this->query['with'])) {
            $this->query['with'] .= ','.$relation;
        } else {
            $this->query['with'] = $relation;
        }

        return $this;
    }

    /**
     * search query string
     * @param string $keyword
     * @return ModuleAbstract
     */
    public function search(string $keyword)
    {
        $this->query['search'] = $keyword;

        return $this;
    }

    /**
     * get listing data.
     *
     * @param array $query
     * @return array
     * @throws Exception
     */
    public function getList(array $query = [])
    {
        $response = null;

        try {
            $response = $this->oauthClient->makeRequest('GET', $this->endpoint, ['query' => $this->buildQuery($query)]);
        } catch (ClientException $error) {
            $response = $error->getResponse();
        }

        if (isset($response)) {
            return $this->oauthClient->handleResponse($response);
        }

        throw new Exception('Request has no response');
    }

    /**
     * get detail data.
     *
     * @param mixed $identifier
     * @param array $query
     */
    public function getDetail($identifier, array $query = []): array
    {
        $response = null;

        try {
            $response = $this->oauthClient->makeRequest('GET', "{$this->endpoint}/{$identifier}", ['query' => $this->buildQuery($query)]);
        } catch (ClientException $error) {
            $response = $error->getResponse();
        }

        if (isset($response) && $response->getStatusCode() === 200) {
            return $this->oauthClient->handleResponse($response);
        }

        throw new Exception('Request has no response');
    }

    /**
     * build query params.
     *
     * @param array $query
     * @return array
     */
    protected function buildQuery(array $query = []) : array
    {
        return array_merge_recursive($this->query, $query);
    }

    /**
     * proxy to client.
     *
     * @param array $arguments
     * @return ReponseContract
     */
    public function __call($name, array $arguments)
    {
        if (method_exists($this->client, $name)) {
            return call_user_func_array([$this->client, $name], $arguments);
        }

        throw new InvalidArgumentException("{$name} is not defined method");
    }
}
