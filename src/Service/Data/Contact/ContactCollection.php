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

    public function retrieveById(int $id): Contact
    {
        foreach ($this as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        return false;
    }

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
}
