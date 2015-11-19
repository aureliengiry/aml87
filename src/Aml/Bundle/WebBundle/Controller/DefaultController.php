<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        // Last blog article
        $repo = $this->getDoctrine()->getRepository('AmlBlogBundle:Article');
        $blogEntity = $repo->findOneBy(
            array('public' => "1"),
            array('created' => 'DESC')
        );

        // Last Album
        $repo = $this->getDoctrine()->getRepository('AmlDiscographyBundle:Album');
        $albumEntity = $repo->findOneBy(
            array('public' => "1"),
            array('date' => 'DESC')
        );

        return array(
            'lastBlogArticle' => $blogEntity,
            'lastAlbum' => $albumEntity
        );
    }

    /**
     * @Route("/sitemap.{_format}", name="sitemap", Requirements={"_format" = "xml"})
     * @Template("AmlWebBundle:Default:sitemap.xml.twig")
     */
    public function sitemapAction(Request $request)
    {
        $urls = array();

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $hostname = 'http://'.$request->getHost();

        // add some urls homepage
        $urls[] = array(
            'loc' => $this->get('router')->generate('home'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        );

        $sitemapGenerationEvent = new GenerateEvent($urls);
        $dispatcher->dispatch('aml_web.sitemap.generate_start', $sitemapGenerationEvent);

        return array('urls' => $sitemapGenerationEvent->getUrls(), 'hostname' => $hostname);
    }
}
