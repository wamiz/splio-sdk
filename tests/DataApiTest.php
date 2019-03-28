<?php
/**
 * Tests for data API.
 *
 * @author   Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use Splio\Service\Data\Contact\Contact;
use Splio\Service\Data\CustomField\CustomField;
use Splio\Service\Data\EmailList\EmailList;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Data API class tester.
 */
final class DataApiTest extends TestCase
{
    use SplioConfig;

    protected $sdk;
    protected $fakeUser;

    protected function setUp(): void
    {
        $this->sdk = new SplioSdk($this->buildConfig());
        $this->initFakeUser();
    }

    public function testContactJsonSerialize()
    {
        $serializedContact = $this->fakeUser->jsonSerialize();

        $this->assertIsArray($serializedContact);
    }

    /**
     * Fetch all lists into current universe.
     */
    public function testLists()
    {
        $lists = $this->sdk->getService()->getData()->getLists();

        $this->assertIsObject($lists);
    }

    /**
     * Create contact in splio.
     */
    public function testContactCreation()
    {
        $contact = $this->sdk->getService()->getData()->createContact($this->fakeUser);

        $this->assertIsObject($contact);
    }

    /**
     * Get created contact.
     */
    public function testContactInfos()
    {
        $contact = $this->sdk->getService()->getData()->getContact($this->fakeUser->getEmail());

        $this->assertIsObject($contact);
    }

    /**
     * Update single contact.
     */
    public function testContactUpdate()
    {
        $contact = $this->sdk->getService()->getData()->updateContact($this->fakeUser);

        $this->assertIsObject($contact);
    }

    public function testContactBlacklist()
    {
        $this->sdk->getService()->getData()->addContactToBlacklist($this->fakeUser->getEmail());
        $isBlacklisted = $this->sdk->getService()->getData()->isContactBlacklisted($this->fakeUser->getEmail());
        $this->assertTrue($isBlacklisted);
    }

    /**
     * Delete contact.
     */
    public function testContactDelete()
    {
        $result = $this->sdk->getService()->getData()->deleteContact($this->fakeUser->getEmail());
        $this->assertTrue($result);
    }

    /**
     * Returns random list in the universe.
     *
     * @return EmailList
     */
    private function getRandomList(): EmailList
    {
        $lists = $this->sdk->getService()->getData()->getLists();

        $count = $lists->count();
        $rand = rand(0, ($count - 1));
        $return = false;

        foreach ($lists as $key => $list) {
            if ($key === $rand) {
                $return = $list;
            }
        }

        return $return;
    }

    private function initFakeUser()
    {
        $fakeUser = new Contact();
        $fakeUser->setEmail('fake@wamiz.com');
        $fakeUser->setFirstname('Fake fn');
        $fakeUser->setLastname('Fake ln');

        $customField = new CustomField();
        $customField->setId(0);
        $customField->setValue(42);
        $fakeUser->addCustomField($customField);
        $fakeUser->addEmailList($this->getRandomList());

        $this->fakeUser = $fakeUser;
    }
}
