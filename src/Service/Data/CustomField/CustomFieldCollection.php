<?php

/**
 * Custom fields collection.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\CustomField;

use Splio\Serialize\SplioSerializeInterface;
use \ArrayObject, \InvalidArgumentException;

class CustomFieldCollection extends ArrayObject implements SplioSerializeInterface
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
            throw new InvalidArgumentException('Must be CustomField class');
        }

        parent::offsetSet($index, $newval);
    }

    public function retrieveById(int $id): CustomField
    {
        foreach ($this as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }

        // if not found, return new field
        $customField = new CustomField();
        $customField->setId($id);

        return $customField;
    }

    public function jsonSerialize(): array
    {
        $res = array_map(
            function ($item) {
                return $item->jsonSerialize();
            }, $this->getArrayCopy()
        );

        return $res;
    }

    public static function jsonUnserialize(string $response)
    {
        $data = json_decode($response);

        $res = new self();

        foreach ($data->fields as $item) {
            $res->append(CustomField::jsonUnserialize(json_encode($item)));
        }

        return $res;
    }
}
