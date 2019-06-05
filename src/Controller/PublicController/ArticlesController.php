<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\Model;

class ArticlesController extends FrontController
{
    protected $data;
    protected $data2;
    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {
        $this->data = $this->database->read('articles');

        $this->data2 = $this->database->read('categories');

        $response = [ 'path' => 'PublicView/Pages/articles.twig',
            'data' => ['articles' => $this->data,
                       'categories' => $this->data2],
            ];

        return $response;
    }

    public function viewAction(){

        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->data = $this->database->read('articles', $id_article, 'id', true);

        $response = [ 'path' => 'PublicView/Pages/viewArticles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }
}