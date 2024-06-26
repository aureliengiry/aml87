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
 * App\Entity\Video\Youtube.
 *
 * @ORM\Entity(repositoryClass="App\Repository\Video\YoutubeRepository")
 */
class Youtube extends Video implements \Stringable
{
    /**
     * @var string
     */
    final public const PATTERN_URL_VIDEO = 'https://www.youtube.com/watch?v=%s';

    /**
     * @var string
     */
    final public const PATTERN_URL_THUMBNAIL_HQ = 'https://i.ytimg.com/vi/%s/hqdefault.jpg';

    /**
     * @var string
     */
    final public const PATTERN_URL_THUMBNAIL = 'https://i.ytimg.com/vi/%s/default.jpg';

    public function getProvider(): string
    {
        return $this->providerId;
    }

    public function __toString(): string
    {
        return $this->title ?: 'New Video Youtube';
    }

    public function __construct(?string $title = null, ?string $idYoutube = null)
    {
        parent::__construct();
        $this->title = $title;
        $this->providerId = $idYoutube;
    }

    public function getUrlYoutube(): string
    {
        return sprintf(self::PATTERN_URL_VIDEO, $this->providerId);
    }

    public function getUrlThumbnail(): string
    {
        return sprintf(self::PATTERN_URL_THUMBNAIL, $this->providerId);
    }

    public function getUrlThumbnailHq(): string
    {
        return sprintf(self::PATTERN_URL_THUMBNAIL_HQ, $this->providerId);
    }
}
