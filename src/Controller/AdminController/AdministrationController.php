<?php


namespace App\Controller\AdminController;

use Core\Model\Model;

class AdministrationController
{
    protected $database;
    protected $data;
    protected $data2;

    public function __construct()
    {
        $this->database = new Model();
    }

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