<?php

namespace App\Controller\AdminController;

use Core\Controller\FrontController;
use Core\Session\Session;

class HomeController extends FrontController
{
    public function indexAction()
    {
        if( Session::isLogged())
        {
            if( Session::isAdmin() === true){



            }else{
                exit($this->unauthorized());
            }
        }else{
            exit($this->unauthorized());
        }
    }
}