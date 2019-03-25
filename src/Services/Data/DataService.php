<?php

namespace Splio\Services\Data;

use Splio\Exception\SplioSdkException;
use Splio\Services\AbstractService;

class DataService extends AbstractService
{
    const API_LIST_ENDPOINT = 'lists';
    const API_CONTACT_ENPOINT = 'contact';
    const API_BLACKLIST_ENPOINT = 'contact';

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
     * @param array $contact
     *                       [
     *                       email (mandatory),
     *                       firstname,
     *                       lastname,
     *                       fields: [[id => 0, name => 'birthdate', value => '2000-01-01']...],
     *                       lists: [[id => 0], [id => 1]...]
     *                       ]
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
     * Check if the specified contact is in the blacklist or not
     *
     * @param string $email
     *
     * @return bool
     */
    public function isContactBlacklisted($email): boolean
    {
        $req = $this->request(self::API_BLACKLIST_ENPOINT.'/'.$email, 'GET');
        $res = json_decode($res->getBody()->getContents());

        switch ($res['code']) {
            case 404:
                return false;
                break;
            case 200:
                return true;
                break;
            default:
                throw new SplioSdkException('Error while checking blacklist : '.
                    $res->getReasonPhrase(), $res->getStatusCode());
        }
    }

    /**
     * Add a contact to blacklist
     *
     * @param string $email
     * @return boolean
     */
    public function addContactToBlacklist($email): boolean
    {
        $req = $this->request(self::API_BLACKLIST_ENPOINT.'/'.$email, 'POST');

        if (400 <= $res->getStatusCode()) {
            throw new SplioSdkException('Error while adding contact to blacklist : '.
            $res->getReasonPhrase(), $res->getStatusCode());
        }

        return true;
    }
}
