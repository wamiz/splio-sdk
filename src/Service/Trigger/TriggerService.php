<?php
namespace Splio\Service\Trigger;

use Splio\Service\AbstractService;

class TriggerService extends AbstractService
{
    protected function getPath()
    {
        return '/api/trigger';
    }
}