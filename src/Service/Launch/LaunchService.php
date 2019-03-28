<?php
/**
 * Service used to manage campaigns into Splio.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Launch;

use Splio\Service\AbstractService;

class LaunchService extends AbstractService
{
    protected $baseQuery;

    /**
     * Init base query to work with old API.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        parent::__construct($config);

        $this->baseQuery = [
            'universe' => $this->universe,
            'key' => $this->key,
        ];
    }

    /**
     * Set up new campaign from accessible URL.
     *
     * @param array $params {
     * @option string $senderemail required
     * @option string $sendername required
     * @option string $url required
     * @option string $list eg: 1,2
     * @option string $replyto
     * @option $starttime "yyyy-mm-dd HH:MM:SS"
     *                      }
     */
    public function launchCampaign($params)
    {
        $options = \array_merge($this->baseQuery, $params);

        $res = $this->request(\http_build_query($options), 'GET');

        return \json_decode($res->getBody()->getContents());
    }

    protected function getPath()
    {
        return '/api/launch/nph-13.pl?';
    }

    protected function setEndpoint()
    {
        $this->endpoint = 'https://'.
                          $this->baseUrl.'/'.
                          $this->path;
    }
}
