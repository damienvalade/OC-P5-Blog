<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\View\View;

/**
 * Class HomeController
 * @package App\Controller\PublicController
 */
class HomeController extends FrontController
{
    /**
     * @var View
     */
    protected $view;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->view = new View();

        $this->view->addView();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $response = [ 'path' => 'PublicView/Pages/home.twig',
            'data' => []
        ];

        return $response;
    }
}

