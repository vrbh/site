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

use Vrbh\SiteBundle\Entity\User;
use Vrbh\SiteBundle\Entity\Organisation;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiOrganisationController extends Controller{
    /**
     * Get organisation data
     * @Rest\View
     * @Route("/api/organisation/{id}", requirements={"id" = "\d+"})
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
     * @Method({"PUT"})
     * @ApiDoc()
     */
    public function createOrganisationAction()
    {
        return;
    }
} 