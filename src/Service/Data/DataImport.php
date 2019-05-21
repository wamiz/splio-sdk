<?php
/**
 * Data import via CSV file.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data;

use Splio\Ftp\AbstractFtpConnect;
use \DateTime;

class DataImport extends AbstractFtpConnect
{

    protected function buildFilename($name = 'default')
    {
        $separator = '_';
        $date = new DateTime();
        $filename =
            $this->universe .
            $separator .
            'contacts' .
            $separator .
            $name .
            $separator .
            $date->format('Ymd') .
            $separator .
            uniqid() .
            '.csv';

        return $filename;
    }

    public function import($csvText, $name = 'default')
    {
        $this->connect();

        $fileName = $this->buildFilename($name);

        $stream = fopen('php://memory', 'r+');

        fwrite($stream, $csvText);
        rewind($stream);

        $result = ftp_fput($this->ftpStream, '/imports/' . $fileName, $stream, FTP_ASCII);

        fclose($stream);

        $this->close();

        return $result;
    }
}
