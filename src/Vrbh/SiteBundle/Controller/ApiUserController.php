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

class ApiUserController extends Controller
{
    /**
     * Get all information about the logged in user.
     * This information includes all organisations, which are required
     * for getting stocks. All other API methods require a organisation id.
     *
     * @Rest\View
     * @Route("/api/user/current")
     * @Method({"GET"})
     * @ApiDoc()
     */
    public function getCurrentUserAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$user) {
            return array('error', 'Not logged in?');
        }
        return array('user' => $user);
    }

    /**
     * Get all organisations a user has access to, including the access level.
     *
     * @Rest\View
     * @Route("/api/user/current/organisations")
     * @Method({"GET"})
     * @ApiDoc()
     */
    public function getCurrentUserOrgsAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$user) {
            return array('error', 'Not logged in?');
        }

        return array('organisations' => $user->getOrgs());
    }

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
     *
	 * @param integer $id user id
	 *
	 * @Rest\View
	 * @Route("/api/user/{id}", requirements={"id" = "\d+"})
	 * @Method({"GET"})
	 * @return User requested user
     * @throws NotFoundHttpException
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
	 * 
	 * @param integer $id user id
	 *
     * @Rest\View(statusCode=204)
	 * @Route("/api/user/{id}", requirements={"id" = "\d+"})
	 * @Method({"DELETE"})
     * @throws NotFoundHttpException
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

        //return array('user' => $user);
    }
}