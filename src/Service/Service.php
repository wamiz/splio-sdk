<?php
/**
 * Handle all splio services.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service;

use Http\Discovery\HttpClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Splio\Service\Data\DataService;
use Splio\Service\Launch\LaunchService;
use Splio\Service\Trigger\TriggerService;

class Service
{
    protected $data;
    protected $trigger;
    protected $launch;
    protected $config;
    /** @var ClientInterface  */
    private $httpClient;
    /** @var ServerRequestFactoryInterface  */
    private $serverRequestFactory;

    public function __construct($config, ClientInterface $httpClient, ServerRequestFactoryInterface $serverRequestFactory)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
        $this->serverRequestFactory = $serverRequestFactory;

        $this->initDataService($config['data'], $config['domain'], $config['universe']);
        $this->initTriggerService($config['trigger'], $config['domain'], $config['universe']);
        $this->initLaunchService($config['launch'], $config['domain'], $config['universe']);
    }

    /**
     * Return data service.
     *
     * @return \Splio\Service\Data\DataService
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return trigger service.
     *
     * @return \Splio\Service\Trigger\TriggerService
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Return launch service.
     *
     * @return \Splio\Service\Launch\LaunchService
     */
    public function getLaunch()
    {
        return $this->launch;
    }

    /**
     * Assign domain and universe to config
     *
     * @param array $config
     * @param string $domain
     * @param string $universe
     * @return array
     */
    private function enhanceConfig(&$config, $domain, $universe)
    {
        $config['domain'] = $domain;
        $config['universe'] = $universe;
    }

    /**
     * Initialize data service.
     *
     * @param array  $config
     * @param string $domain
     */
    private function initDataService($config, $domain, $universe)
    {
        $this->enhanceConfig($config, $domain, $universe);

        $dataService = new DataService($config, $this->httpClient, $this->serverRequestFactory);

        $this->data = $dataService;
    }

    /**
     * Initialize trigger service.
     *
     * @param array  $config
     * @param string $domain
     */
    private function initTriggerService($config, $domain, $universe)
    {
        $this->enhanceConfig($config, $domain, $universe);

        $triggerService = new TriggerService($config, $this->httpClient, $this->serverRequestFactory);

        $this->trigger = $triggerService;
    }

    /**
     * Initialize launch service.
     *
     * @param array  $config
     * @param string $domain
     */
    private function initLaunchService($config, $domain, $universe)
    {
        $this->enhanceConfig($config, $domain, $universe);

        $launchService = new LaunchService($config, $this->httpClient, $this->serverRequestFactory);

        $this->launch = $launchService;
    }
}
