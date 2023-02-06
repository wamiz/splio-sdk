<?php

namespace Splio\Service\Trigger;

use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
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
    public function __construct($config, ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        parent::__construct($config, $httpClient, $requestFactory, $streamFactory);

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
        $params['message'] = $messageId;
        $params['rcpts'] = $recipients->jsonSerializer();
        $options = array_merge($this->baseQuery, $params);

        $res = $this->request('', 'POST', $options);

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Get trigger API path
     *
     * @return string
     */
    protected function getPath()
    {
        return 'api/trigger/nph-9.pl';
    }

    protected function setEndpoint()
    {
        $this->endpoint = 'https://'.
                          $this->baseUrl.'/'.
                          $this->path;
    }
}
