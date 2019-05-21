<?php

namespace Splio\Service\Data\Report;

use Splio\Exception\SplioSdkException;
use Splio\Ftp\AbstractFtpConnect;
use \DateTime, \Exception;
use Splio\Service\Data\EmailList\EmailListCollection;

class DataReport extends AbstractFtpConnect
{
    const FTP_PATH = 'reports';
    const FTP_SEPARATOR = '/';
    const FILE_FORMAT = 'report_client_%s.csv';

    /**
     * Returning report of choosen date
     *
     * @param DateTime $date
     * @param EmailListCollection $lists
     * @return ContactReportCollection
     * @throws SplioSdkException
     */
    public function getReport(DateTime $date, EmailListCollection $lists)
    {
        $this->connect();

        $filePath =
            self::FTP_SEPARATOR .
            self::FTP_PATH .
            self::FTP_SEPARATOR .
            sprintf(self::FILE_FORMAT, $date->format('Y-m-d'));

        $stream = fopen('php://temp', 'r+');

        try {
            ftp_fget($this->ftpStream, $stream, $filePath, FTP_ASCII);
        } catch (Exception $e) {
            throw new SplioSdkException('Can\'t get report');
        }

        rewind($stream);

        $collection = new ContactReportCollection();
        $i = 0;

        while (FALSE !== ($line = fgetcsv($stream, 4096, ";"))) {
            if ($i > 0) {
                $item = $this->csvToContactReport($line, $lists);

                $collection->append($item);
            }

            $i++;
        }

        fclose($stream);

        return $collection;

    }

    /**
     * Convert CSV line to ContactReport object
     *
     * @param array $csv
     * @param EmailListCollection $lists
     * @return ContactReport
     */
    private function csvToContactReport(array $csv, EmailListCollection $lists)
    {
        $contactReport = new ContactReport();

        $elements = ['CampaignName', 'CampaignId', 'Email', 'SendId', 'Status', 'Link', 'Date', 'Lists'];

        foreach ($elements as $key => $element) {
            $method = 'set' . $element;

            if ('Lists' === $element) {
                $contactReport->$method($this->formatLists($csv[$key], $lists));
            } else if ('Date' === $element) {
                $date = DateTime::createFromFormat('Y-m-d', $csv[$key]);
                $contactReport->$method($date);
            } else {
                $contactReport->$method($csv[$key]);
            }
        }

        return $contactReport;
    }

    /**
     * @param string $contactLists
     * @param EmailListCollection $lists
     * @return EmailListCollection
     */
    private function formatLists(string $contactLists, EmailListCollection $lists)
    {
        $elements = explode(',', $contactLists);

        $collection = new EmailListCollection();

        foreach ($elements as $list) {
            $listObj = $lists->retrieveById($list);
            $collection->append($listObj);
        }

        return $collection;
    }
}