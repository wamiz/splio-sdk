<?php

/**
 * Main class handling Splio CRM.
 *
 * @author   Cédric Rassaert <crassaert@wamiz.com>
 */

namespace Splio;

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
     *   @option array  'data'   => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify data API key
     *                      )
     *   @option array  'trigger'     => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify trigger API key
     *                      )
     *   @option array  'launch'      => array(
     *                      'version' =>  $version | API version (1.9)
     *                      'key'     =>  $apiKey Specify launch API key
     *                      )
     * }
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
        $service = new Service($this->config);

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
     * Get all services.
     *
     * @return Splio\Service\Service
     */
    public function getService(): Service
    {
        return $this->service;
    }
}
