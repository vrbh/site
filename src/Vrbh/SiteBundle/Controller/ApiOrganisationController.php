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
use Vrbh\SiteBundle\Entity\Stock;
use Vrbh\SiteBundle\Entity\Organisation;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vrbh\SiteBundle\Entity\UserOrg;

class ApiOrganisationController extends Controller
{
    /**
     * Get organisation data
     * @Rest\View
     * @param int $id organisation id
     * @Route("/api/organisation/{id}", requirements={"id" = "\d+"}, name="get_organisation")
     * @Method({"GET"})
     * @throws NotFoundHttpException
     * @ApiDoc()
     * @return organisation
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
     * Get all products from a specific organisation
     *
     * @param int $org organisation id
     * @Rest\View
     * @Route("/api/organisation/{org}/products", requirements={"org" = "\d+"}, name="get_products")
     * @Method({"GET"})
     * @throws NotFoundHttpException
     * @ApiDoc()
     * @return product
     */
    public function getOrganisationProductsAction($org)
    {
        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->find($org);

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
     * @param int $org organisation id
     * @Route("/api/organisation/{org}/products", requirements={"org" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewProductAction($org)
    {
        return $this->createNewPrd($org);
    }

    /**
     * Create a new product via the local API for a organisation
     *
     * @Route("/internal/api/{org}/products", requirements={"org" = "\d+"}, name="createProduct")
     * @Method({"POST"})
     * @param int $org Organisation id
     * @return View
     * @throws NotFoundHttpException
     */
    public function createNewLocalProductAction($org)
    {
        return $this->createNewPrd($org);
    }


    /**
     * Create a new organisation (Helper function)
     *
     * @param int $org organisation id
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function createNewPrd($org)
    {
        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->find($org);

        if (!$org instanceof Organisation) {
            throw new NotFoundHttpException('Organisation not found');
        }
        $prd = new Product();
        $prd->setOrganisation($org);
        return $this->createNewProduct($prd, true);
    }

    /**
     * Create a new stock entry for a product
     * @param int $org organisation id
     * @param int $product product id
     * @Route("/api/organisation/{org}/products/{product}/stock", requirements={"org" = "\d+", "product" = "\d+"})
     * @Method({"POST"})
     * @ApiDoc()
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewStockAction($org, $product)
    {
        return $this->createNewStock($org, $product);
    }

    /**
     * Create a new stock entry for a product from the website
     * @param int $org organisation id
     * @param int $product product id
     * @Route("/internal/api/organisation/{org}/products/{product}/stock", requirements={"org" = "\d+", "product" = "\d+"}, name="createStock")
     * @Method({"POST"})
     * @throws NotFoundHttpException
     * @return view
     */
    public function createNewInternalStockAction($org, $product)
    {
        return $this->createNewStock($org, $product);
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
     * @param int $org organisation id
     * @Route("/api/organisation/{org}", requirements={"org" = "\d+"})
     * @Method({"DELETE"})
     * @ApiDoc()
     */
    public function deleteOrganisationAction($org)
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
    private function createNewStock($org, $product)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $request = $this->get('request');

        $org = $this->getDoctrine()
            ->getRepository('VrbhSiteBundle:Organisation')
            ->find($org);

        if (!($org instanceof Organisation) || !$org->checkAllowed($user)) {
            throw new NotFoundHttpException('Organisation not found');
        }
        $product = $this->getDoctrine()->getRepository('VrbhSiteBundle:Product')->find($product);

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
} 