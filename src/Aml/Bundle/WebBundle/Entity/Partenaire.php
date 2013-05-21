<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Partenaire
 *
 * @ORM\Table(name="partenaires")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_partenaire", type="integer")
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Image", inversedBy="partenaires")
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\EvenementsBundle\Entity\Evenement", inversedBy="partenaires", cascade={"persist"})
     * @ORM\JoinTable(name="evenements_partenaires",
     * 		joinColumns={@ORM\JoinColumn(name="id_partenaire", referencedColumnName="id_partenaire")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")}
     * )
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
     * Set name
     *
     * @param string $name
     * @return Partenaire
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
     * Set url
     *
     * @param string $url
     * @return Partenaire
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Partenaire
     */
    public function setLogo( $logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Partenaire
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function getEvenements()
    {
        return $this->evenements;
    }

    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
        return $this;
    }

    public function addEvenement($evenement)
    {
        $this->evenements[] = $evenement;
    }
}
