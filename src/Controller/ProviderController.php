<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Entity\Provider;
use App\Entity\Bundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * @Route("/providers", name="providers")
     */
    public function index()
    {
      $repository = $this->getDoctrine()->getRepository(Provider::class);
      $providers = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Platform::class);
      $platform = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Bundle::class);
      $products = $repository->findAll();

      return $this->render('provider/index.html.twig', [
          'page_title' => 'Providers',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'product_title' => 'Bundles',
          'products' => $products,
          'providers' => $providers
      ]);
    }

    /**
     * @Route("/provider/{id}", name="provider")
     */

     public function single_provider( $id )
     {

       $provider = $this->getDoctrine()
        ->getRepository(Provider::class)
        ->find($id);

        $repository = $this->getDoctrine()->getRepository(Bundle::class);
          $products = $repository->findBy(
              ['provider' => $id]
          );

          if(!$provider) {

            return $this->render('inc/error.html.twig', [
                'page_title' => '404 Page Not Found',
                'message' => 'The Provider does not exist !!!'
            ]);

          } else {

             return $this->render('provider/single.html.twig', [
                 'page_title' => 'Provider',
                 'provider' => $provider,
                 'products' => $products
             ]);

          }

     }


}
