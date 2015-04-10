<?php

namespace Tools\Bundle\GoogleAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $accountGa = $this->container->getParameter('tools_google_analytics.account_id');
        return $this->render(
            'ToolsGoogleAnalyticsBundle:Default:index.html.twig',
            array('ga_id' => $accountGa)
        );
    }
}
