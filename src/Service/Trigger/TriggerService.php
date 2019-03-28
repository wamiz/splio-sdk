<?php

namespace Splio\Service\Trigger;

use Splio\Service\AbstractService;
use Splio\Service\Trigger\Recipient\RecipientCollection;

class TriggerService extends AbstractService
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
     * Send a trigger request to specified users
     *
     * @param integer $messageId SPRING Contact message id
     * @param RecipientCollection $recipients List of target recipients
     * 
     * @return array
     */
    public function send($messageId, RecipientCollection $recipients)
    {
        $options = \array_merge($this->baseQuery, $params);

        $res = $this->request('', 'POST', $options);

        return \json_decode($res->getBody()->getContents());
    }

    /**
     * Get trigger API path
     *
     * @return string
     */
    protected function getPath()
    {
        return '/api/trigger/nph-9.pl';
    }

    protected function setEndpoint()
    {
        $this->endpoint = 'https://'.
                          $this->baseUrl.'/'.
                          $this->path;
    }
}
