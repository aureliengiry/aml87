<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Media\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Core\Domain\Model\Media.
 *
 * @ORM\Entity(repositoryClass="App\Media\Infrastructure\Doctrine\MediaDoctrineRepository")
 *
 * @ORM\Table(name="mediasbundle_medias")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "file" = "File",
 *     "image" = "Image",
 *     "music" = "Music"
 * })
 */
abstract class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_media", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255,nullable=true)
     */
    protected $title;

    /**
     * Get id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set title.
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    protected function renameIfFileExist(string $name)
    {
        $filename = $this->getUploadRootDir().'/'.$name;
        if (true === \file_exists($filename)) {
            $nameExplode = \explode('.', $name);
            $nameFile = $nameExplode[0];
            $extension = $nameExplode[1];

            $fileExist = true;
            $count = 1;
            while (true === $fileExist) {
                $name = $nameFile.'_'.$count.'.'.$extension;
                $filename = $this->getUploadRootDir().'/'.$name;
                if (false === \file_exists($filename)) {
                    $fileExist = false;
                    break;
                }
                ++$count;
            }
        }

        return $name;
    }

    public function __toString()
    {
        return $this->title ?: 'New media';
    }
}
