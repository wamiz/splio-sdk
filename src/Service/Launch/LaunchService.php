<?php
/**
 * Service used to manage campaigns into Splio.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Launch;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Splio\Service\AbstractService;

class LaunchService extends AbstractService
{
    protected $baseQuery;

    /**
     * Init base query to work with old API.
     *
     * @param array $config
     */
    public function __construct($config, ClientInterface $httpClient, ServerRequestFactoryInterface $serverRequestFactory)
    {
        parent::__construct($config, $httpClient, $serverRequestFactory);

        $this->baseQuery = [
            'universe' => $this->universe,
            'key' => $this->key,
        ];
    }

    /**
     * Set up new campaign from accessible URL.
     *
     * @param Message $message
     *
     * @return object
     */
    public function launchCampaign(Message $message)
    {
        $options = array_merge($this->baseQuery, $message->jsonSerialize());

        $res = $this->request('?'. http_build_query($options), 'GET', [], [], '');

        return json_decode($res->getBody()->getContents());
    }

    protected function getPath()
    {
        return '/api/launch/nph-13.pl';
    }

    protected function setEndpoint()
    {
        $this->endpoint = 'https://'.
                          $this->baseUrl.
                          $this->path;
    }
}
