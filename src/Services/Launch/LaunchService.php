<?php
namespace Splio\Services\Launch;

use Splio\Services\AbstractService;

class LaunchService extends AbstractService
{
    protected function getPath()
    {
        return '/api/launch';
    }
}