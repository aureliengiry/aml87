<?php
namespace Aml\Bundle\BlogBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PostListener
 * @package Aml\Bundle\BlogBundle\EventListener
 */
class SitemapListener
{
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param PostEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        $router = $this->container->get('router');

        // add blog url
        $mainUrl = array('loc' => $router->generate('blog'), 'changefreq' => 'weekly', 'priority' => '0.80');
        $event->addUrls($mainUrl);

        // add some urls blog
        $doctrine = $this->container->get('doctrine');
        $repositoryArticle = $doctrine->getManager('default')->getRepository('AmlBlogBundle:Article');
        $entitiesBlog = $repositoryArticle->getPublicArticles(
            100,
            0,
            array()
        );

        // add some urls blog
        foreach ($entitiesBlog as $article) {
            $urlArticle = $router->generate(
                'blog_show_rewrite',
                array('url_key' => $article->getUrl()->getUrlKey())
            );
            if (empty($urlArticle)) {
                $urlArticle = $router->generate('blog_show', array('id' => $article->getId()));
            }

            $urlArticleBlog = array('loc' => $urlArticle, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlArticleBlog);
        }
    }
}
