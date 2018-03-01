<?php

namespace App\Entity\Video;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Video;


/**
 * App\Entity\Video\Youtube
 *
 * @ORM\Entity(repositoryClass="App\Entity\Repository\Video\YoutubeRepository")
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
