<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

use Aml\Bundle\MediasBundle\Entity\File;

/**
 * Aml\Bundle\WebBundle\Entity\Music
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\MusicRepository")
 */
class Music extends File
{
	/**
	 * @Assert\File(
	 *     maxSize = "20M",
	 *     mimeTypes = {"audio/x-mpeg-3", "audio/mpeg3", "audio/x-mid", "audio/x-midi", "music/crescendo", "x-music/x-midi"},
	 *     mimeTypesMessage = "Le fichier audio choisi ne correspond pas à un type de fichier valide",
	 *     notFoundMessage = "Le fichier audio n'a pas été trouvé sur le disque",
	 *     uploadErrorMessage = "Erreur dans l'upload du fichier audio"
	 * )
	 */
	private $file;

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/music';
    }
    
    public function getType(){
    	return array('label' => 'Fichier audio', 'key' => 'music' );
    }
}