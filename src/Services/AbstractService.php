<?php
/**
 * Define base services.
 */

namespace Splio\Services;

abstract class AbstractService
{
    protected $baseUrl;
    protected $version;
    protected $path;
    protected $key;
    protected $endpoint;

    abstract protected function getPath();

    public function __construct($config)
    {
        $this->baseUrl = $config['domain'];
        $this->version = $config['version'];
        $this->key = $config['key'];
        $this->path = $this->getPath();

        $this->_setEndpoint();
    }

    protected function _setEndpoint()
    {
        $this->endpoint = $this->baseUrl.
                          ':'.
                          $this->key.
                          $this->path.
                          ($this->version ? $this->version.'/' : '')
                        ;
    }
}
