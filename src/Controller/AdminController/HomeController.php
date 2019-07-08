<?php

namespace App\Controller\AdminController;

use App\Controller\ErrorsController\ErrorsController;
use Core\Controller\FrontController;

/**
 * Class HomeController
 * @package App\Controller\AdminController
 */
class HomeController extends FrontController
{

    /**
     * @var array
     */
    protected $response;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $errors = new ErrorsController();

        if ($this->cookies->dataJWT('user', 'level') === false) {
            $this->response = ['path' => $errors->unauthorized(),
                'data' => []
            ];
        }
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        if (!isset($this->response)) {
            $this->response = [ 'path' => 'AdminView/Pages/home.twig',
                    'data' => [],
                ];
        }

        return $this->response;
    }
}
