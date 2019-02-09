<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Media\Domain\Model\Video;

use App\Media\Domain\Model\Video;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Core\Domain\Model\Video\Youtube.
 *
 * @ORM\Entity(repositoryClass="App\Media\Infrastructure\Doctrine\Video\YoutubeDoctrineRepository")
 */
class Youtube extends Video
{
    const PATTERN_URL_VIDEO = 'https://www.youtube.com/watch?v=%s';
    const PATTERN_URL_THUMBNAIL_HQ = 'https://i.ytimg.com/vi/%s/hqdefault.jpg';
    const PATTERN_URL_THUMBNAIL = 'https://i.ytimg.com/vi/%s/default.jpg';

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

    public function __construct(string $title = null, string $idYoutube = null)
    {
        parent::__construct();
        $this->title = $title;
        $this->providerId = $idYoutube;
    }

    public function createVideo(string $title, string $idYoutube): self
    {
        $videoYoutube = new self();
    }

    public function getUrlYoutube()
    {
        return \sprintf(self::PATTERN_URL_VIDEO, $this->providerId);
    }

    public function getUrlThumbnail()
    {
        return \sprintf(self::PATTERN_URL_THUMBNAIL, $this->providerId);
    }

    public function getUrlThumbnailHq()
    {
        return \sprintf(self::PATTERN_URL_THUMBNAIL_HQ, $this->providerId);
    }
}
