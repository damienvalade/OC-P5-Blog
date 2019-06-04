<?php

namespace App\Controller\AdminController;

use Core\Controller\FrontController;
use Core\Controller\Session\Session;

class HomeController extends FrontController
{
    protected $session;

    public function __construct()
    {
     $this->session = new Session();
    }

    public function indexAction()
    {
        $response = [ 'path' => $this->unauthorized(),
            'data' => [],
        ];

        if( $this->session->isLogged() && $this->session->isAdmin() === true)
        {
                $response = [ 'path' => 'AdminView/Pages/home.twig',
                    'data' => [],
                ];

        }

        return $response;
    }
}