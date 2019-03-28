<?php
/**
 * Define user object.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Service\Data\Contact;

use Splio\Serialize\SplioSerializeInterface;
use Splio\Service\Data\CustomField\CustomField;
use Splio\Service\Data\CustomField\CustomFieldCollection;
use Splio\Service\Data\EmailList\EmailList;
use Splio\Service\Data\EmailList\EmailListCollection;

class Contact implements SplioSerializeInterface
{
    private $id = false;
    private $email = false;
    private $firstname = false;
    private $lastname = false;
    private $lang = false;
    private $cellphone = false;
    private $date = false;
    private $fields = [];
    private $lists = [];

    public function __construct()
    {
        $this->fields = new CustomFieldCollection();
        $this->lists = new EmailListCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set contact email.
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set contact firstname.
     *
     * @param string $firstname
     *
     * @return Contact
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Set contact lastname.
     *
     * @param string $lastname
     *
     * @return Contact
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Set contact subscribe date.
     *
     * @param \DateTime $date
     *
     * @return Contact
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set contact langage.
     *
     * @param string $lang
     *
     * @return Contact
     */
    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $lang;
    }

    /**
     * Set contact cellphone.
     *
     * @param string $cellphone
     *
     * @return Contact
     */
    public function setCellphone(string $cellphone): self
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Add custom field.
     *
     * @param CustomField $field
     *
     * @return Contact
     */
    public function addCustomField(CustomField $field): self
    {
        $this->fields->append($field);

        return $this;
    }

    public function addEmailList(EmailList $list): self
    {
        $this->lists->append($list);

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Returns serialized object for splio.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'lang' => $this->lang,
            'cellphone' => $this->cellphone,
            'fields' => $this->fields->jsonSerialize(),
            'lists' => $this->lists->jsonSerialize(),
        ];

        if ($this->date instanceof \DateTime) {
            $data['date'] = $this->date->format('Y-m-d H:i:s');
        }

        return array_filter($data);
    }

    /**
     * Fill contact object with splio data.
     *
     * @todo implement it
     *
     * @param array $data
     *
     * @return self
     */
    public static function jsonUnserialize(object $data): self
    {
        $res = new self();
        $res->setEmail($data->email);
        $res->setFirstname($data->firstname);
        $res->setLastname($data->lastname);
        $res->setLang($data->lang);
        $res->setId($data->id);

        return $res;
    }
}
