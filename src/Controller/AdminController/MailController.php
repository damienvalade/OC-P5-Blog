<?php


namespace App\Controller\AdminController;


use Core\Controller\FrontController;
use Core\Model\Model;

/**
 * Class MailController
 * @package App\Controller\AdminController
 */
class MailController extends FrontController
{

    /**
     * @var Model
     */
    private $database;

    /**
     * MailController constructor.
     */
    public function __construct()
    {
        $this->database = new Model();
    }

    /**
     * @return array
     */
    public function viewAction()
    {
        $data = $this->database->read('mail');

        $response = [ 'path' => 'AdminView/Pages/mail.twig',
            'data' => [ 'mail' => $data]
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        $id_mail = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->database->delete('mail', $id_mail);

        return self::viewAction();
    }
}
