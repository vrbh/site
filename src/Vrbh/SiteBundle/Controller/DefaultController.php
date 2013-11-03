<?php

namespace Vrbh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

        $user = $this->getUser();

        $org = null;
        $type = "" ;

        try {
            if ($user) {
                $orgs = $user->getOrgs();
                if (sizeof($orgs) > 0) {
                    $type = $orgs[0]->getType();
                    $org = $orgs[0]->getOrganisation()->getName();;
                }
            }
        } catch (Exception $e) {

        }

        return array('status' => $type, 'name' => $org);
    }
}
