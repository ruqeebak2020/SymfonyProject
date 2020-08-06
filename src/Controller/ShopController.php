<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Entity\Provider;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
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
          'page_title' => 'Shop',
          'product_list_title' => 'Top Bundle',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'providers_title' => 'Providers',
          'providers' => $providers,
          'products' => $products,
          'copy_right_text' => 'Copyright © Symfony Project 2020'
      ]);
      }

}
