<?php
/**
 * Created by PhpStorm.
 * User: paulsohier
 * Date: 13-11-13
 * Time: 17:41
 */

namespace Vrbh\SiteBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Vrbh\SiteBundle\Entity\User;
use Vrbh\SiteBundle\Entity\Organisation;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vrbh\SiteBundle\Entity\UserOrg;

class ApiOrganisationController extends Controller{
    /**
     * Get organisation data
     * @Rest\View
     * @Route("/api/organisation/{id}", requirements={"id" = "\d+"}, name="get_organisation")
     * @Method({"GET"})
     * @throws NotFoundHttpException
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

    /**
     * Get all organisations. This requires ROLE_ADMIN.
     * @Rest\View
     * @Route("/api/organisation/all")
     * @Method({"GET"})
     * @ApiDoc()
     */
    public function getOrganisationsAction()
    {
        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->findAll();

        return array('organisations' => $org);
    }

    /**
     * Delete a organisation. This requires ROLE_ADMIN
     *
     * @Rest\View
     * @Route("/api/organisation/{id}", requirements={"id" = "\d+"})
     * @Method({"DELETE"})
     * @ApiDoc()
     */
    public function deleteOrganisationAction($id)
    {

    }

    /**
     * Create a new organisation
     *
     * @Rest\View
     * @Route("/api/organisation")
     * @Method({"POST"})
     * @ApiDoc()
     */
    public function createOrganisationAction()
    {
        $org = new Organisation();
        return $this->processForm($org, true);
    }

    private function processForm(Organisation $organisation, $new)
    {
        $statusCode = $new ? 201 : 204;


        $request = $this->get('request');
        $name_value = $request->request->get('name');

        $user = $this->container->get('security.context')->getToken()->getUser();


        if (!empty($name_value)) {
            $organisation->setCreated($user);
            $organisation->setName($name_value);

            $em = $this->container->get('doctrine')->getEntityManager();

            $userorg = new UserOrg();
            $userorg->setOrganisation($organisation);
            $userorg->setUser($user);
            $userorg->setType("admin");


            $em->persist($organisation);

            $em->persist($userorg);

            $organisation->addUser($userorg);
            $user->addOrg($userorg);
            $em->persist($organisation);
            $em->persist($user);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'get_organisation', array('id' => $organisation->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create(array('error' => 'Name is empty'), 400);
    }
} 