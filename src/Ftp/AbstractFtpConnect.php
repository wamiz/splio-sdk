<?php

namespace Splio\Ftp;

abstract class AbstractFtpConnect
{
    protected $universe;
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $ftpStream;

    /**
     * Defines base options.
     *
     * @param string $universe
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    public function __construct($universe, $host = '', $port = 22, $username = '', $password = '')
    {
        $this->universe = $universe;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    protected function connect()
    {
        $ftpHandle = ftp_ssl_connect($this->host, $this->port, 5);
        ftp_login($ftpHandle, $this->username, $this->password);
        ftp_pasv($ftpHandle, true);

        $this->ftpStream = $ftpHandle;
    }

    protected function close()
    {
        ftp_close($this->ftpStream);
    }
}