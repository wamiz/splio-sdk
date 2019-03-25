<?php
/**
 * Handle all splio services.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Services;

use Splio\Services\Data\DataService;
use Splio\Services\Launch\LaunchService;
use Splio\Services\Trigger\TriggerService;

class Services
{
    protected $data;
    protected $trigger;
    protected $launch;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->_initDataService($config['data'], $config['domain'], $config['universe']);
        $this->_initTriggerService($config['trigger'], $config['domain'], $config['universe']);
        $this->_initLaunchService($config['launch'], $config['domain'], $config['universe']);
    }

    /**
     * Return data service.
     *
     * @return Splio\Services\DataService
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return trigger service.
     *
     * @return Splio\Services\TriggerService
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Return launch service.
     *
     * @return Splio\Services\LaunchService
     */
    public function getLaunch()
    {
        return $this->launch;
    }

    /**
     * Initialize data service.
     *
     * @param array  $config
     * @param string $domain
     */
    protected function _initDataService($config, $domain, $universe)
    {
        $config['domain'] = $domain;
        $config['universe'] = $universe;

        $dataService = new DataService($config);

        $this->data = $dataService;
    }

    /**
     * Initialize trigger service.
     *
     * @param array  $config
     * @param string $domain
     */
    protected function _initTriggerService($config, $domain, $universe)
    {
        $config['domain'] = $domain;
        $config['universe'] = $universe;

        $triggerService = new TriggerService($config);

        $this->trigger = $triggerService;
    }

    /**
     * Initialize launch service.
     *
     * @param array  $config
     * @param string $domain
     */
    protected function _initLaunchService($config, $domain, $universe)
    {
        $config['domain'] = $domain;
        $config['universe'] = $universe;

        $launchService = new LaunchService($config);

        $this->launch = $launchService;
    }
}
