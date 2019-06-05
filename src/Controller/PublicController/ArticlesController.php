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
        $id_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);

        if($id_type === null){
            $this->data = $this->database->read('articles');
        }else{
            $this->data = $this->database->query('select * from articles where id_categories =' . $id_type);
        }

        $this->data2 = $this->database->read('categories');

        $response = [ 'path' => 'PublicView/Pages/articles.twig',
            'data' => ['articles' => $this->data,
                       'categories' => $this->data2],
            ];

        return $response;
    }

    public function viewAction(){

        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->data = $this->database->prepare('articles', $id_article, 'id', true);

        $response = [ 'path' => 'PublicView/Pages/viewArticles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }
}