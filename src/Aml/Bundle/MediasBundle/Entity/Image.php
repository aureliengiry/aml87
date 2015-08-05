<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

use Aml\Bundle\MediasBundle\Entity\Media;

/**
 * Aml\Bundle\WebBundle\Entity\Image
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\ImageRepository")
 */
class Image extends Media
{

    /**
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\DiscographyBundle\Entity\Album", mappedBy="image")
     */
    protected $album;

    /**
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg","image/gif","image/png"},
     *     mimeTypesMessage = "L'image choisie jjj ne correspond pas à un type de fichier valide",
     *     notFoundMessage = "L'image n'a pas été trouvée sur le disque",
     *     uploadErrorMessage = "Erreur dans l'upload de l'image"
     * )
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    // propriété utilisé temporairement pour la suppression
    private $filenameForRemove;


    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
    }

    public function getType()
    {
        return array('label' => 'Image', 'key' => 'image');
    }


    /* Link with Partenaire entity */
    /**
     * @return the $articles
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/images';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {

            $cleanName = $this->_build_SystemName($this->file->getClientOriginalName());
            $name = $this->renameIfFileExist($cleanName);
            $this->path = $name;

        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // vous devez lancer une exception ici si le fichier ne peut pas
        // être déplacé afin que l'entité ne soit pas persistée dans la
        // base de données comme le fait la méthode move() de UploadedFile
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);


    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->filenameForRemove && true === file_exists($this->filenameForRemove)) {
            unlink($this->filenameForRemove);
        }
    }
}
