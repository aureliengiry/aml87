<?php

namespace Aml\Bundle\MediasBundle\Entity\Video;

use Doctrine\ORM\Mapping as ORM;
use Aml\Bundle\MediasBundle\Entity\Video;


/**
 * Aml\Bundle\MediasBundle\Entity\Video\Youtube
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\Video\YoutubeRepository")
 */
class Youtube extends Video
{
    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New Video Youtube';
    }
}
