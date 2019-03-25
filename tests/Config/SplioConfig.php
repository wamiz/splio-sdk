<?php

namespace Splio\Tests\Config;

trait SplioConfig
{
    /**
     * Build config from env.
     *
     * @return array
     */
    public function buildConfig()
    {
        return [
            'domain' => $_ENV['SPLIO_DOMAIN'],
            'data' => [
                'key' => $_ENV['SPLIO_DATA_KEY'],
                'version' => $_ENV['SPLIO_DATA_VERSION'],
            ],
            'trigger' => [
                'key' => $_ENV['SPLIO_TRIGGER_KEY'],
                'version' => $_ENV['SPLIO_TRIGGER_VERSION'],
            ],
            'launch' => [
                'key' => $_ENV['SPLIO_LAUNCH_KEY'],
                'version' => $_ENV['SPLIO_LAUNCH_VERSION'],
            ],
        ];
    }
}
