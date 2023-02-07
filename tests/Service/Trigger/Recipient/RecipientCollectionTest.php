<?php

namespace Splio\Tests\Service\Tigger\Recipient;

use PHPUnit\Framework\TestCase;
use Splio\Service\Trigger\Recipient\Recipient;
use Splio\Service\Trigger\Recipient\RecipientCollection;

class RecipientCollectionTest extends TestCase
{
    public function testJsonSerialize()
    {
        $recipient = new Recipient();
        $recipient->setEmail('dev@dev.com');
        $recipient->setFirstname('Rick');
        $recipient->setLastname('Grim');
        $recipient->setCellphone('0505050505');
        $recipient->addCustomField('3', 'custom3');
        $recipient->addCustomField('5', 'custom5');

        $collection = new RecipientCollection();
        $collection->append($recipient);

        $jsonExpected = '[{"firstname":"Rick","lastname":"Grim","cellphone":"0505050505","email":"dev@dev.com","c3":"custom3","c5":"custom5"}]';

        $this->assertSame($jsonExpected, $collection->jsonSerialize());

    }
}
