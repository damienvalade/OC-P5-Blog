<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;

class HomeController extends FrontController
{
    public function indexAction()
    {
        $response = [ 'path' => 'PublicView/Pages/home.twig',
            'data' => []
        ];

        return $response;
    }
}