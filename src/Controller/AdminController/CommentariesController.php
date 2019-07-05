<?php


namespace App\Controller\AdminController;


use App\Controller\ErrorsController\ErrorsController;
use App\Model\AdminModel\CommentariesModel;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;

/**
 * Class CommentariesController
 * @package App\Controller\AdminController
 */
class CommentariesController extends FrontController
{

    /**
     * @var CommentariesModel
     */
    protected $database;
    /**
     * @var Cookies
     */
    protected $cookies;
    /**
     * @var array
     */
    protected $response;

    /**
     * CommentariesController constructor.
     */
    public function __construct()
    {
        $this->database = new CommentariesModel();
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
            $articles_commentaries = $this->database->innerJoin();

            $this->response = ['path' => 'AdminView/Pages/commentaries.twig',
                'data' => ['commentaire' => $articles_commentaries],
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

            $id_commentary = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $this->database->delete('commentaire', $id_commentary);

        }
        return self::indexAction();
    }
}
