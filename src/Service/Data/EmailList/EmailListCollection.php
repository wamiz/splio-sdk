<?php

/**
 * Email List collection.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\EmailList;

use Splio\Serialize\SplioSerializeInterface;
use \ArrayObject, \InvalidArgumentException;

class EmailListCollection extends ArrayObject implements SplioSerializeInterface
{
    /**
     * Check if value is EmailList instance.
     *
     * @param mixed $index
     * @param mixed $newval
     */
    public function offsetSet($index, $newval)
    {
        if (!($newval instanceof EmailList)) {
            throw new InvalidArgumentException('Must be EmailList class');
        }

        parent::offsetSet($index, $newval);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_map(
            function ($item) {
                return $item->jsonSerialize();
            }, $this->getArrayCopy()
        );
    }

    /**
     * @param int $id
     * @return EmailList|boolean
     */
    public function retrieveById(int $id)
    {
        foreach ($this as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        return false;
    }

    /**
     * @param string $response
     * @return EmailListCollection
     */
    public static function jsonUnserialize(string $response)
    {
        $data = json_decode($response);

        $res = new self();

        foreach ($data->lists as $item) {
            $res->append(EmailList::jsonUnserialize(json_encode($item)));
        }

        return $res;
    }
}
