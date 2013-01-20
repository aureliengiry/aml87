<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Blog;

/**
 * Blog controller.
 *
 * @Route("/guestbook")
 */
class GuestbookController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="guestbook")
     * @Template()
     */
    public function indexAction()
    {
        
        return array('content' => __METHOD__);
    }

    
    
}
