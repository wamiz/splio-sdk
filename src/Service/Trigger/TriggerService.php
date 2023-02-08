<?php

namespace Splio\Service\Trigger;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Splio\Exception\SplioSdkException;
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
     * @param string $messageId SPRING Contact message id
     * @param RecipientCollection $recipients List of target recipients
     * @return array<string, mixed>
     * @throws SplioSdkException if status code != 200
     */
    public function send(string $messageId, RecipientCollection $recipients): array
    {
        $params['message'] = $messageId;
        $params['rcpts'] = $recipients->jsonSerialize();
        $options = array_merge($this->baseQuery, $params);

        $res = $this->request('', 'POST', $options);

        if(200 !== $res->getStatusCode()){
            throw new SplioSdkException("Error while send Trigger, status code {$res->getStatusCode()} with message : {$res->getReasonPhrase()}");
        }

        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * Get trigger API path
     *
     * @return string
     */
    protected function getPath(): string
    {
        return 'api/trigger/nph-9.pl';
    }

    protected function setEndpoint(): void
    {
        $this->endpoint = 'https://'.
                          $this->baseUrl.'/'.
                          $this->path;
    }
}
