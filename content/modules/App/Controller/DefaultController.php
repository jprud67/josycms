<?php

namespace App\Controller;

use Josy\Controller\Controller;
use Josy\Entity\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\LeapYear;

class DefaultController extends Controller
{
    /**
     * @return Response
     * @internal param Request $request
     */
    public function indexAction()
    {
        $em=$this->em;
        //dump($em);die();
        $products = $em->getRepository(Product::class)->findAll();
         return $this->render("Default/index.html.twig",array(
            "products"=>$products,
        ));

    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $em=$this->em;
        $message=null;
        if (!empty($request->request->get('name'))){
            //dump($request->request);die();
            $name=$request->request->get('name');
            $product=new Product();
            $product->setName($name);
            $em->persist($product);
            $em->flush();
            $message='Add success';
        }
        return $this->render("Default/new.html.twig",array(
            "message"=>$message,
        ));

    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request,$id)
    {

        $em=$this->em;
        $message=null;
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product){
            return new RedirectResponse("/");
        }
        if (!empty($request->request->get('name'))){
            $name=$request->request->get('name');
            $product->setName($name);
            $em->flush();
            return new RedirectResponse("/");
        }
        return $this->render("Default/edit.html.twig",array(
           'product' => $product
        ));

    }
    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request,$id)
    {

        $em=$this->em;
        $message=null;
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product){
            return new RedirectResponse("/");
        }
        $em->remove($product);
        $em->flush();

        return new RedirectResponse("/");
    }
}
