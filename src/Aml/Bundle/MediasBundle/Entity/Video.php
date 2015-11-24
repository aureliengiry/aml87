<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\WebBundle\Entity\Video
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\VideoRepository")
 *
 * @ORM\Table(name="mediasbundle_videos")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="provider", type="string")
 * @ORM\DiscriminatorMap({
 *     "youtube" = "\Aml\Bundle\MediasBundle\Entity\Video\Youtube",
 *     "dailymotion" = "\Aml\Bundle\MediasBundle\Entity\Video\Dailymotion"
 * })
 */
abstract class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id_video", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $providerId
     *
     * @ORM\Column(name="provider_id", type="string", length=50)
     */
    protected $providerId;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255,nullable=true)
     */
    protected $title;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\EvenementsBundle\Entity\Evenement", mappedBy="videos", cascade={"all"})
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

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
     * @param string $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    /**
     * @param Evenement $evenement
     * @return $this
     */
    public function addEvenement(Evenement $evenement)
    {
        if (!$this->evenements->contains($evenement)) {
            $evenement->addVideo($this);
            $this->evenements[] = $evenement;
        }

        return $this;
    }

    /**
     * Fonction to delete $evenement
     * @param Evenement $evenement
     */
    public function removeEvenement(Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
        $evenement->removeVideo($this);
    }

    /**
     * @return the $evenements
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @return the $evenements
     */
    public function setEvenements(ArrayCollection $evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

}
