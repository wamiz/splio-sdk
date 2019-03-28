<?php
/**
 * Define custom field.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\CustomField;

use Splio\Serialize\SplioSerializeInterface;

class CustomField implements SplioSerializeInterface
{
    private $id = false;
    private $name = false;
    private $value = false;

    /**
     * Set id.
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
     * Set name.
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
     * Set value.
     *
     * @param string $value
     *
     * @return self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Format custom field to send to Splio.
     */
    public function jsonSerialize()
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
        ]);
    }
    
    public static function jsonUnserialize(object $data): self
    {
        $res = new self();

        return $res;
    }
}
