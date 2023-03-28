<?php

/**
 * Main class handling Splio CRM.
 *
 * @author   Cédric Rassaert <crassaert@wamiz.com>
 */

namespace Splio;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Splio\Service\Service;

class SplioSdk
{
    protected array $config;
    protected ?Service $service = null;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    /**
     * Setting up Splio configuration.
     *
     * @param array $config {
     *
     * Array containing API keys to connect to Splio
     *
     *   @option string 'domain'    's3s.fr'
     *   @option string 'universe'  Universe provided by Splio
     *   @option array  'data'          => array(
     *                      'version'       =>  $version | API version (1.9)
     *                      'key'           =>  $apiKey Specify data API key
     *                      'sftp_host'     => $host
     *                      'sftp_port'     => $port
     *                      'sftp_username' => $username
     *                      'sftp_password' => $password
     *                      )
     *   @option array  'trigger'      => array(
     *                      'version'       =>  $version | API version (1.9)
     *                      'key'           =>  $apiKey Specify trigger API key
     *                      )
     *   @option array  'launch'      => array(
     *                      'version'       =>  $version | API version (1.9)
     *                      'key'           =>  $apiKey Specify launch API key
     *                      )
     * }
     */
    public function __construct(array $config = [], ?ClientInterface $httpClient = null, ?RequestFactoryInterface $requestFactory = null, ?StreamFactoryInterface $streamFactory = null)
    {
        $this->config = $config;
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
    }

    /**
     * Raw configuration.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get all services
     *
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service ??= new Service($this->config, $this->httpClient, $this->requestFactory, $this->streamFactory);
    }
}
