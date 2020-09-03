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

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
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

      $defaultCurrency = $currencyService->getDefaultCurrency();

      if($defaultCurrency !== $currency_code) {

          $rates =  $currencyService->getRates();

          if($rates['status'] == "FAIL") {

            $currency_code = $defaultCurrency;
            $symbol = $currencyService->getCurrencySymbol( $currency_code );
            $error_msgs .= $rates['data']['error']['info'];

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

      return $this->render('shop/index.html.twig', [
          'page_title' => 'Shop',
          'product_list_title' => 'Top Bundle',
          'platforms_title' => 'Platforms',
          'platforms' => $platform,
          'providers_title' => 'Providers',
          'providers' => $providers,
          'products' => $products,
          'currency_code' => $currency_code,
          'symbol' => $symbol,
          'errors' => $error_msgs,
      ], $response);

      }

}
