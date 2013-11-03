<?php

namespace Vrbh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vrbh\SiteBundle\Entity\User;
use Vrbh\SiteBundle\Entity\Organisation;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ApiController extends Controller
{
    /**
	 * Receive all users that are registered
	 * 
     * @Rest\View
	 * @Route("/api/users")
	 * @Method({"GET"})
	 * @ApiDoc()
     */
    public function allAction()
    {
        $users = $this->getDoctrine()
        ->getRepository('VrbhSiteBundle:User')
        ->findAll();

        return array('users' => $users);
    }
	
    /**
	 * Get data from 1 user
     * @Rest\View
	 * @Route("/api/user/{id}", requirements={"id" = "\d+"})
	 * @Method({"GET"})
	 * @ApiDoc()	 
     */
    public function getAction($id)
    {
        $user = $this->getDoctrine()
        ->getRepository('VrbhSiteBundle:User')
        ->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        return array('user' => $user);
    }	
	
	
    /**
	 * Delete a user
     * @Rest\View(statusCode=204)
	 * @Route("/api/user/{id}", requirements={"id" = "\d+"})
	 * @Method({"DELETE"})
	 * @ApiDoc()	 
     */
    public function deleteAction($id)
    {
        $user = $this->getDoctrine()
        ->getRepository('VrbhSiteBundle:User')
        ->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        return array('user' => $user);
    }	

		
    /**
	 * Get organisation data
     * @Rest\View
	 * @Route("/api/organisation/{id}", requirements={"id" = "\d+"})
	 * @Method({"GET"})
	 * @ApiDoc()	 
     */
    public function getOrganisationAction($id)
    {
        $org = $this->getDoctrine()
        ->getRepository('VrbhSiteBundle:Organisation')
        ->find($id);

        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }

        return array('organisation' => $org);
    }	
}