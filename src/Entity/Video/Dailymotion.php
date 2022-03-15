<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity\Video;

use App\Entity\Video;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Video\Dailymotion.
 *
 * @ORM\Entity(repositoryClass="App\Entity\Repository\Video\DailymotionRepository")
 */
class Dailymotion extends Video implements \Stringable
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return 'Dailymotion';
    }

    public function __toString(): string
    {
        return $this->title ?: 'New Video Youtube';
    }
}
