<?php
namespace Splio\Service\Launch;

use Splio\Service\AbstractService;

class LaunchService extends AbstractService
{
    protected function getPath()
    {
        return '/api/launch';
    }
}