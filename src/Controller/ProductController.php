<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Entity\Provider;
use App\Entity\Product;
use App\Entity\Software;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
      $repository = $this->getDoctrine()->getRepository(Provider::class);
      $providers = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Platform::class);
      $platform = $repository->findAll();

      $repository = $this->getDoctrine()->getRepository(Product::class);
      $products = $repository->findAll();

      return $this->render('shop/index.html.twig', [
          'project_name' => 'Symfony Project',
          'page_title' => 'Products',
          'product_list_title' => 'Top Bundle',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'providers_title' => 'Providers',
          'providers' => $providers,
          'products' => $products,
          'copy_right_text' => 'Copyright © Symfony Project 2020'
      ]);
    }


    /**
     * @Route("/product/{id}", name="single_product")
     */

     public function single_product( $id )
     {

       $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

        $repository = $this->getDoctrine()->getRepository(Software::class);
          $softwares = $repository->findBy(
              ['Product' => $id]
          );

       return $this->render('product/single.html.twig', [
           'project_name' => 'Symfony Project',
           'page_title' => 'Product',
           'product' => $product,
           'softwares' => $softwares,
           'copy_right_text' => 'Copyright © Symfony Project 2020'
       ]);

     }


}
