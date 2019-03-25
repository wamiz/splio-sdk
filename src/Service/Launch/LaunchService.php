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
    /**
     * Set up new campaign from accessible URL.
     *
     * @param array $params {
     *     @option string $senderemail required
     *     @option string $sendername required
     *     @option string $url required
     *     @option $starttime "yyyy-mm-dd HH:MM:SS"
     * }
     */
    public function launchCampaign($params)
    {
        $baseOptions = [
            'universe' => $this->universe,
            'key' => $this->key,
        ];

        $options = \array_merge($baseOptions, $params);

        $res = $this->request(\http_build_query($options), 'GET');

        return \json_decode($res->getBody()->getContents());
    }

    protected function getPath()
    {
        return '/api/launch/nph-13.pl';
    }

    protected function setEndpoint()
    {
        $query = [
            'universe' => $this->universe,
            'key' => $this->key,
        ];

        $this->endpoint = 'https://'.
                          $this->baseUrl.'/'.
                          $this->path;
    }
}
