<?php

namespace Aml\Bundle\WebBundle\Entity\Video;

use Doctrine\ORM\Mapping as ORM;
use Aml\Bundle\WebBundle\Entity\Video;


/**
 * Aml\Bundle\WebBundle\Entity\Video\Youtube
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\Video\YoutubeRepository")
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

    public function __construct(string $title, string $idYoutube)
    {
        $this->title = $title;
        $this->providerId = $idYoutube;
    }
}
