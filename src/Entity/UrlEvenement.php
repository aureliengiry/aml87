<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UrlEvenement.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 */
class UrlEvenement extends Url
{
}
