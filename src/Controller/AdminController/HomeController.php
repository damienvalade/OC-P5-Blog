<?php

namespace App\Controller\AdminController;

use Core\Controller\FrontController;
use Core\Controller\Cookies\Cookies;

class HomeController extends FrontController
{
    protected $cookies;

    public function __construct()
    {
     $this->cookies = new Cookies();
    }

    public function indexAction()
    {
        $response = [ 'path' => $this->unauthorized(),
            'data' => [],
        ];

        if( $this->cookies->dataJWT('user','id') !== false )
        {
                $response = [ 'path' => 'AdminView/Pages/home.twig',
                    'data' => [],
                ];

        }

        return $response;
    }
}