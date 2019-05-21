<?php

namespace Splio\Service\Data\Report;

use \DateTime;
use Splio\Service\Data\EmailList\EmailListCollection;

class ContactReport
{
    private $email;
    private $campaignName;
    private $campaignId;
    private $sendId;
    private $link;
    private $status;
    private $date;
    private $lists;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCampaignName()
    {
        return $this->campaignName;
    }

    /**
     * @param string $campaignName
     */
    public function setCampaignName($campaignName): void
    {
        $this->campaignName = $campaignName;
    }

    /**
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param string $campaignId
     */
    public function setCampaignId($campaignId): void
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return string
     */
    public function getSendId()
    {
        return $this->sendId;
    }

    /**
     * @param string $sendId
     */
    public function setSendId($sendId): void
    {
        $this->sendId = $sendId;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return EmailListCollection
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param mixed $lists
     */
    public function setLists(EmailListCollection $lists): void
    {
        $this->lists = $lists;
    }
}