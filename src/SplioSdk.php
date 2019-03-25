<?php

/**
 * Main class handling Splio CRM.
 *
 * @author   Cédric Rassaert <crassaert@wamiz.com>
 */

namespace Splio;

use Splio\Services\Services;

class SplioSdk
{
    protected $config;
    protected $services;

    /**
     * Setting up Splio configuration.
     *
     * @param array $config Array containing API keys to connect to Splio
     *                      $params = array(
     *                      'domain'    => 'https://s3s.fr'
     *                      'universe'  => $universe (provided by Splio)
     *                      'data'   => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify data API key
     *                      )
     *                      'trigger'     => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify trigger API key
     *                      )
     *                      'launch'      => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify launch API key
     *                      )
     *                      )
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->_initServices();
    }

    /**
     * Initialize services.
     */
    protected function _initServices()
    {
        $services = new Services($this->config);

        $this->services = $services;
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
     * Get all services.
     *
     * @return Splio\Services\Services
     */
    public function getServices(): Services
    {
        return $this->services;
    }
}
