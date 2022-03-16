<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Entity;

use App\Repository\FileRepository;
use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FileRepository::class)]
class File extends Media
{
    #[Assert\File(maxSize: '2M', mimeTypes: ['application/pdf', 'application/x-pdf'], mimeTypesMessage: 'Le fichier choisi ne correspond pas à un type de fichier valide', notFoundMessage: "Le fichier n'a pas été trouvé sur le disque", uploadErrorMessage: "Erreur dans l'upload du fichier")]
    private $file;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $path = null;

    // propriété utilisé temporairement pour la suppression
    private ?string $filenameForRemove = null;

    /**
     * Set file.
     *
     * @param string $file
     */
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path.
     *
     * @param string $path
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getWebPath(): ?string
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir(): string
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../public/'.$this->getUploadDir();
    }

    protected function getUploadDir(): string
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/documents';
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function preUpload(): void
    {
        if (null !== $this->file) {
            $slugger = new Slugger();
            $cleanName = $slugger->slugify($this->file->getClientOriginalName(), '_');
            $name = $this->renameIfFileExist($cleanName);
            $this->path = $name;
        }
    }

    #[ORM\PostPersist]
    #[ORM\PostUpdate]
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

    #[ORM\PreRemove]
    public function storeFilenameForRemove(): void
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    #[ORM\PostRemove]
    public function removeUpload(): void
    {
        if ($this->filenameForRemove && true === file_exists($this->filenameForRemove)) {
            unlink($this->filenameForRemove);
        }
    }

    public function getAbsolutePath(): ?string
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getType(): array
    {
        return ['label' => 'Fichier', 'key' => 'file'];
    }
}
