<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Media\Domain\Model\Video;

use App\Media\Domain\Model\Video;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Core\Domain\Model\Video\Dailymotion.
 *
 * @ORM\Entity(repositoryClass="App\Media\Infrastructure\Doctrine\Video\DailymotionDoctrineRepository")
 */
class Dailymotion extends Video
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

    public function __toString()
    {
        return $this->title ?: 'New Video Youtube';
    }
}
