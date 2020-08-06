<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Entity\Provider;
use App\Entity\Product;
use App\Entity\Software;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * @Route("/provider", name="provider")
     */
    public function index()
    {
      $repository = $this->getDoctrine()->getRepository(Provider::class);
      $providers = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Platform::class);
      $platform = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Product::class);
      $products = $repository->findAll();

      return $this->render('provider/index.html.twig', [
          'project_name' => 'Symfony Project',
          'page_title' => 'Providers',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'product_title' => 'Products',
          'products' => $products,
          'providers' => $providers,
          'copy_right_text' => 'Copyright © Symfony Project 2020'
      ]);
    }

    /**
     * @Route("/provider/{id}", name="single_provider")
     */

     public function single_provider( $id )
     {

       $provider = $this->getDoctrine()
        ->getRepository(Provider::class)
        ->find($id);

        $repository = $this->getDoctrine()->getRepository(Product::class);
          $products = $repository->findBy(
              ['Provider' => $id]
          );

       return $this->render('provider/single.html.twig', [
           'project_name' => 'Symfony Project',
           'page_title' => 'Provider',
           'provider' => $provider,
           'products' => $products,
           'copy_right_text' => 'Copyright © Symfony Project 2020'
       ]);

     }


}
