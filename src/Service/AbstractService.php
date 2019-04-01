<?php
/**
 * Define base services.
 */

namespace Splio\Service;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\RequestOptions;

abstract class AbstractService
{
    protected $baseUrl;
    protected $version;
    protected $universe;
    protected $path;
    protected $key;
    protected $endpoint;
    protected $client;

    abstract protected function getPath();
    abstract protected function setEndpoint();

    public function __construct($config)
    {
        $this->baseUrl = $config['domain'];
        $this->version = $config['version'];
        $this->key = $config['key'];
        $this->universe = $config['universe'];
        $this->path = $this->getPath();
        $this->client = new HttpClient();

        $this->setEndpoint();
    }

    /**
     * Request Splio API.
     *
     * @param string $action  | Action to call (ex: lists, contact ...)
     * @param string $method  | GET, POST, PUT, DELETE
     * @param array  $params  | params to append in URL
     * @param array  $options
     */
    protected function request($action, $method = 'GET', $params = [], $options = [], $separator = '/'): GuzzleResponse
    {
        $res = $this->client->request($method,
            $this->endpoint.$separator.$action, ['body' => json_encode($params)]
        );

        return $res;
    }
}
