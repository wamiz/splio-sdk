<?php
/**
 * Tests for data API.
 *
 * @author   Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
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

        $this->fakeUser = [
            'email' => 'fake@wamiz.com',
            'firstname' => 'Fake fn',
            'lastname' => 'Fake ln',
            'lists' => ['id' => 0]
        ];
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
     * Get created contact
     */
    public function testContactInfos()
    {
        $contact = $this->sdk->getService()->getData()->getContact($this->fakeUser['email']);

        $this->assertIsObject($contact);
    }

    /**
     * Update single contact
     *
     * @return void
     */
    public function testContactUpdate()
    {
        $contact = $this->sdk->getService()->getData()->updateContact($this->fakeUser);

        $this->assertIsObject($contact);
    }

    public function testContactDelete()
    {
        $result = $this->sdk->getService()->getData()->deleteContact($this->fakeUser['email']);
        $this->assertTrue($result);
    }
}
