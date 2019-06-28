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

    public function viewAction()
    {
        $data = $this->database->read('mail');

        $response = [ 'path' => 'AdminView/Pages/mail.twig',
            'data' => [ 'mail' => $data]
        ];

        return $response;
    }

    public function deleteAction()
    {
        $id_mail = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->database->delete('mail', $id_mail);

        return self::viewAction();
    }

}