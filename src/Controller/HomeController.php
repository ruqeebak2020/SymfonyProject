<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Bundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

    $repository = $this->getDoctrine()->getRepository(Provider::class);
    $providers = $repository->findAll();

    $repository = $this->getDoctrine()->getRepository(Bundle::class);
    $products = $repository->findAll();

    return $this->render('home/index.html.twig', [
        'page_title' => 'Home',
        'banner_title' => 'A Warm Welcome!',
        'banner_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.',
        'banner_CTA_text' => 'Call to action!',
        'banner_CTA_link' => '#',
        'provider_list_title' => 'Top Providers',
        'providers' => $providers,
        'product_list_title' => 'Top Bundle',
        'products' => $products,
    ]);
    }
}
