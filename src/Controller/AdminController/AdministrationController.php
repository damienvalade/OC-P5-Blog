<?php


namespace App\Controller\AdminController;

use Core\Model\Model;

class AdministrationController
{
    protected $database;
    protected $data;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {

        $this->data = $this->database->queryMD('SELECT * FROM view');

        $response = [ 'path' => 'AdminView/Pages/administration.twig',
            'data' => ['view' => $this->data]
        ];

        return $response;
    }
}