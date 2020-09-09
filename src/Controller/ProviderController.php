<?php

namespace App\Controller;

use App\Entity\Platform;
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

class ProviderController extends AbstractController
{
    /**
     * @Route("/providers", name="providers")
     */
    public function index( Request $request, CurrencyService $currencyService )
    {

      $error_msgs = '';
      $response = $currencyService->initCookie( $request );
      $currency_code = $currencyService->getCurrencyCode( $response );
      $symbol = $currencyService->getCurrencySymbol( $currency_code );

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
          'providers' => $providers,
          'currency_code' => $currency_code,
          'symbol' => $symbol,
          'errors' => $error_msgs,
      ]);
    }

    /**
     * @Route("/provider/{id}", name="provider")
     */

     public function provider( $id, Request $request, CurrencyService $currencyService )
     {

       $error_msgs = '';
       $response = $currencyService->initCookie( $request );
       $currency_code = $currencyService->getCurrencyCode( $response );
       $symbol = $currencyService->getCurrencySymbol( $currency_code );

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
                'message' => 'The Provider does not exist !!!',
                'currency_code' => $currency_code,
                'symbol' => $symbol,
                'errors' => $error_msgs,
            ]);

          } else {

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

             return $this->render('provider/single.html.twig', [
                 'page_title' => 'Provider',
                 'provider' => $provider,
                 'products' => $products,
                 'currency_code' => $currency_code,
                 'symbol' => $symbol,
                 'errors' => $error_msgs,
             ]);

          }

     }


}
