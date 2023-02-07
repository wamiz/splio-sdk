<?php 
namespace Splio\Service\Trigger\Recipient;

use \ArrayObject, \InvalidArgumentException;

class RecipientCollection extends ArrayObject
{
    public function offsetSet($index, $newval): void
    {
        if (!($newval instanceof Recipient)) {
            throw new InvalidArgumentException("Must be Recipient class");
        }

        parent::offsetSet($index, $newval);
    }

    public function jsonSerialize(): string
    {
        $datas = [];
        /** @var Recipient $recipient */
        foreach ($this->getIterator() as $recipient)
        {
            $datas[] = $recipient->getFormattedData();
        }

        return \json_encode($datas, JSON_THROW_ON_ERROR);
    }
}
