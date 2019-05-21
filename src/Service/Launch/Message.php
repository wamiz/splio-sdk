<?php

namespace Splio\Service\Launch;

use Splio\Service\Data\EmailList\EmailList;

class Message
{
    private $senderEmail;
    private $senderName;
    private $lists = [];
    private $filters = [];
    private $replyTo;
    private $url;
    private $startTime;
    private $category;
    private $opcode;

    public function setSenderEmail(string $email): self
    {
        $this->senderEmail = $email;

        return $this;
    }

    public function setSenderName(string $name): self
    {
        $this->senderName = $name;

        return $this;
    }

    public function setReplyTo(string $replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setOpcode(string $opcode): self
    {
        $this->opcode = $opcode;

        return $this;
    }

    public function getOpcode(): string
    {
        return $this->opcode;
    }

    public function addList(EmailList $list): self
    {
        $this->lists[] = $list;

        return $this;
    }

    public function addFilter(int $filterId): self
    {
        $this->filters[] = $filterId;

        return $this;
    }

    public function jsonSerialize()
    {
        $lists = array_map(function ($item) {
            return $item->getId();
        }, $this->lists);

        $data = [
            'url' => $this->url,
            'senderemail' => $this->senderEmail,
            'sendername' => $this->senderName,
            'replyto' => $this->replyTo,
            'starttime' => $this->startTime,
            'category' => $this->category,
            'opcode' => $this->opcode,
            'list' => implode(',', $lists),
            'filter' => implode(',', $this->filters),
        ];

        return array_filter($data);
    }
}
