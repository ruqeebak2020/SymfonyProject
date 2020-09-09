<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\Bundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CurrencyService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( Request $request, CurrencyService $currencyService )
    {

        $error_msgs = '';
        $response = $currencyService->initCookie( $request );
        $currency_code = $currencyService->getCurrencyCode( $response );
        $symbol = $currencyService->getCurrencySymbol( $currency_code );

        $repository = $this->getDoctrine()->getRepository(Provider::class);
        $providers = $repository->findBy(array(),array('id'=>'ASC'),4,0);

        $repository = $this->getDoctrine()->getRepository(Bundle::class);
        $products = $repository->findBy(array(),array('id'=>'ASC'),4,0);

        $defaultCurrency = $currencyService->getDefaultCurrency();

        if($defaultCurrency !== $currency_code) {

            $rates =  $currencyService->getRates();

            if($rates['status'] == "FAIL") {

              $currency_code = $defaultCurrency;
              $symbol = $currencyService->getCurrencySymbol( $currency_code );
              $error_msgs .= ( isset( $rates['data']['error']['info'] ) ) ? $rates['data']['error']['info'] : '';

            } else {

                  foreach ($products as $product) {

                        $oldPrice = $product->getPrice();

                        if($currency_code == 'EUR') {
                          $updatePrice = $oldPrice / $rates['data'][$defaultCurrency];
                        } else {
                          $updatePrice1 = $oldPrice / $rates['data'][$defaultCurrency];
                          $updatePrice = $updatePrice1 * $rates['data'][$currency_code];
                        }

                        $product->setPrice( round($updatePrice, 2) );
                  }

            }

        }

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
            'currency_code' => $currency_code,
            'symbol' => $symbol,
            'errors' => $error_msgs,
        ], $response);
    }
}
