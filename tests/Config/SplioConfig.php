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
            'universe' => $_ENV['SPLIO_UNIVERSE'],
            'data' => [
                'key' => $_ENV['SPLIO_DATA_KEY'],
                'version' => $_ENV['SPLIO_DATA_VERSION'],
                'sftp_host' => $_ENV['SPLIO_DATA_SFTP_HOST'],
                'sftp_port' => $_ENV['SPLIO_DATA_SFTP_PORT'],
                'sftp_username' => $_ENV['SPLIO_DATA_SFTP_USERNAME'],
                'sftp_password' => $_ENV['SPLIO_DATA_SFTP_PASSWORD'],
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
