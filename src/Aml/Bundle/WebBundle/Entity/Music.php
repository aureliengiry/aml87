<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aml\Bundle\WebBundle\Entity\Music
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Repository\MusicRepository")
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

    public function getType()
    {
        return ['label' => 'Fichier audio', 'key' => 'music'];
    }
}
