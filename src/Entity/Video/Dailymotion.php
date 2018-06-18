<?php

namespace App\Entity\Video;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Video;

/**
 * App\Entity\Video\Dailymotion
 *
 * @ORM\Entity(repositoryClass="App\Entity\Repository\Video\DailymotionRepository")
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
