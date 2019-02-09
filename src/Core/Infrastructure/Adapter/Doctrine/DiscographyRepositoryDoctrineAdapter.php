<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Doctrine;

use App\Discography\Domain\DiscographyRepositoryInterface;
use App\Discography\Domain\Exception\AlbumNotFoundException;
use App\Discography\Domain\Model\Album;
use App\Discography\Infrastructure\Doctrine\AlbumDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DiscographyRepositoryDoctrineAdapter.
 */
class DiscographyRepositoryDoctrineAdapter implements DiscographyRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * DiscographyRepositoryDoctrineAdapter constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    private function getAlbumRepository(): AlbumDoctrineRepository
    {
        return $this->em->getRepository(Album::class);
    }

    public function getPublicAlbums(): iterable
    {
        return $this->getAlbumRepository()->findBy(
            ['public' => '1'],
            ['date' => 'DESC']
        );
    }

    /**
     * Retrieves Album by id or slug.
     */
    public function getAlbumBySlug(string $slug): Album
    {
        if (\is_numeric($slug)) {
            $album = $this->getAlbumRepository()->find($slug);
        } else {
            $album = $this->getAlbumRepository()->getAlbumByUrlKey($slug);
        }

        if (null === $album) {
            throw new AlbumNotFoundException('Unable to find Album entity.');
        }

        return $album;
    }
}
