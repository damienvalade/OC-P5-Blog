<?php

namespace App\Controller\AdminController;

use Core\Controller\FrontController;
use Core\Controller\Session\Session;

class HomeController extends FrontController
{
    public function indexAction()
    {
        if( Session::isLogged())
        {
            if( Session::isAdmin() === true){

                $response = [ 'path' => 'AdminView/Pages/home.twig',
                    'data' => [],
                ];



            }else{
                $response = [ 'path' => $this->unauthorized(),
                    'data' => [],
                ];
            }
        }else{
            $response = [ 'path' => $this->unauthorized(),
                'data' => [],
            ];
        }

        return $response;
    }
}