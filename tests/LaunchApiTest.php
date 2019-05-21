<?php
/**
 * Tests for data API.
 *
 * @author   Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use \DateTime;
use Splio\Service\Launch\Message as SplioMessage;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Launch API class tester.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */
final class LaunchApiTest extends TestCase
{
    use SplioConfig;

    protected $sdk;

    protected function setUp(): void
    {
        $this->sdk = new SplioSdk($this->buildConfig());
    }

    public function testLaunch()
    {
        $lists = $this->sdk->getService()->getData()->getLists();
        $selectedList = false;

        foreach ($lists as $list) {
            if (preg_match('/dev/Uis', $list->getName())) {
                $selectedList = $list;
            }
        }

        // No dev list
        if (false === $selectedList) {
            return false;
        }

        $sendDate = new DateTime;

        $message = new SplioMessage();
        $message->setSenderName('Foo');
        $message->setSenderEmail($_ENV['TEST_SENDER_EMAIL']);
        $message->setReplyTo($_ENV['TEST_SENDER_EMAIL']);
        $message->addList($selectedList);
        $message->setStartTime($sendDate->format('Y-m-d H:i:s'));
        $message->setUrl($_ENV['TEST_SENDER_URL']);

        $res = $this->sdk->getService()->getLaunch()->launchCampaign($message);

        $this->assertTrue($res);
    }
}
