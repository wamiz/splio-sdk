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

    public static function jsonUnserialize(object $data): self
    {
        $res = new self();

        return $res;
    }
}
