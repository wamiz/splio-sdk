<?php
/**
 * List object.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\EmailList;

use Splio\Serialize\SplioSerializeInterface;

class EmailList implements SplioSerializeInterface
{
    private $id = false;
    private $name = false;
    private $action = false;
    private $members = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMembers(): int
    {
        return $this->members;
    }

    /**
     * Set list id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set list name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set action (to unsubscribe someone).
     *
     * @param string $action
     *
     * @return self
     */
    public function setAction(string $action = 'unsubscribe')
    {
        $this->action = $action;

        return $this;
    }

    public function setMembers(int $members): self
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Return formatted data for Splio API.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'action' => $this->action,
            'members' => $this->members,
        ],
          function ($item) { return false !== $item ? true : false; });
    }

    public static function jsonUnserialize(string $response)
    {
        $data = json_decode($response);

        $res = new self();
        $res->setId($data->id);
        $res->setName($data->name);

        if (isset($data->action) && $data->action) {
            $res->setAction($data->action);
        }

        if (isset($data->members) && $data->members) {
            $res->setMembers($data->members);
        }

        return $res;
    }
}
