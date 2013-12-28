<?php

namespace Vrbh\SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vrbh\SiteBundle\Entity\Organisation;

class DefaultController extends Controller
{

    /**
     * @return Response
     */
    private function createResponse()
    {
        $response = new Response();

        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$user) {
            $response->setPublic();
            $response->setSharedMaxAge(600);
        } else {
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
            'jumbo_url' => $this->get('router')->generate('about'),
            /** @Desc("Trying to get your stock in control?") **/
            'jumbo_title' => $this->get('translator')->trans('home.jumbo.index'),
            /** @Desc("Stock information helps controlling your stock and visalizing the available stock. With apps for iOS and Android everyone can simple check and register stock information. Based on the information new products can be ordered.") */
            'jumbo_text' => $this->get('translator')->trans('home.jumbo.text'),
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

    /**
     * @Route("/organisation/{id}", name="orglist", requirements={"id" = "\d+"})
     * @param int $id
     * @return template
     * @throws NotFoundHttpException
     */
    public function listOrganisationDataAction($id)
    {
        $response = new Response();
        $response->setPrivate(true);

        $user = $this->container->get('security.context')->getToken()->getUser();

        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->find($id);

        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }

        if (!$org->checkAllowed($user)) {
            throw new NotFoundHttpException('Organisation not found');
        }


        return $this->render('VrbhSiteBundle:Default:OrganisationDetails.html.twig', array('jumbo' => true,
            'jumbo_title' => $org->getName(),
            'jumbo_text' => '',
            'org' => $org), $response);
    }

    /**
     * @param int $id
     * @Route("/organisation/{id}/manage", name="manage_request", requirements={"id" = "\d+"})
     * @return template
     * @throws NotFoundHttpException
     *
     */
    public function manageOrg($id)
    {
        $response = new Response();
        $response->setPrivate(false);

        $user = $this->container->get('security.context')->getToken()->getUser();

        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->find($id);

        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }

        if (!$org->checkAllowed($user)) {
            throw new NotFoundHttpException('Organisation not found');
        }

        return $this->render('VrbhSiteBundle:Default:OrganisationRequests.html.twig', array('org' => $org), $response);
    }
    /**
     * @Route("/organisation/search/{param}", name="search_org")
     * @param String $param
     * @return Response
     */
    public function searchOrgAction($param)
    {
       $finder = $this->get('fos_elastica.finder.website.organisation');

        $result = array();

        foreach ($finder->find($param . "*") as $row)
        {
            $result[] = $row->getName();
        }



        $response = $this->createResponse();

        $response->setContent(json_encode($result));

        return $response;
    }
}
