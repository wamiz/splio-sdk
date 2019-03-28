<?php
/**
 * Service to manage contacts from Splio Data API.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data;

use Splio\Exception\SplioSdkException;
use Splio\Service\AbstractService;
use Splio\Service\Data\Contact\Contact;

class DataService extends AbstractService
{
    const API_LIST_ENDPOINT = 'lists';
    const API_CONTACT_ENPOINT = 'contact';
    const API_BLACKLIST_ENPOINT = 'blacklist';

    protected function getPath()
    {
        return 'api/data';
    }

    /**
     * Set endpoint for data API.
     */
    protected function setEndpoint(): void
    {
        $this->endpoint = 'https://'.
                          $this->universe.':'.
                          $this->key.'@'.
                          $this->baseUrl.'/'.
                          $this->path.'/'.
                          ($this->version ? $this->version : '')
                        ;
    }

    /**
     * Get all lists created into universe.
     *
     * @return array
     */
    public function getLists(): object
    {
        $res = $this->request(self::API_LIST_ENDPOINT, 'GET');

        if (200 !== $res->getStatusCode()) {
            throw new SplioSdkException('Error while fetching lists : '.
                $res->getReasonPhrase(), $res->getStatusCode());
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Create a contact.
     *
     * @param Contact $contact
     *
     * @return object
     */
    public function createContact(Contact $contact)
    {
        $res = $this->request(self::API_CONTACT_ENPOINT, 'POST', $contact->jsonSerialize());
        
        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error '.$res->getStatusCode().
            ' while creating contact : '.$res->getReasonPhrase(), $res->getStatusCode());
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Update a contact.
     *
     * @param Contact $contact
     */
    public function updateContact(Contact $contact)
    {
        $res = $this->request(self::API_CONTACT_ENPOINT.'/'.$contact->getEmail(), 'PUT', $contact->jsonSerialize());

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : '.$res->getReasonPhrase(), $res->getStatusCode());
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Delete a contact.
     *
     * @param string $email
     *
     * @return bool
     */
    public function deleteContact(string $email): bool
    {
        $res = $this->request(self::API_CONTACT_ENPOINT.'/'.$email, 'DELETE');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : '.$res->getReasonPhrase(), $res->getStatusCode());
        }

        return true;
    }

    /**
     * Get single contact.
     *
     * @param string $email
     */
    public function getContact(string $email)
    {
        $res = $this->request(self::API_CONTACT_ENPOINT.'/'.$email, 'GET');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while updating contact : '.$res->getReasonPhrase(), $res->getStatusCode());
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Check if the specified contact is in the blacklist or not.
     *
     * @param string $email
     *
     * @return bool
     */
    public function isContactBlacklisted($email): bool
    {
        try {
            $req = $this->request(self::API_BLACKLIST_ENPOINT.'/'.$email, 'GET');
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Add a contact to blacklist.
     *
     * @param string $email
     *
     * @return bool
     */
    public function addContactToBlacklist($email): bool
    {
        $res = $this->request(self::API_BLACKLIST_ENPOINT.'/'.$email, 'POST');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while adding contact to blacklist : '.
            $res->getReasonPhrase(), $res->getStatusCode());
        }

        return true;
    }
}
