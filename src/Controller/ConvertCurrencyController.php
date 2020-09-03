<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use App\Service\CurrencyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class ConvertCurrencyController
{
      public function __construct(EntityManagerInterface $em) {
          $this->em = $em;
      }

      /**
       * @Route("/updateCurrency", name="updateCurrencyAjax")
       */

       public function updateCurrency( Request $request, CurrencyService $convertCurrency ) : Response {

         $to = $request->query->get('to');

         $response = $convertCurrency->initCookie($request , $to);

         return $response;

       }

      /**
       * @Route("/getCurrencyRates", name="getCurrencyRatesAjax")
       */

       public function getCurrencyRates(CurrencyService $convertCurrency) {

         $rates = $convertCurrency->getRates();

         return new JsonResponse(array(
             'status' => 'OK',
             'rates' => $rates['data']),
         200);

       }

}
