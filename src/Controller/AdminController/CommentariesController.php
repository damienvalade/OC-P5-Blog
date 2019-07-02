<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\CommentariesModel;

/**
 * Class CommentariesController
 * @package App\Controller\AdminController
 */
class CommentariesController
{
    /**
     * @var
     */
    protected $data;
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
        $this->data = $this->database->innerJoin();

        $response = [ 'path' => 'AdminView/Pages/commentaries.twig',
            'data' => ['commentaire' => $this->data],
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