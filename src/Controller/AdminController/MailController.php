<?php


namespace App\Controller\AdminController;


use Core\Controller\FrontController;
use Core\Model\Model;

class MailController extends FrontController
{

    private $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {


        $data = $this->database->read('mail');

        $response = [ 'path' => 'AdminView/Pages/mail.twig',
            'data' => [ 'mail' => $data]
        ];

        return $response;
    }

}