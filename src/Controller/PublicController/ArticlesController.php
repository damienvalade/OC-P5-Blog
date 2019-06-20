<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\Model;
use Core\Model\View\View;

class ArticlesController extends FrontController
{
    protected $data;
    protected $data2;
    protected $data3;
    protected $database;
    protected $view;

    public function __construct()
    {
        $this->database = new Model();
        $this->view = new View();

        $this->view->addView();
    }

    public function indexAction()
    {
        $id_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);
        $id_auteur = filter_input(INPUT_GET, 'auteur', FILTER_SANITIZE_STRING);

        if ($id_auteur !== null) {
            $this->data = $this->database->read('articles', $id_auteur, 'auteurArticle', false);
        } elseif ($id_type !== null) {
            $this->data = $this->database->read('articles', $id_type, 'id_categories', false);
        } else {
            $this->data = $this->database->read('articles');
        }

        $this->data3 = $this->database->read('articles', 'auteurArticle', null, true, true);

        $this->data2 = $this->database->read('categories');

        $response = ['path' => 'PublicView/Pages/articles.twig',
            'data' => ['articles' => $this->data,
                'categories' => $this->data2,
                'auteur' => $this->data3],
        ];

        return $response;
    }

    public function viewAction()
    {

        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->data = $this->database->read('articles', $id_article, 'id', false);

        $response = ['path' => 'PublicView/Pages/viewArticles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }
}