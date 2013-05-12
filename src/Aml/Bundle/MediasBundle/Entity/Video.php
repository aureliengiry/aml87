<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

use Aml\Bundle\WebBundle\Entity\File;

/**
 * Aml\Bundle\WebBundle\Entity\Video
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\VideoRepository")
 */
class Video 
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	public $id;
    /**
     * @ORM\Column(name="file", type="string", length=255)
	 * @Assert\NotBlank( groups={"ajout"} )
	 * @Assert\File(
	 *     maxSize = "2M",
	 *     mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide",
	 *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque",
	 *     uploadErrorMessage = "Erreur dans l'upload du fichier"
	 * )
	 */
    public $file;

//     /**
//      * @ORM\ManyToMany(targetEntity="Blog", inversedBy="files")
//      * @ORM\JoinTable(name="blog_files",
//      * 		joinColumns={@ORM\JoinColumn(name="id_file", referencedColumnName="id")},
//      * 		inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
//      * )
//      */
//     protected $articles;

	public function __construct()
    {
        //$this->articles = new ArrayCollection();
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
     * Set Filename
     *
     * @param string $filename
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get Filename
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
    
  
 	public function getFullFilePath() {
        return null === $this->file ? null : $this->getUploadRootDir(). $this->file;
    }
 
    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }
 
    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../../web/upload/images/';
    }
 
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadFile() {
    
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }
        if(!$this->id){
            $this->file->move($this->getTmpUploadRootDir(), $this->file->getClientOriginalName());
        }else{
        		var_dump('rdtezrtzerf');exit;
            $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        }
        $this->setFile($this->file->getClientOriginalName());
    }
     
    /**
     * @ORM\PostPersist()
     */
    public function moveFile()
    {
        if (null === $this->file) {
            return;
        }
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir().$this->file, $this->getFullFilePath());
        unlink($this->getTmpUploadRootDir().$this->file);
    }
 
    /**
     * @ORM\PreRemove()
     */
    public function removeFile()
    {
        unlink($this->getFullFilePath());
        rmdir($this->getUploadRootDir());
    }
    
// 	public function getArticles()
//     {
//     	return $this->articles;
//     }
    
// 	public function setArticles($articles)
//     {
//     	$this->articles = $articles;
//     	return $this;
//     }
    
//     public function addArticle($article)
//     {
//     	$this->articles[] = $article;
//     }
}