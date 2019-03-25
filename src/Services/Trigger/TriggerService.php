<?php
namespace Splio\Services\Trigger;

use Splio\Services\AbstractService;

class TriggerService extends AbstractService
{
    protected function getPath()
    {
        return '/api/trigger';
    }
}