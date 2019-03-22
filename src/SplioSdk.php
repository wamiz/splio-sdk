<?php 

namespace Splio;

class SplioSdk
{
    protected $config;

    /**
     * Setting up Splio configuration
     * 
     * @param array $config Array containing API keys to connect to Splio
     *    $params = array(
     *      'data'   => array(
     *          'key'   =>  $apiKey Specify data API key 
     *      )
     *      'trigger'   => array(
     *          'key'   =>  $apiKey Specify trigger API key 
     *      )
     *      'launch'   => array(
     *          'key'   =>  $apiKey Specify launch API key 
     *      )
     *    )
     */
    public function __construct($config = array())
    {

    }
}
