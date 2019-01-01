<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message.
 *
 * @ORM\Table(name="contact_us_messages")
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    const MESSAGE_STATUS_SAVE = 1;
    const MESSAGE_STATUS_SAVE_SEND = 2;
    /**
     * @var int
     *
     * @ORM\Column(name="id_message", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name = '';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email = '';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject = '';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=10, max=1000)
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address_ip", type="string", length=255)
     */
    private $addressIp;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var bool
     *
     * @ORM\Column(name="spam", type="boolean")
     */
    private $spam = false;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * Get id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set email.
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Get email.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set subject.
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject.
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Set body.
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * Get body.
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set addressIp.
     *
     *
     * @return Message
     */
    public function setAddressIp(string $addressIp)
    {
        $this->addressIp = $addressIp;

        return $this;
    }

    /**
     * Get addressIp.
     */
    public function getAddressIp(): ?string
    {
        return $this->addressIp;
    }

    /**
     * Set status.
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get status.
     */
    public function getStatus(): string
    {
        $statusOptions = [
            0 => 'NC',
            self::MESSAGE_STATUS_SAVE => 'Enregistré',
            self::MESSAGE_STATUS_SAVE_SEND => 'Enregistré & envoyé',
        ];

        return $statusOptions[$this->status];
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;
    }

    /**
     * Get created.
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Check if it's a spam.
     */
    public function isSpam(): bool
    {
        return $this->spam;
    }

    /**
     * Set spam.
     *
     * @param bool $spam
     */
    public function setSpam($spam)
    {
        if (!empty($spam)) {
            $spam = true;
        }

        if (null === $spam) {
            $spam = false;
        }

        $this->spam = $spam;
    }

    public function __toString()
    {
        return $this->subject ?: 'New message';
    }
}
