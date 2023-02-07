<?php

namespace Splio\Service\Trigger\Recipient;

class Recipient
{
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $cellphone;
    protected $custom = [];

    /**
     * Set recipient email
     *
     * @param string $email
     * @return Recipient
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set recipient fistname
     *
     * @param string $firstname
     * @return Recipient
     */
    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Set recipient lastname
     *
     * @param string $lastname
     * @return Recipient
     */
    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Set recipient cellphone
     *
     * @param string $cellphone
     * @return Recipient
     */
    public function setCellphone($cellphone): self
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Add custom field data to recipient
     *
     * @param integer $customFieldId
     * @param string $customFieldValue
     *
     * @return Recipient
     */
    public function addCustomField($customFieldId, $customFieldValue): self
    {
        $custom = ['field_id' => $customFieldId, 'field_value' => $customFieldValue];

        array_push($this->custom, $custom);

        return $this;
    }

    /**
     * Set data to send to trigger API
     *
     * @return array<string, mixed>
     */
    public function getFormattedData(): array
    {
        $cf = [];

        foreach ($this->custom as $custom) {
            $key = 'c' . $custom['field_id'];

            $cf[$key] = $custom['field_value'];
        }

        $data = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
        ];

        return array_merge($data, $cf);
    }
}
