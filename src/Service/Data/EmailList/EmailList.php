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
     * Return formatted data for Splio API.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return \array_filter(['id' => $this->id, 'name' => $this->name]);
    }
    
    public static function jsonUnserialize(object $data): self
    {
        $res = new self();

        return $res;
    }
}
