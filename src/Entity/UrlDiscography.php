<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UrlDiscography.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 */
class UrlDiscography extends Url
{
}
