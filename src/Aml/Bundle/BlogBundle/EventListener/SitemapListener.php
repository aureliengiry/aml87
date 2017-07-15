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
        $mainUrl = [
            'loc'        => $this->router->generate('blog'),
            'changefreq' => 'weekly',
            'priority'   => '0.80',
        ];
        $event->addUrls($mainUrl);

        // add some urls blog
        $repositoryArticle = $this->em->getRepository('AmlBlogBundle:Article');
        $entitiesBlog = $repositoryArticle->getPublicArticles(1, [], 100);

        // add some urls blog
        foreach ($entitiesBlog as $article) {

            if (!$article->getUrl()) {
                continue;
            }

            $urlArticle = $this->router->generate('blog_show', ['slug' => $article->getSlug()]);
            $urlArticleBlog = [
                'loc'        => $urlArticle,
                'changefreq' => 'weekly',
                'priority'   => '0.50',
            ];
            $event->addUrls($urlArticleBlog);
        }
    }
}
