<?php
/**
 * Define base services.
 */

namespace Splio\Service;

use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Splio\Exception\SplioSdkException;

abstract class AbstractService
{
    protected $baseUrl;
    protected $version;
    protected $universe;
    protected $path;
    protected $key;
    protected $endpoint;
    /** @var ClientInterface */
    private $httpClient;
    /** @var RequestFactoryInterface */
    private $requestFactory;
    /** @var StreamFactoryInterface */
    private $streamFactory;

    abstract protected function getPath();

    abstract protected function setEndpoint();

    public function __construct($config, ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->baseUrl = $config['domain'];
        $this->version = $config['version'];
        $this->key = $config['key'];
        $this->universe = $config['universe'];
        $this->path = $this->getPath();
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;

        $this->setEndpoint();
    }

    /**
     * Request Splio API.
     *
     * @param $action | Action to call (ex: lists, contact ...)
     * @param string $method | GET, POST, PUT, DELETE
     * @param array $params | params to append in URL
     * @param array $options
     * @param string $separator
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    protected function request($action, $method = 'GET', $params = [], $options = [], $separator = '/'): ResponseInterface
    {
        $request = $this->requestFactory->createRequest($method, $this->endpoint.$separator.$action);
        $request = $request->withBody($this->streamFactory->createStream(json_encode($params)));

        return $this->httpClient->sendRequest($request);
    }
}
