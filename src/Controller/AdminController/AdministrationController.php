<?php


namespace App\Controller\AdminController;

use Core\Model\Model;

/**
 * Class AdministrationController
 * @package App\Controller\AdminController
 */
class AdministrationController
{
    /**
     * @var Model
     */
    protected $database;

    /**
     * AdministrationController constructor.
     */
    public function __construct()
    {
        $this->database = new Model();
    }

    /**
     * @return array
     */
    public function indexAction()
    {

        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d');

        $page_articles = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and page = 'articles'");
        $page_all = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and url = 'home'");

        $response = [ 'path' => 'AdminView/Pages/administration.twig',
            'data' => [
                'view' => $page_articles,
                'view2' => $page_all
            ]
        ];

        return $response;
    }
}