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
                    $date->format('Ymd').
                    $separator.
                    \uniqid();

        return $filename;
    }

    public function import(ContactCollection $collection, $name = 'default')
    {
        $fileName = $this->buildFilename($name);
    }
}
