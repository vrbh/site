<?php

namespace Vrbh\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
	
		$user = $this->getUser();
		
		$orgs = $user->getOrgs();
		$org = $orgs[0]->getOrganisation();
		
		
		
        return array('status'=> $orgs[0]->getType(), 'name' => $org->getName());
    }
}
