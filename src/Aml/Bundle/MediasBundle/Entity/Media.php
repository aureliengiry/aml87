<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\WebBundle\Entity\Media
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\MediaRepository")
 *
 *
 * @ORM\Table(name="medias")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"file" = "File", "image" = "Image", "music" = "Music"})
 */
class Media
{
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id_media", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

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
     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     */
    protected function _build_SystemName($string)
    {
    	/**
	     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
	     */
        $string = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
        $string = str_replace(array(' ','-', '~'), array('_','_','_'),$string);

        return strtolower($string);
    }

    /**
     *
     * @param unknown_type $name
     * @return string
     */
    protected function _renameIfFileExist( $name ){

        $filename = $this->getUploadRootDir() .'/'. $name;
        if( true === file_exists($filename) ){
            $nameExplode = explode('.',$name);
            $nameFile = $nameExplode[0];
            $extension = $nameExplode[1];

            $fileExist = true;
            $count=1;
            while( true === $fileExist  ){
                $name = $nameFile . '_' .$count . '.' . $extension;
                $filename = $this->getUploadRootDir() .'/'. $name;
                if( false === file_exists($filename) ){
                    $fileExist = false;
                    break;
                }
                else{
                    $count++;
                }
            }


        }
        return $name;
    }
    
}