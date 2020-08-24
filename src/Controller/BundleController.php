<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Entity\Provider;
use App\Entity\Bundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BundleController extends AbstractController
{
    /**
     * @Route("/bundles", name="bundles")
     */
    public function index()
    {
      $repository = $this->getDoctrine()->getRepository(Provider::class);
      $providers = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Platform::class);
      $platform = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Bundle::class);
      $products = $repository->findAll();

      return $this->render('shop/index.html.twig', [
          'page_title' => 'Bundles',
          'product_list_title' => 'Top Bundles',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'providers_title' => 'Providers',
          'providers' => $providers,
          'products' => $products
      ]);
    }

    /**
     * @Route("/bundle/{id}", name="bundle")
     */

     public function single_bundle( $id )
     {

       $product = $this->getDoctrine()
        ->getRepository(Bundle::class)
        ->find($id);

        if(!$product) {
        //  throw $this->createNotFoundException('The Bundle does not exist!!!');
          return $this->render('inc/error.html.twig', [
              'page_title' => '404 Page Not Found',
              'message' => 'The Bundle does not exist !!!'
          ]);

        } else {
          return $this->render('bundle/single.html.twig', [
              'page_title' => 'Bundle',
              'product' => $product
          ]);
        }

     }


}
