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
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $data2;

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

        $this->data = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and page = 'articles'");
        $this->data2 = $this->database->queryMD("SELECT * FROM view WHERE day = '$date' and url = 'home'");

        $response = [ 'path' => 'AdminView/Pages/administration.twig',
            'data' => [
                'view' => $this->data,
                'view2' => $this->data2
            ]
        ];

        return $response;
    }
}