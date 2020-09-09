<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class CurrencyService
{

    public function initCookie( Request $request, $updateCurrency = NULL ) : Response {

        $response = new Response();

        if( \is_null( $updateCurrency ) ) {

          $currency_code = $request->cookies->get( 'currency_code' );

          if( \is_null( $currency_code ) ) {
            $response->headers->setCookie( new Cookie( 'currency_code', $this->getDefaultCurrency() ) );
          } else {
            $response->headers->setCookie( new Cookie( 'currency_code', $currency_code ) );
          }

        } else {

          $response->headers->setCookie( new Cookie( 'currency_code', $updateCurrency ) );

        }

        return $response;
      }

      public function getRates() {

        if( 0 >= strlen( trim( $this->getAPIkey() ) ) || 0 >= strlen( trim( $this->getDomain() ) ) || 0 >= strlen( trim( $this->getDefaultCurrency() ) ) ) {

              $error_info = array(
                "code" => 101,
                "type" => "missing_access_key",
                "info" => "You have not supplied an API Access Key. Please provide Fixer API key in project .ENV file at line number 37."
              );
              $data = array("success"=> false, "error"=>$error_info );

             return [
              'status' => 'FAIL',
              'data'   => $data
            ];

        }

         //Create Guzzle Object
         $client = new Client();
         $endpoint = 'latest';

        $response = $client->request('GET',$this->getDomain().'/'.$endpoint.'?access_key='.$this->getAPIkey());
        $body = $response->getBody();
        $json = (string) $body;

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        if( $exchangeRates['success'] == 1){
          return array(
              'status' => 'OK',
              'data' => $exchangeRates['rates']);
        } else {
          return array(
              'status' => 'FAIL',
              'data' => $exchangeRates);
        }

      }

      public function getCurrencyCode( $response ) {

        $currency_code = $this->getDefaultCurrency();

        $cookies = $response->headers->getCookies();
        foreach ($cookies as $cookie) {
          if($cookie->getName() == 'currency_code') {
            $currency_code = $cookie->getValue();
          }
        }

        return $currency_code;

      }

      public function getCurrencySymbol( $currency_code ) {

        if($currency_code == 'USD') {
          return '$';
        } else if($currency_code == 'EUR') {
          return '€';
        } else if($currency_code == 'ZAR') {
          return 'R';
        }

      }

      private function getDomain() {
        return $_ENV['FIXER_API_URL'];
      }

      private function getAPIkey() {
        return $_ENV['FIXER_API_KEY'];
      }

      public function getDefaultCurrency() {
        return $_ENV['DEFAULT_CURRENCY_CODE'];
      }

}
?>
