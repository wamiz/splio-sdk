<?php
/**
 * Handle all splio services.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service;

use Splio\Service\Data\DataService;
use Splio\Service\Launch\LaunchService;
use Splio\Service\Trigger\TriggerService;

class Service
{
    protected $data;
    protected $trigger;
    protected $launch;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->initDataService($config['data'], $config['domain'], $config['universe']);
        $this->initTriggerService($config['trigger'], $config['domain'], $config['universe']);
        $this->initLaunchService($config['launch'], $config['domain'], $config['universe']);
    }

    /**
     * Return data service.
     *
     * @return Splio\Service\DataService
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return trigger service.
     *
     * @return Splio\Service\TriggerService
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Return launch service.
     *
     * @return Splio\Service\LaunchService
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

        $dataService = new DataService($config);

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

        $triggerService = new TriggerService($config);

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

        $launchService = new LaunchService($config);

        $this->launch = $launchService;
    }
}
