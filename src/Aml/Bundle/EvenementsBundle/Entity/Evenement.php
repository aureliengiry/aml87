<?php

namespace Aml\Bundle\EvenementsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * Aml\Bundle\EvenementsBundle\Entity\Evenement
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity(repositoryClass="Aml\Bundle\EvenementsBundle\Entity\Repository\EvenementRepository")
 */
class Evenement
{
    const EVENEMENT_TYPE_CONCERT = 'concert';
    const EVENEMENT_TYPE_REUNION = 'reunion';
    const EVENEMENT_TYPE_REPETITION = 'repetition';
    const EVENEMENT_TYPE_ENREGISTREMENT = 'enregistrement';
    const EVENEMENT_TYPE_CONCOURS = 'concours';
    const EVENEMENT_TYPE_SORTIE = 'sortie';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_evenement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var datetime $dateStart
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;
    
    /**
     * @var datetime $dateEnd
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean $archive
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\BlogBundle\Entity\Blog", mappedBy="evenements", cascade={"persist"})
     */
    protected $articlesBlog;

    public function __construct()
    {
        $this->articlesBlog = new ArrayCollection();
        // $this->files = new ArrayCollection();
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
     * Set date
     *
     * @param datetime $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }
    
    /**
     * Set dateEnd
     *
     * @param datetime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
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

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set archive
     *
     * @param boolean $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }
    
	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

    /**
     * Retourne le liste des différents types d'évènement
     * @return array
     */
    static function getTypesEvenements() {
        $typesEvenement = array();

        $typesEvenement[self::EVENEMENT_TYPE_CONCERT] = 'Concert';
        $typesEvenement[self::EVENEMENT_TYPE_CONCOURS] = 'Concours';
        $typesEvenement[self::EVENEMENT_TYPE_ENREGISTREMENT] = 'Enregistrement';
        $typesEvenement[self::EVENEMENT_TYPE_REPETITION] = 'Répétition';
        $typesEvenement[self::EVENEMENT_TYPE_REUNION] = 'Réunion';
        $typesEvenement[self::EVENEMENT_TYPE_SORTIE] = 'Sortie';

        return $typesEvenement;
    }

    /* ---------------- ARTICLES LIES ---------------- */

    /**
     *
     * @param Blog $articleBlog
     */
    public function addArticleBlog($articleBlog) {
        // var_dump( $tag);exit;
        $articleBlog->addEvenement($this);
        $this->articlesBlog[] = $articleBlog;
        return $this;
    }

    /**
     * Fonction to delete articleBlog
     * @param Blog $articleBlog
     */
    public function removeTag($articleBlog)
    {
        $this->articlesBlog->removeElement($articleBlog);
    }

    /**
     * @return Evenement
     */
    public function getArticlesBlog() {
        return $this->articlesBlog;
    }

    /**
     * @return Evenement
     */
    public function setArticlesBlog(ArrayCollection $articlesBlog) {
        $this->articlesBlog = $articlesBlog;
        return $this;
    }
}