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
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();

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
