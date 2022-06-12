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
use Psr\Http\Message\ServerRequestFactoryInterface;
use Splio\Service\Service;

class SplioSdk
{
    protected $config;
    protected $services;

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
    public function __construct($config = [], ?ClientInterface $httpClient = null, ?ServerRequestFactoryInterface $serverRequestFactory = null)
    {
        $this->config = $config;
        $this->initServices(
            $httpClient ?: HttpClientDiscovery::find(),
            $serverRequestFactory ?: Psr17FactoryDiscovery::findServerRequestFactory()
        );
    }

    /**
     * Initialize services.
     */
    protected function initServices(ClientInterface $httpClient, ServerRequestFactoryInterface $requestFactoryInterface)
    {
        $service = new Service($this->config, $httpClient, $requestFactoryInterface);

        $this->service = $service;
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
        return $this->service;
    }
}
