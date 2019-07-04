<?php


namespace App\Controller\AdminController;

use App\Controller\ErrorsController\ErrorsController;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;
use Core\Model\Model;

/**
 * Class AdministrationController
 * @package App\Controller\AdminController
 */
class AdministrationController extends FrontController
{
    /**
     * @var Model
     */
    protected $database;
    protected $cookies;
    protected $response;

    /**
     * AdministrationController constructor.
     */
    public function __construct()
    {
        $this->database = new Model();
        $this->cookies = new Cookies();
        $errors = new ErrorsController();

        if ($this->cookies->dataJWT('user', 'level') > 1 || $this->cookies->dataJWT('user', 'level') === false) {
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

            date_default_timezone_set('Europe/Paris');
            $date = date('Y-m-d');

            $page_articles = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and page = 'articles'");
            $page_all = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and url = 'home'");

            $this->response = ['path' => 'AdminView/Pages/administration.twig',
                'data' => [
                    'view' => $page_articles,
                    'view2' => $page_all
                ]
            ];
        }

        return $this->response;
    }
}
