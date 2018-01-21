<?php
namespace Aml\Bundle\BlogBundle\EventListener;

use Aml\Bundle\BlogBundle\Entity\Article;
use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class PostListener
 * @package Aml\Bundle\BlogBundle\EventListener
 */
class SitemapListener implements EventSubscriberInterface
{
    private $em;
    private $router;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Router $router
     */
    public function __construct(ObjectManager $entityManager, RouterInterface $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'aml_web.sitemap.generate_start' => 'onGenerateSitemapEvent',
        ];
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
        $repositoryArticle = $this->em->getRepository(Article::class);
        $entitiesBlog = $repositoryArticle->getPublicArticles(1, [], 100);

        // add some urls blog
        foreach ($entitiesBlog as $article) {

            if (!$article->getUrl()) {
                continue;
            }

            $urlArticleBlog = [
                'loc'        => $this->router->generate('blog_show', ['slug' => $article->getSlug()]),
                'changefreq' => 'weekly',
                'priority'   => '0.50',
            ];
            $event->addUrls($urlArticleBlog);
        }
    }
}
