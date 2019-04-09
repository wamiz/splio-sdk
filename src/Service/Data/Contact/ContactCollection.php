<?php

/**
 * Contacts collection.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\Contact;

use Splio\Serialize\SplioSerializeInterface;

class ContactCollection extends \ArrayObject implements SplioSerializeInterface
{
    const CSV_DELIMITER = ';';

    protected $csvData;
    protected $csvHeaders;

    /**
     * Check if object is intance of Contact.
     *
     * @param mixed   $index
     * @param [mixed] $newval
     */
    public function offsetSet($index, $newval)
    {
        if (!($newval instanceof Contact)) {
            throw new \InvalidArgumentException('Must be Contact class');
        }

        parent::offsetSet($index, $newval);
    }

    /**
     * Retrieve contact with a given id.
     *
     * @param int $id
     *
     * @return Contact
     */
    public function retrieveById(int $id): Contact
    {
        foreach ($this as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        return false;
    }

    /**
     * Serialize collection to JSON.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $res = \array_map(
            function ($item) {
                return $item->jsonSerialize();
            }, $this->getArrayCopy()
        );

        return $res;
    }

    public static function jsonUnserialize(string $response): self
    {
        $data = \json_decode($response);

        $res = new self();

        foreach ($data->fields as $item) {
            $res->append(Contact::jsonUnserialize(json_encode($item)));
        }

        return $res;
    }

    protected function retrieveCsvHeaders()
    {
        if (!$this->csvHeaders) {
            $headers = [];

            foreach ($this->csvData as $data) {
                foreach ($data as $key => $value) {
                    if (!\in_array($key, $headers)) {
                        $headers[] = $key;
                    }
                }
            }

            $this->csvHeaders = $headers;
        }

        return $this->csvHeaders;
    }

    /**
     * Serialize current contacts to CSV to use in data hub offline API.
     *
     * @return string $csv
     */
    protected function formatForCsv()
    {
        $csv = '';

        $lines = [];

        foreach ($this as $contact) {
            $line = [
                'email' => $contact->getEmail(),
                'firstname' => $contact->getFirstname(),
                'lastname' => $contact->getLastname(),
                'cellphone' => $contact->getCellphone(),
                'language' => $contact->getLang(),
            ];

            if ($contact->getDate() instanceof \DateTime)
            {
                $line['dateOfCreation'] = $contact->getDate()->format('Ymd');
            }

            // adding subscriptions
            $subscriptions = [];

            foreach ($contact->getEmailList() as $list) {
                $subscriptions[] = '+'.$list->getId();
            }

            $line['subscriptions'] = \implode(self::CSV_DELIMITER, $subscriptions);

            // adding custom fields
            foreach ($contact->getCustomFields() as $field) {
                $idx = 'c'.$field->getId();
                $line[$idx] = $field->getValue();
            }

            \array_push($lines, $line);

            $this->csvData = $lines;
        }
    }

    /**
     * Format user collection to CSV
     *
     * @return string
     */
    public function csvSerialize()
    {
        $this->formatForCsv();
        $headers = $this->retrieveCsvHeaders();

        // Setting headers as first line
        $data = [\implode(self::CSV_DELIMITER, $headers)];

        foreach ($this->csvData as $line) {
            $attributes = [];

            foreach ($headers as $headerItem) {
                if (\array_key_exists($headerItem, $line) && $line[$headerItem] !== '') {
                    $attributes[] = '"' . $line[$headerItem] . '"';
                } else {
                    $attributes[] = '';
                }
            }

            $data[] = \implode(self::CSV_DELIMITER, $attributes);
        }

        return \implode("\n", $data);
    }
}
