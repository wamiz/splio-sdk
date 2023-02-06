<?php 
namespace Splio\Service\Trigger\Recipient;

use \ArrayObject, \InvalidArgumentException;

class RecipientCollection extends ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if (!($newval instanceof Recipient)) {
            throw new InvalidArgumentException("Must be Recipient class");
        }

        parent::offsetSet($index, $newval);
    }

    public function jsonSerializer()
    {
        $datas = [];
        /** @var Recipient $recipient */
        foreach ($this->getArrayCopy() as $recipient)
        {
            $datas[] = $recipient->getFormattedData();
        }

        return \json_encode($datas);
    }
}
