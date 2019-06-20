<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\View\View;

class HomeController extends FrontController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();

        $this->view->addView();
    }

    public function indexAction()
    {
        $response = [ 'path' => 'PublicView/Pages/home.twig',
            'data' => []
        ];

        return $response;
    }
}