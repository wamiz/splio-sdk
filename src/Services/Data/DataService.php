<?php
namespace Splio\Services\Data;

use Splio\Services\AbstractService;

class DataService extends AbstractService
{
    protected function getPath()
    {
        return '/api/data';
    }

    /**
     * Get all lists created into universe
     *
     * @return array
     */
    public function getLists()
    {
        return array();
    }

    /**
     * Create an user
     *
     * @param array $user
     * @return void
     */
    public function createUser($user)
    {

    }
}