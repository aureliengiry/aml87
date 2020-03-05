<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Event\Sitemap;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class GenerateEvent.
 */
class GenerateEvent extends Event
{
    protected $urls = [];

    public function __construct($sitemapUrls)
    {
        $this->urls = $sitemapUrls;
    }

    public function getUrls()
    {
        return $this->urls;
    }

    public function setUrls($urls)
    {
        $this->urls = $urls;

        return $this;
    }

    public function addUrls($url)
    {
        $this->urls[] = $url;

        return $this;
    }
}
