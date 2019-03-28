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
            $res->append(CustomField::jsonUnserialize(json_encode($item)));
        }

        return $res;
    }
}
