<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\CommentariesModel;
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
     * CommentariesController constructor.
     */
    public function __construct()
    {
        $this->database = new CommentariesModel();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $articles_commentaries = $this->database->innerJoin();

        $response = [ 'path' => 'AdminView/Pages/commentaries.twig',
            'data' => ['commentaire' => $articles_commentaries],
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        $id_commentary = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->database->delete('commentaire', $id_commentary);

        return self::indexAction();
    }
}