<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Aml\Bundle\WebBundle\Entity\Image
 * 
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\ImageRepository")
 */
class Image extends \Aml\Bundle\WebBundle\Entity\File
{
    /**
     * @ORM\OneToMany(targetEntity="Partenaire", mappedBy="logo")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_partenaire")
     */
    protected $partenaires;

	/**
	 * @Assert\File(
	 *     maxSize = "2M",
	 *     mimeTypes = {"image/jpeg","image/gif","image/png"},
	 *     mimeTypesMessage = "L'image choisie ne correspond pas à un type de fichier valide",
	 *     notFoundMessage = "L'image n'a pas été trouvée sur le disque",
	 *     uploadErrorMessage = "Erreur dans l'upload de l'image"
	 * )
	 */
	private $file;


    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
    }
	

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/images';
    }
    
    public function getType(){
    	return array('label' => 'Image', 'key' => 'image' );
    }


    /* Link with Partenaire entity */
    /**
     * @return the $articles
     */
    public function getPartenaires() {
        return $this->partenaires;
    }

    /**
     *
     * @param Blog $article
     */
    public function addPartenaire($partenaire) {
        $this->partenaires[] = $partenaire;
        return $this;
    }
   
}