<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Media.
 *
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 *
 * @ORM\Table(name="mediasbundle_medias")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\DiscriminatorColumn(name="type", type="string")
 *
 * @ORM\DiscriminatorMap({
 *     "file" = "File",
 *     "image" = "Image",
 *     "music" = "Music"
 * })
 */
abstract class Media implements \Stringable
{
    /**
     * @ORM\Column(name="id_media", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    protected function renameIfFileExist(string $name): string
    {
        $filename = $this->getUploadRootDir().'/'.$name;
        if (file_exists($filename)) {
            $nameExplode = explode('.', $name);
            $nameFile = $nameExplode[0];
            $extension = $nameExplode[1];

            $fileExist = true;
            $count = 1;
            while ($fileExist) {
                $name = $nameFile.'_'.$count.'.'.$extension;
                $filename = $this->getUploadRootDir().'/'.$name;
                if ( ! file_exists($filename)) {
                    $fileExist = false;
                    break;
                }

                ++$count;
            }
        }

        return $name;
    }

    public function __toString(): string
    {
        return $this->title ?: 'New media';
    }
}
