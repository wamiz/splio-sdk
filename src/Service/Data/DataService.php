<?php

namespace Splio\Service\Data;

use Splio\Exception\SplioSdkException;
use Splio\Service\AbstractService;

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
     * Get all lists created into universe.
     *
     * @return array
     */
    public function getLists()
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
     * @param array $contact {
     *
     *   Your new contact
     *
     *   @option string email required
     *   @option string firstname optional
     *   @option string lastname optional
     *   @option array fields [[id => 0, name => 'birthdate', value => '2000-01-01']...]
     *   @option array lists [[id => 0], [id => 1]...]
     * 
     * }
     *
     * @return object
     */
    public function createContact($contact)
    {
        $res = $this->request(self::API_CONTACT_ENPOINT, 'POST', $contact);

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error '.$res->getStatusCode().
            ' while creating contact : '.$res->getReasonPhrase(), $res->getStatusCode());
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Update a contact.
     *
     * @param array $contact (see createContact for all options)
     */
    public function updateContact($contact)
    {
        $res = $this->request(self::API_CONTACT_ENPOINT.'/'.$contact['email'], 'PUT', $contact);

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
    public function deleteContact($email)
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
     * @param [type] $email
     */
    public function getContact($email)
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
     * @return boolean
     */
    public function isContactBlacklisted($email): bool
    {
        try {
            $req = $this->request(self::API_BLACKLIST_ENPOINT.'/'.$email, 'GET');
        }
        catch (\Exception $e)
        {
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
