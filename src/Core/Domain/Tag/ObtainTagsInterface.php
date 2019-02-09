<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Domain\Tag;

interface ObtainTagsInterface
{
    public function getTagsWithNbArticles(): iterable;
}
