<?php

namespace Vrbh\SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $response = new Response();

        $response->setPublic();

        $response->setSharedMaxAge(600);

        return $this->render('VrbhSiteBundle:Default:index.html.twig', array(), $response);
    }
}
