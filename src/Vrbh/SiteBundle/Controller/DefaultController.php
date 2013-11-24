<?php

namespace Vrbh\SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    private function createResponse()
    {
        $response = new Response();

        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$user)
        {
            $response->setPublic();
            $response->setSharedMaxAge(600);
        }
        else{
            $response->setPrivate();
            $response->setMaxAge(600);
        }
        return $response;
    }
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('VrbhSiteBundle:Default:index.html.twig', array(
            'jumbo' => true,
            'jumbo_url'     => $this->get('router')->generate('about'),
            'jumbo_title'   => 'Trying to get your stock in control?',
            'jumbo_text'    => 'Stock information helps controlling your stock and visalizing the available stock. With apps for iOS and Android everyone can simple check and register stock information. Based on the information new products can be ordered.',
        ), $this->createResponse());
    }
    /**
     * @Route("/about", name="about")
     */
    public function aboutUrlAction()
    {
        return $this->render('VrbhSiteBundle:Default:about.html.twig', array(), $this->CreateResponse());
    }

    /**
     * @Route("/sidebar/org", name="OrgSidebar")
     */
    public function orgSidebarAction()
    {
        $response = new Response();
        $response->setPrivate(true);

        $user = $this->container->get('security.context')->getToken()->getUser();

        return $this->render('VrbhSiteBundle:Default:orgSidebar.html.twig', array('orgs' => $user->getOrgs()), $response);
    }
}
