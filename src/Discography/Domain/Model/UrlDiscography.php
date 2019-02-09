<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography\Domain\Model;

use App\Core\Domain\Model\Url;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UrlDiscography.
 *
 * @ORM\Entity(repositoryClass="App\Core\Infrastructure\Repository\UrlRepository")
 */
class UrlDiscography extends Url
{
}
