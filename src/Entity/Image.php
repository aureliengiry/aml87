<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\Entity\Image.
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image extends Media
{
    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Album", mappedBy="image")
     */
    protected ?Album $album;

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
    protected ?string $path;

    private ?string $filenameForRemove;

    public function getType(): array
    {
        return ['label' => 'Image', 'key' => 'image'];
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getWebPath(): ?string
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir(): string
    {
        dd(__DIR__);
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../public/'.$this->getUploadDir();
    }

    protected function getUploadDir(): string
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return '/uploads/images';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(): void
    {
        if (null !== $this->file) {
            $slugger = new Slugger();
            $cleanName = $slugger->slugify($this->file->getClientOriginalName(), '_');
            $name = $this->renameIfFileExist($cleanName);
            $this->path = $name;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(): void
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

    public function getAbsolutePath(): ?string
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove(): void
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(): void
    {
        if ($this->filenameForRemove && true === file_exists($this->filenameForRemove)) {
            unlink($this->filenameForRemove);
        }
    }
}
