<?php

/**
 * Email List collection.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\EmailList;

use Splio\Serialize\SplioSerializeInterface;

class EmailListCollection extends \ArrayObject implements SplioSerializeInterface
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
            throw new \InvalidArgumentException('Must be EmailList class');
        }

        parent::offsetSet($index, $newval);
    }

    public function jsonSerialize(): array
    {
        return \array_map(
            function ($item) {
                return $item->jsonSerialize();
            }, $this->getArrayCopy()
        );
    }

    public function retrieveById(int $id): EmailList
    {
        foreach ($this as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        return false;
    }

    public static function jsonUnserialize(string $response): self
    {
        $data = \json_decode($response);

        $res = new self();

        foreach ($data->lists as $item) {
            $res->append(EmailList::jsonUnserialize(json_encode($item)));
        }

        return $res;
    }
}
