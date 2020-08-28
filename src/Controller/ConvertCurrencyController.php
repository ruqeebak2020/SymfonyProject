<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BundleRepository;
use App\Entity\Bundle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class ConvertCurrencyController
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/convertCurrency", name="convertCurrencyAjax")
     */

   public function convertCurrency(){

        // set API Endpoint and API key
        $request = Request::createFromGlobals();
        $access_key = $request->query->get('access_key');

        //Create Guzzle Object
         $client = new Client();

        $response = $client->request('GET', 'http://data.fixer.io/api/latest?access_key='.$access_key.'');
        $body = $response->getBody();
        $json = (string) $body;

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        if( $exchangeRates['success'] == 1){
            //Process id Get Sucess is equal to 1

            $from =  $request->query->get('from');
            $to =  $request->query->get('to');
            $amount =  $request->query->get('amount');

            if($to == 'EUR') {
              $updateamount = $amount / $exchangeRates['rates'][$from];
            } else {
              $updateamount1 = $amount / $exchangeRates['rates'][$from];
              $updateamount = $updateamount1 * $exchangeRates['rates'][$to];
            }

            return new JsonResponse(array(
                'status' => 'OK',
                'message' =>'success',
                'updateAmount' => $updateamount),
            200);

        } else {
            //Return Error array of the API
            return new JsonResponse(array(
                'status' => 'OK',
                'message' =>$exchangeRates),
            200);

        }
    }

}
