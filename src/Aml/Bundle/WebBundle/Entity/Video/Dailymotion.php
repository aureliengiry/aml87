<?php

namespace Aml\Bundle\WebBundle\Entity\Video;

use Doctrine\ORM\Mapping as ORM;

use Aml\Bundle\WebBundle\Entity\Video;

/**
 * Aml\Bundle\WebBundle\Entity\Video\Dailymotion
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\Video\DailymotionRepository")
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
