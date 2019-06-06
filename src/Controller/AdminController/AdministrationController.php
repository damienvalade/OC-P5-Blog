<?php


namespace App\Controller\AdminController;

use Core\Model\Model;

class AdministrationController
{
    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {

        $view = $this->database->query('SELECT * FROM view');

        $dashboard = fopen(dirname(dirname(dirname(__dir__))) . '/public/json/dashboard.json', 'w+');

        $data = json_encode($view);

        fwrite($dashboard, $data);
        fclose($dashboard);

        $response = [ 'path' => 'AdminView/Pages/administration.twig',
            'data' => [],
        ];

        return $response;
    }
}