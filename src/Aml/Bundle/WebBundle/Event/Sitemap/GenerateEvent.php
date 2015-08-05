<?php
namespace Aml\Bundle\WebBundle\Event\Sitemap;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class GenerateEvent
 *
 * @package Aml\Bundle\WebBundle\Event
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
