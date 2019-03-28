<?php 
namespace Splio\Service\Trigger\Recipient;

use Splio\Service\Trigger\Recipient\Recipient;

class RecipientCollection extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if (!($newval instanceof Recipient)) {
            throw new \InvalidArgumentException("Must be Recipient class");
        }

        parent::offsetSet($index, $newval);
    }
}