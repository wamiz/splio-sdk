<?php

/**
 * Custom fields collection.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\CustomField;

use Splio\Serialize\SplioSerializeInterface;

class CustomFieldCollection extends \ArrayObject implements SplioSerializeInterface
{
    /**
     * Check if object is intance of CustomField.
     *
     * @param mixed   $index
     * @param [mixed] $newval
     */
    public function offsetSet($index, $newval)
    {
        if (!($newval instanceof CustomField)) {
            throw new \InvalidArgumentException('Must be CustomField class');
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
