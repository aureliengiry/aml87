<?php
namespace Aml\Bundle\BlogBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener
 * @package Aml\Bundle\BlogBundle\EventListener
 */
class SitemapListener
{
    private $em;
    private $router;

    /**
     * @param EntityManager $entityManager
     * @param Router $router
     */
    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    /**
     * @param GenerateEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        // add blog url
        $mainUrl = array('loc' => $this->router->generate('blog'), 'changefreq' => 'weekly', 'priority' => '0.80');
        $event->addUrls($mainUrl);

        // add some urls blog
        $repositoryArticle = $this->em->getRepository('AmlBlogBundle:Article');
        $entitiesBlog = $repositoryArticle->getPublicArticles(
            100,
            0,
            array()
        );

        // add some urls blog
        foreach ($entitiesBlog as $article) {

            if (!$article->getUrl()) {
                continue;
            }

            $urlArticle = $this->router->generate(
                'blog_show_rewrite',
                array('url_key' => $article->getUrl()->getUrlKey())
            );
            if (empty($urlArticle)) {
                $urlArticle = $this->router->generate('blog_show', array('id' => $article->getId()));
            }

            $urlArticleBlog = array('loc' => $urlArticle, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlArticleBlog);
        }
    }
}
