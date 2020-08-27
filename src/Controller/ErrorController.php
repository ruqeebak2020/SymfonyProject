<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function index()
    {
        return $this->render('error/index.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }

    public function show(\Throwable $exception)
    {
       return $this->render('error/index.html.twig', [
           'error_code' => method_exists( $exception, 'getStatusCode' ) ? $exception->getStatusCode(): 0
       ]);
    }


}
