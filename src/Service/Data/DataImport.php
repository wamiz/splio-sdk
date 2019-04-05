<?php
/**
 * Data import via CSV file.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data;

use Splio\Service\Data\Contact\ContactCollection;

class DataImport
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
     * @param string $host
     * @param int    $port
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

    protected function buildFilename($name = 'default')
    {
        $separator = '_';
        $date = new \DateTime();
        $filename = $this->universe.
                    $separator.
                    'contacts'.
                    $separator.
                    $name.
                    $separator.
                    $date->format('Ymd').
                    $separator.
                    \uniqid().
                    '.csv';

        return $filename;
    }

    protected function connect()
    {
        $ftpHandle = \ftp_ssl_connect($this->host, $this->port, 5);
        \ftp_login($ftpHandle, $this->username, $this->password);
        \ftp_pasv($ftpHandle, true);

        $this->ftpStream = $ftpHandle;
    }

    protected function close()
    {
        \ftp_close($this->ftpStream);
    }

    public function import($csvText, $name = 'default')
    {
        $this->connect();

        $fileName = $this->buildFilename($name);

        $stream = \fopen('php://memory', 'r+');

        \fwrite($stream, $csvText);
        \rewind($stream);

        $result = \ftp_fput($this->ftpStream, '/imports/' . $fileName, $stream, FTP_ASCII);

        \fclose($stream);

        $this->close();

        return $result;
    }
}
