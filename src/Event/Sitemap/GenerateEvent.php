<?php
namespace App\Event\Sitemap;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class GenerateEvent
 *
 * @package App\Event
 */
class GenerateEvent extends Event
{
    protected $urls = array();

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
