<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\CommentaireModel;

class CommentaireController
{
    protected $data;
    protected $database;

    public function __construct()
    {
        $this->database = new CommentaireModel();
    }

    public function indexAction()
    {
        $this->data = $this->database->innerJoin('','','');

        $response = [ 'path' => 'AdminView/Pages/commentaire.twig',
            'data' => ['commentaire' => $this->data],
        ];

        return $response;
    }
}