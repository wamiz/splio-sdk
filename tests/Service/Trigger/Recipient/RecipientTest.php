<?php

namespace Splio\Tests\Service\Tigger\Recipient;

use PHPUnit\Framework\TestCase;
use Splio\Service\Trigger\Recipient\Recipient;

class RecipientTest extends TestCase
{
    public function testFormattedData()
    {
        $recipient = new Recipient();
        $recipient->setEmail('dev@dev.com');
        $recipient->setFirstname('Rick');
        $recipient->setLastname('Grim');
        $recipient->setCellphone('0505050505');
        $recipient->addCustomField('3', 'custom3');
        $recipient->addCustomField('5', 'custom5');

        $datas = $recipient->getFormattedData();

        $this->assertSame('dev@dev.com', $datas['email']);
        $this->assertSame('Rick', $datas['firstname']);
        $this->assertSame('Grim', $datas['lastname']);
        $this->assertSame('0505050505', $datas['cellphone']);
        $this->assertSame('custom3', $datas['c3']);
        $this->assertSame('custom5', $datas['c5']);

    }
}
