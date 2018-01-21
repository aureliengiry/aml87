<?php

namespace Aml\Bundle\WebBundle\Controller;

use Aml\Bundle\BlogBundle\Entity\Article;
use Aml\Bundle\DiscographyBundle\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;

/**
 * Class DefaultController
 * @package Aml\Bundle\WebBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Method("GET")
     * @Template("default/index.html.twig")
     */
    public function indexAction()
    {
        // Last blog article
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $blogEntity = $repo->findOneBy(
            ['public' => Article::ARTICLE_IS_PUBLIC],
            ['created' => 'DESC']
        );

        // Last Album
        $repo = $this->getDoctrine()->getRepository(Album::class);
        $albumEntity = $repo->findOneBy(
            ['public' => Album::ALBUM_IS_PUBLIC],
            ['date' => 'DESC']
        );

        return [
            'lastBlogArticle' => $blogEntity,
            'lastAlbum'       => $albumEntity,
        ];
    }

    /**
     * @Route("/sitemap.{_format}", name="sitemap", Requirements={"_format" = "xml"})
     * @Method("GET")
     * @Template("default/sitemap.xml.twig")
     */
    public function sitemapAction(Request $request)
    {
        $urls = [];

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $hostname = 'http://' . $request->getHost();

        // add some urls homepage
        $urls[] = [
            'loc'        => $this->get('router')->generate('home'),
            'changefreq' => 'weekly',
            'priority'   => '1.0',
        ];

        $sitemapGenerationEvent = new GenerateEvent($urls);
        $dispatcher->dispatch('aml_web.sitemap.generate_start', $sitemapGenerationEvent);

        return [
            'urls'     => $sitemapGenerationEvent->getUrls(),
            'hostname' => $hostname,
        ];
    }

    /**
     * @Route("/google-analytics", name="google-analytics")
     * @Method("GET")
     * @Template("main/googleAnalytics.html.twig")
     */
    public function googleAnalyticsAction()
    {
        return  ['ga_id' => $this->container->getParameter('app_google_analytics.account_id')];
    }
}
