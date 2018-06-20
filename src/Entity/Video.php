<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Evenement;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * App\Entity\Video
 *
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 *
 * @ORM\Table(name="WebBundle_videos")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="provider", type="string")
 * @ORM\DiscriminatorMap({
 *     "youtube" = "\App\Entity\Video\Youtube",
 *     "dailymotion" = "\App\Entity\Video\Dailymotion"
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
     * @ORM\ManyToMany(targetEntity="\App\Entity\Evenement", mappedBy="videos", cascade={"all"})
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
    public function getId() : int
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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() : string
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
     * @return ArrayCollection $evenements
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @return ArrayCollection $evenements
     */
    public function setEvenements(ArrayCollection $evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }
}
