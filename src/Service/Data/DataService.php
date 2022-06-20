<?php
/**
 * Service to manage contacts from Splio Data API.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Splio\Exception\SplioSdkException;
use Splio\Service\AbstractService;
use Splio\Service\Data\Contact\Contact;
use Splio\Service\Data\Contact\ContactCollection;
use Splio\Service\Data\CustomField\CustomFieldCollection;
use Splio\Service\Data\EmailList\EmailListCollection;
use Splio\Service\Data\Report\DataReport;
use \Exception, \DateTime;

class DataService extends AbstractService
{
    const API_LIST_ENDPOINT = 'lists';
    const API_FIELD_ENDPOINT = 'fields';
    const API_CONTACT_ENDPOINT = 'contact';
    const API_BLACKLIST_ENDPOINT = 'blacklist';

    protected $dataImport;
    protected $dataReport;
    protected $fields;

    public function __construct($config, ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        parent::__construct($config, $httpClient, $requestFactory, $streamFactory);

        $this->dataImport = new DataImport(
            $this->universe,
            $config['sftp_host'],
            $config['sftp_port'],
            $config['sftp_username'],
            $config['sftp_password']
        );

        $this->dataReport = new DataReport(
            $this->universe,
            $config['sftp_host'],
            $config['sftp_port'],
            $config['sftp_username'],
            $config['sftp_password']
        );
    }

    /**
     * Get Data API path
     *
     * @return string
     */
    protected function getPath()
    {
        return 'api/data';
    }

    /**
     * Set endpoint for data API.
     */
    protected function setEndpoint(): void
    {
        $this->endpoint = 'https://' .
            $this->universe . ':' .
            $this->key . '@' .
            $this->baseUrl . '/' .
            $this->path . '/' .
            ($this->version ? $this->version : '');
    }

    /**
     * Get all lists created into universe.
     * @return EmailListCollection
     * @throws SplioSdkException if status code != 200
     *
     */
    public function getLists(): EmailListCollection
    {
        $res = $this->request(self::API_LIST_ENDPOINT, 'GET');

        if (200 !== $res->getStatusCode()) {
            throw new SplioSdkException('Error while fetching lists : ' .
                $res->getReasonPhrase(), $res->getStatusCode());
        }

        return EmailListCollection::jsonUnserialize($res->getBody()->getContents());
    }

    public function getFields(): CustomFieldCollection
    {
        if (!$this->fields) {
            $res = $this->request(self::API_FIELD_ENDPOINT, 'GET');

            if (200 !== $res->getStatusCode()) {
                throw new SplioSdkException('Error while fetching fields : ' .
                    $res->getReasonPhrase(), $res->getStatusCode());
            }
            $this->fields = $res->getBody()->getContents();
        }

        return CustomFieldCollection::jsonUnserialize($this->fields);
    }

    /**
     * Create a contact.
     *
     * @param Contact $contact
     * @return Contact
     * @throws SplioSdkException if status code > 400
     *
     */
    public function createContact(Contact $contact): Contact
    {
        $res = $this->request(self::API_CONTACT_ENDPOINT, 'POST', $contact->jsonSerialize());

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error ' . $res->getStatusCode() .
                ' while creating contact : ' . $res->getReasonPhrase(), $res->getStatusCode());
        }

        return $this->getContact($contact->getEmail());
    }

    /**
     * Update a contact.
     *
     * @param Contact $contact
     * @return Contact
     * @throws SplioSdkException if status code > 400
     *
     */
    public function updateContact(Contact $contact): Contact
    {
        $res = $this->request(self::API_CONTACT_ENDPOINT . '/' . $contact->getEmail(), 'PUT', $contact->jsonSerialize());

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : ' . $res->getReasonPhrase(), $res->getStatusCode());
        }

        return $this->getContact($contact->getEmail());
    }

    /**
     * Delete a contact.
     *
     * @param string $email
     * @return bool
     * @throws SplioSdkException if status code > 400
     *
     */
    public function deleteContact(string $email): bool
    {
        $res = $this->request(self::API_CONTACT_ENDPOINT . '/' . $email, 'DELETE');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : ' . $res->getReasonPhrase(), $res->getStatusCode());
        }

        return true;
    }

    /**
     * Get single contact.
     *
     * @param string $email
     * @return Contact
     * @throws SplioSdkException if status code > 400
     *
     */
    public function getContact(string $email): Contact
    {
        $res = $this->request(self::API_CONTACT_ENDPOINT . '/' . $email, 'GET');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : ' . $res->getReasonPhrase(), $res->getStatusCode());
        }

        return Contact::jsonUnserialize($res->getBody()->getContents());
    }

    /**
     * Check if the specified contact is in the blacklist or not.
     *
     * @param string $email
     *
     * @return bool
     */
    public function isContactBlacklisted(string $email): bool
    {
        try {
            $this->request(self::API_BLACKLIST_ENDPOINT . '/' . $email, 'GET');
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Add a contact to blacklist.
     *
     * @param string $email
     * @return bool
     * @throws SplioSdkException if status code > 400
     *
     */
    public function addContactToBlacklist($email): bool
    {
        $res = $this->request(self::API_BLACKLIST_ENDPOINT . '/' . $email, 'POST');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while adding contact to blacklist : ' .
                $res->getReasonPhrase(), $res->getStatusCode());
        }

        return true;
    }

    /**
     * Import many contacts into splio database.
     *
     * @param ContactCollection $contacts
     * @param string $name
     */
    public function importContacts(ContactCollection $contacts, $name = 'default')
    {
        $this->dataImport->import($contacts->csvSerialize(), $name);
    }

    public function getReport(DateTime $date = null)
    {
        if (null === $date) {
            $date = new DateTime();
        }

        return $this->dataReport->getReport($date, $this->getLists());
    }
}
