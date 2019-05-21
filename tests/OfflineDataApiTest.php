<?php
/**
 * Main class test.
 *
 * @author   Cédric Rassaert <crassaert@wamiz.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use \DateTime;
use Splio\Service\Data\Contact\Contact;
use Splio\Service\Data\Contact\ContactCollection;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Main class tester.
 */
final class OfflineDataApiTest extends TestCase
{
    use SplioConfig;

    protected $sdk;
    protected $userCollection;

    protected function setUp(): void
    {
        $this->sdk = new SplioSdk($this->buildConfig());
    }

    protected function getRandomCustomField()
    {
        $fields = $this->sdk->getService()->getData()->getFields();

        $rdm = rand(0, $fields->count() - 1);

        $elem = $fields->offsetGet($rdm);
        $elem->setValue(rand(0, 1));

        return $elem;
    }

    protected function fillUsers(): void
    {
        $collection = new ContactCollection();

        for ($i = 1; $i <= 10; ++$i) {
            $contact = new Contact();
            $email = 'splio'.$i.'@mailinator.com';

            $contact->setEmail($email);
            $contact->setFirstname('Foo'.$i);
            $contact->setLastname('Bar'.$i);
            $contact->setLang('fr');
            $contact->setDate(new DateTime());

            foreach ($this->sdk->getService()->getData()->getFields() as $field)
            {
                $field->setValue(rand(0, 1));
                $contact->addCustomField($field);
            }

            foreach ($this->sdk->getService()->getData()->getLists() as $list)
            {
                if ($list->getId() == 1)
                {
                    $contact->addEmailList($list);
                }
            }

            $collection->append($contact);
        }

        $this->userCollection = $collection;
    }

    /**
     * Init a new Splio Object and test for it.
     */
    public function testBulkImport()
    {
        $this->fillUsers();
        $this->sdk->getService()->getData()->importContacts($this->userCollection, 'test');
    }
}
