<?php

namespace App\Controller\AdminController;

use Core\Controller\FrontController;
use Core\Controller\Cookies\Cookies;

/**
 * Class HomeController
 * @package App\Controller\AdminController
 */
class HomeController extends FrontController
{
    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
     $this->cookies = new Cookies();
    }

    /**
     * @return array
     */
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
