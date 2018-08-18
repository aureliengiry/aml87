<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity\Video;

use App\Entity\Video;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Video\Youtube.
 *
 * @ORM\Entity(repositoryClass="App\Repository\Video\YoutubeRepository")
 */
class Youtube extends Video
{
    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->providerId;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New Video Youtube';
    }

    public function __construct(string $title, string $idYoutube)
    {
        parent::__construct();
        $this->title = $title;
        $this->providerId = $idYoutube;
    }
}
