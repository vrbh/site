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

use Vrbh\SiteBundle\Entity\Product;
use Vrbh\SiteBundle\Entity\User;
use Vrbh\SiteBundle\Entity\UserOrgRequest;
use Vrbh\SiteBundle\Entity\Stock;
use Vrbh\SiteBundle\Entity\Order;
use Vrbh\SiteBundle\Entity\Organisation;
use Vrbh\SiteBundle\Entity\UserOrg;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ApiOrganisationController extends Controller
{
    /**
     * Get organisation data
     * @Rest\View
     * @param Organisation $org organisation id
     * @Route("/api/organisation/{org}", requirements={"org" = "\d+"}, name="get_organisation")
     * @Method({"GET"})
     * @throws NotFoundHttpException
     * @ApiDoc(output="Vrbh\SiteBundle\Entity\Organisation")
     * @return organisation
     */
    public function getOrganisationAction(Organisation $org)
    {
        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }

        return array('organisation' => $org);
    }

    /**
     * Get all products from a specific organisation
     *
     * @param Organisation $org organisation id
     * @Rest\View
     * @Route("/api/organisation/{org}/products", requirements={"org" = "\d+"}, name="get_products")
     * @Method({"GET"})
     * @throws NotFoundHttpException
     * @ApiDoc(output="Vrbh\SiteBundle\Entity\Product")
     * @return product
     */
    public function getOrganisationProductsAction(Organisation $org)
    {
        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }

        $products = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Product')
            ->findByOrganisation($org);

        return array('products' => $products);
    }

    /**
     * Create a new product for a organisation
     *
     * @param Organisation $org organisation id
     * @Route("/api/organisation/{org}/products", requirements={"org" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewProductAction(Organisation $org)
    {
        return $this->createNewPrd($org);
    }

    /**
     * Create a new product via the local API for a organisation
     *
     * @Route("/internal/api/{org}/products", requirements={"org" = "\d+"}, name="createProduct")
     * @Method({"POST"})
     * @param Organisation $org Organisation id
     * @return View
     * @throws NotFoundHttpException
     */
    public function createNewLocalProductAction(Organisation $org)
    {
        return $this->createNewPrd($org);
    }

    /**
     * Create a new organisation (Helper function)
     *
     * @param Organisation $org organisation id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return View
     */
    private function createNewPrd(Organisation $org)
    {
        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }
        $prd = new Product();
        $prd->setOrganisation($org);
        return $this->createNewProduct($prd, true);
    }

    /**
     * Create a new stock entry for a product
     * @param Organisation $org organisation id
     * @param Product $product product id
     * @Route("/api/organisation/{org}/products/{product}/stock", requirements={"org" = "\d+", "product" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewStockAction(Organisation $org, Product $product)
    {
        return $this->createNewStock($org, $product);
    }

    /**
     * Create a new stock entry for a product from the website
     * @param Organisation $org organisation id
     * @param Product $product product id
     * @Route("/internal/api/organisation/{org}/products/{product}/stock", requirements={"org" = "\d+", "product" = "\d+"}, name="createStock")
     * @Method({"POST"})
     * @return view
     */
    public function createNewInternalStockAction(Organisation $org, Product $product)
    {
        return $this->createNewStock($org, $product);
    }

    /**
     * Create a new order entry for a product
     * @param Organisation $org organisation id
     * @param Product $product product id
     * @Route("/api/organisation/{org}/products/{product}/order", requirements={"org" = "\d+", "product" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewOrderAction(Organisation $org, Product $product)
    {
        return $this->createNewOrder($org, $product);
    }

    /**
     * Create a new order entry for a product from the website
     * @param Organisation $org organisation id
     * @param Product $product product id
     * @Route("/internal/api/organisation/{org}/products/{product}/order", requirements={"org" = "\d+", "product" = "\d+"}, name="createOrder")
     * @Method({"POST"})
     * @return view
     */
    public function createNewInternalOrderAction(Organisation $org, Product $product)
    {
        return $this->createNewOrder($org, $product);
    }

    /**
     * Get all organisations. This requires ROLE_ADMIN.
     * @Rest\View
     * @Route("/api/organisation/all")
     * @Method({"GET"})
     * @ApiDoc(output="Vrbh\SiteBundle\Entity\Organisation")
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
     * @param Organisation $org organisation id
     * @Route("/api/organisation/{org}", requirements={"org" = "\d+"})
     * @Method({"DELETE"})
     * @ApiDoc()
     */
    public function deleteOrganisationAction(Organisation $org)
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
        return $this->createNewOrganisation($org, true);
    }

    /**
     * Create a new organisation from the website
     * @Route("/internal/api/organisation", name="createOrg")
     * @Method({"POST"})
     */
    public function createLocalOrganisationAction()
    {
        $org = new Organisation();
        return $this->createNewOrganisation($org, true);
    }


    /**
     * Approve a organisation request.
     *
     * @param $org
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/internal/api/organisation/{org}/requests/{request}", requirements={"org" = "\d+", "request" = "\d+"}, name="approveRequest")
     * @Method({"POST"})
     */
    public function approveLocalRequestAction(Organisation $org, UserOrgRequest $request)
    {
        return $this->approveRequest($org, $request);
    }

    /**
     * Deny a organisation request.
     *
     * @param $org
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/internal/api/organisation/{org}/requests/{request}", requirements={"org" = "\d+", "request" = "\d+"}, name="denyRequest")
     * @Method({"DELETE"})
     */
    public function denyLocalRequestAction(Organisation $org, UserOrgRequest $request)
    {
        return $this->denyRequest($org, $request);
    }

    /**
     * Send a request to join a organisation.
     *
     * @Route("/internal/api/organisation/join/", name="joinOrg")
     * @Method({"POST"})
     */
    public function joinOrgLocalRequestAction()
    {
        return $this->joinOrg();
    }

    /**
     * Approve a organisation request.
     *
     * @param $org
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/api/organisation/{org}/requests/{request}", requirements={"org" = "\d+", "request" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @Rest\View(statusCode=204)
     */
    public function approveRequestAction(Organisation $org, UserOrgRequest $request)
    {
        return $this->approveRequest($org, $request);
    }

    /**
     * Deny a organisation request.
     *
     * @param Organisation $org Organisation ID
     * @param UserOrgRequest $request Request ID
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/api/organisation/{org}/requests/{request}", requirements={"org" = "\d+", "request" = "\d+"})
     * @Method({"DELETE"})
     * @ApiDoc()
     * @Rest\View(statusCode=204)
     */
    public function denyRequestAction(Organisation $org, UserOrgRequest $request)
    {
        return $this->denyRequest($org, $request);
    }

    /**
     * Send a request to join a organisation.
     *
     * @Route("/api/organisation/join/")
     * @ApiDoc()
     * @Method({"POST"})
     */
    public function joinOrgRequestAction()
    {
        return $this->joinOrg();
    }


    /**
     * Create or update a new product
     *
     * @todo Move to use a type instead validating our self.
     * @param Product $product
     * @param boolean $new
     * @return View in case of a error.
     */
    private function createNewProduct(Product $product, $new)
    {
        $statusCode = $new ? 201 : 204;

        $error = array();

        $request = $this->get('request');
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $orderNumber = $request->request->get('orderNumber');
        $ean = $request->request->get('ean');
        $stockUnit = $request->request->get('stockUnit');
        $orderUnit = $request->request->get('orderUnit');
        $minStock = $request->request->get('minStock');
        $maxStock = $request->request->get('maxStock');

        $user = $this->container->get('security.context')->getToken()->getUser();

        if (empty($name))
            $error[] = 'Name is empty';
        if (empty($description))
            $error[] = 'Description is empty';
        if (empty($minStock))
            $error[] = 'Min stock is empty';
        if (empty($maxStock))
            $error[] = 'Max stock is empty';
        if (empty($stockUnit))
            $error[] = 'Stock unit is empty';
        if (empty($orderUnit))
            $error[] = 'Order unit is empty';

        if (!sizeof($error)) {
            $product->setName($name);
            $product->setDescription($description);
            $product->setOrderNumber($orderNumber);
            $product->setEan($ean);
            $product->setStockUnit($stockUnit);
            $product->setOrderUnit($orderUnit);
            $product->setMinStock($minStock);
            $product->setMaxStock($maxStock);

            $em = $this->container->get('doctrine')->getManager();
            $em->persist($product);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('X-new-id', $product->getId());
                $response->headers->set('Location',
                    $this->generateUrl(
                        'get_products', array('id' => $product->getId(), 'org' => $product->getOrganisation()->getId()),

                        true // absolute
                    )
                );
            }
            return $response;

        }
        return View::create(array('error' => $error), 400);
    }

    /**
     * Create a new organisation
     *
     * @param Organisation $organisation
     * @param boolean $new
     * @return View|Response
     */
    private function createNewOrganisation(Organisation $organisation, $new)
    {
        $statusCode = $new ? 201 : 204;

        $request = $this->get('request');
        $name_value = $request->request->get('name');

        $user = $this->container->get('security.context')->getToken()->getUser();


        if (!empty($name_value)) {
            $organisation->setCreated($user);
            $organisation->setName($name_value);
            $organisation->setCreator($user);

            $em = $this->container->get('doctrine')->getManager();

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
                $response->headers->set('X-new-id', $organisation->getId());
                $response->headers->set('Location',
                    $this->generateUrl(
                        'get_organisation', array('id' => $organisation->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create(array('error' => array('Name is empty')), 400);
    }

    /**
     * Create a new stock item for the chosen product.
     *
     * @param $org
     * @param $product
     * @throws NotFoundHttpException
     * @return Response
     */
    private function createNewStock(Organisation $org, Product $product)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $request = $this->get('request');

        if (!($product instanceof Product) || $product->getOrganisation()->getId() != $org->getId()) {
            throw new NotFoundHttpException('Product not found');
        }

        $stock = new Stock();
        $stock->setAmount((int)$request->request->get('amount'));
        $stock->setProduct($product);
        $product->addStock($stock);
        $product->setCurrentStock($stock);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($stock);
        $em->persist($product);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(201);

        $response->headers->set('X-new-id', $stock->getId());

        return $response;
    }

    /**
     * Create a new order item for the chosen product.
     *
     * @param $org
     * @param $product
     * @throws NotFoundHttpException
     * @return Response
     */
    private function createNewOrder(Organisation $org, Product $product)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $request = $this->get('request');

        if (!($product instanceof Product) || $product->getOrganisation()->getId() != $org->getId()) {
            throw new NotFoundHttpException('Product not found');
        }

        $order = new Order();
        $order->setAmount((int)$request->request->get('amount'));
        $order->setProduct($product);
        $product->addOrder($order);

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($order);
        $em->persist($product);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(201);

        $response->headers->set('X-new-id', $order->getId());

        return $response;
    }

    /**
     * Create a new request for joining a organisation.
     *
     * @todo: Check if a user is already in a org before creating the request.
     * @return View|Response
     */
    private function joinOrg()
    {
        $request = $this->get('request');
        $name_value = $request->request->get('name');

        $user = $this->container->get('security.context')->getToken()->getUser();

        $organisation = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->findByName($name_value)[0];

        if (!empty($name_value) && $organisation instanceof Organisation) {

            $em = $this->container->get('doctrine')->getManager();


            $userrequest = new UserOrgRequest();
            $userrequest->setUser($user);
            $userrequest->setOrganisation($organisation);

            $em->persist($userrequest);
            $em->flush();

            foreach ($organisation->getUsers() as $usr) {
                if ($usr->getType() == 'admin') {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Request to join organisation (' . $organisation->getName() . ')')
                        ->setFrom('paul@sohier.me')
                        ->setTo($usr->getUser()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'VrbhSiteBundle:Email:join.txt.twig',
                                array('userorg' => $userrequest, 'user' => $usr)
                            )
                        );
                    $this->get('mailer')->send($message);
                }
            }
            $response = new Response();
            $response->setStatusCode(201);

            $response->headers->set('X-new-id', $userrequest->getId());

            return $response;
        }

        return View::create(array('error' => array('Name is empty or organisation doesnt exists.')), 400);
    }

    /**
     * Approve a request for a organisation.
     *
     * @param $org
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function approveRequest(Organisation $org, UserOrgRequest $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$org->checkAllowed($user))
        {
            throw new NotFoundHttpException('Organisation not found');
        }

        if (!$request instanceof UserOrgRequest || $request->getOrganisation()->getId() != $org->getId()) {
            throw new NotFoundHttpException('request not found');
        }

        $users = $org->getUsers()->toArray();
        // Check if a user is already a in a org.
        foreach ($users as $usr) {
            if ($usr->getUser()->getId() == $request->getUser()->getId()) {
                throw new NotFoundHttpException('Invalid request, already member!');
            }
        }
        if ($user->getId() == $request->getUser()->getId())
        {
            // Don't allow user to approve himself.
            // This should theoreticlly not be possible, as you cant be twice on a org.
            throw new NotFoundHttpException('Invalid request.');
        }
        $userorg = new UserOrg();
        $userorg->setUser($request->getUser());
        $userorg->setOrganisation($request->getOrganisation());
        $userorg->setType('user'); // Always set to user in first case.

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($userorg);
        $em->remove($request);
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Request to join organisation (' . $org->getName() . ') approved')
            ->setFrom('paul@sohier.me')
            ->setTo($userorg->getUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'VrbhSiteBundle:Email:approved.txt.twig',
                    array('userorg' => $userorg)
                )
            );
        $this->get('mailer')->send($message);

        $response = new Response();
        $response->setStatusCode(201);

        $response->headers->set('X-new-id', $userorg->getId());

        return $response;
    }

    /**
     * Deny a request for a organisation
     *
     * @param \Vrbh\SiteBundle\Entity\Organisation $org
     * @param \Vrbh\SiteBundle\Entity\UserOrgRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function denyRequest(Organisation $org, UserOrgRequest $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!$org->checkAllowed($user))
        {
            throw new NotFoundHttpException('Organisation not found');
        }

        if (!$request instanceof UserOrgRequest || $request->getOrganisation()->getId() != $org->getId()) {
            throw new NotFoundHttpException('request not found');
        }
        if ($user->getId() == $request->getUser()->getId())
        {
            throw new NotFoundHttpException('Invalid request.');
        }

        $em = $this->container->get('doctrine')->getManager();
        $em->remove($request);
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Request to join organisation (' . $org->getName() . ') denied')
            ->setFrom('paul@sohier.me')
            ->setTo($request->getUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'VrbhSiteBundle:Email:denied.txt.twig',
                    array('userorg' => $request)
                )
            );
        $this->get('mailer')->send($message);

        $response = new Response();
        $response->setStatusCode(204);

        return $response;
    }
} 