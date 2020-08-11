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
     * @Route("/bundle", name="bundle")
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
          'project_name' => 'Symfony Project',
          'page_title' => 'Bundles',
          'product_list_title' => 'Top Bundles',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'providers_title' => 'Providers',
          'providers' => $providers,
          'products' => $products,
          'copy_right_text' => 'Copyright © Symfony Project 2020'
      ]);
    }

    /**
     * @Route("/bundle/{id}", name="single_bundle")
     */

     public function single_bundle( $id )
     {

       $product = $this->getDoctrine()
        ->getRepository(Bundle::class)
        ->find($id);

       return $this->render('bundle/single.html.twig', [
           'project_name' => 'Symfony Project',
           'page_title' => 'Bundle',
           'product' => $product,
           'copy_right_text' => 'Copyright © Symfony Project 2020'
       ]);

     }


}
