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
     * @return App\Service\Trigger\Recipient
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set recipient fistname
     *
     * @param string $firstname
     * @return App\Service\Trigger\Recipient
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Set recipient lastname
     *
     * @param string $lastname
     * @return App\Service\Trigger\Recipient
     */
    public function setLastname($lastname)
    {
        $this->lastname = $email;

        return $this;
    }

    /**
     * Set recipient cellphone
     *
     * @param string $cellphone
     * @return App\Service\Trigger\Recipient
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Add custom field data to recipient
     *
     * @param integer $customFieldId
     * @param string $value
     * 
     * @return App\Service\Trigger\Recipient
     */
    public function addCustomField($customFieldId, $customFieldValue)
    {
        $custom = ['field_id' => $customFieldId, 'field_value' => $customFieldValue];

        \array_push($this->custom, $custom);

        return $this;
    }

    /**
     * Set data to send to trigger API
     *
     * @return void
     */
    public function getFormattedData()
    {
        $cf = [];

        foreach ($this->custom as $custom)
        {
            $key = 'c' . $custom['field_id'];

            $cf[$key] = $custom['field_value'];
        }

        $data = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
        ];

        return \array_merge($data, $cf);
    }
}
