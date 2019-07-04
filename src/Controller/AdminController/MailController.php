<?php


namespace App\Controller\AdminController;


use App\Controller\ErrorsController\ErrorsController;
use App\Model\AdminModel\MailModel;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;

/**
 * Class MailController
 * @package App\Controller\AdminController
 */
class MailController extends FrontController
{

    /**
     * @var Model
     */
    protected $database;
    protected $response;
    protected $cookies;

    /**
     * MailController constructor.
     */
    public function __construct()
    {
        $this->database = new MailModel();
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

            $data = $this->database->read('mail');

            $this->response = ['path' => 'AdminView/Pages/mail.twig',
                'data' => ['mail' => $data]
            ];

        }
        return $this->response;
    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        if (!isset($this->response)) {

            $id_mail = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $this->database->delete('mail', $id_mail);

        }

        return self::indexAction();
    }
}
