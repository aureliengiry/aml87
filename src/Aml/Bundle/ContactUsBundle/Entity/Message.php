<?php

namespace Aml\Bundle\ContactUsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="contact_us_messages")
 * @ORM\Entity(repositoryClass="Aml\Bundle\ContactUsBundle\Entity\Repository\MessageRepository")
 */
class Message
{
    const MESSAGE_STATUS_SAVE = 1;
    const MESSAGE_STATUS_SAVE_SEND = 2;
    /**
     * @var integer
     *
     * @ORM\Column(name="id_message", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="address_ip", type="string", length=255)
     */
    private $addressIp;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var boolean $spam
     *
     * @ORM\Column(name="spam", type="boolean")
     */
    private $spam;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Message
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set addressIp
     *
     * @param string $addressIp
     *
     * @return Message
     */
    public function setAddressIp($addressIp)
    {
        $this->addressIp = $addressIp;

        return $this;
    }

    /**
     * Get addressIp
     *
     * @return string
     */
    public function getAddressIp()
    {
        return $this->addressIp;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        $statusOptions = array(
            0                              => "NC",
            self::MESSAGE_STATUS_SAVE      => 'Enregistré',
            self::MESSAGE_STATUS_SAVE_SEND => 'Enregistré & envoyé'
        );

        return $statusOptions[$this->status];
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Check if it's a spam
     *
     * @return boolean
     */
    public function isSpam()
    {
        return $this->spam;
    }

    /**
     * Set spam
     *
     * @param boolean $spam
     */
    public function setSpam($spam)
    {
        $this->spam = $spam;
    }

    public function __toString()
    {
        return $this->subject ?: 'New message';
    }
}
