<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Page\Domain;

use App\Page\Domain\Model\Page;

interface ObtainPageInterface
{
    public function getPublicPageBySlug(string $slug): Page;
}
