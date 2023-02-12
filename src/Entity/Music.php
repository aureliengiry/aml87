<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\Entity\Music.
 *
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Entity(repositoryClass="App\Repository\MusicRepository")
 */
class Music extends File
{
    #[Assert\File(maxSize: '20M', mimeTypes: ['audio/x-mpeg-3', 'audio/mpeg3', 'audio/x-mid', 'audio/x-midi', 'music/crescendo', 'x-music/x-midi'], mimeTypesMessage: 'Le fichier audio choisi ne correspond pas à un type de fichier valide', notFoundMessage: "Le fichier audio n'a pas été trouvé sur le disque", uploadErrorMessage: "Erreur dans l'upload du fichier audio")]
    private $file;

    protected function getUploadDir(): string
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/music';
    }

    /**
     * @return array{label: string, key: string}
     */
    public function getType(): array
    {
        return ['label' => 'Fichier audio', 'key' => 'music'];
    }
}
