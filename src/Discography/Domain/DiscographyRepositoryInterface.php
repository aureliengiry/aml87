<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography\Domain;

use App\Discography\Domain\Exception\AlbumNotFoundException;
use App\Discography\Domain\Model\Album;

interface DiscographyRepositoryInterface
{
    public function getPublicAlbums(): iterable;

    /**
     * @throws AlbumNotFoundException
     */
    public function getAlbumBySlug(string $slug): Album;
}
