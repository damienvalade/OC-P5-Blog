<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\Model;

class ArticlesController extends FrontController
{
    protected $data;
    protected $data2;
    protected $data3;
    protected $database;

    public function __construct()
    {
        $this->database = new Model();

        $view = $this->database->query("SELECT * FROM `view` WHERE `url` = '$_SERVER[REQUEST_URI]'");

        $date = date('Y-m-d');

        if($view === []){
            $this->data = $this->database->query("INSERT INTO `view`(`page`, `url`, `nb_view`, `day`) VALUES ('$_SERVER[HTTP_HOST]','$_SERVER[REQUEST_URI]',1, '$date')");
        }

        foreach ($view as $value => $key) {
            if($key['day'] === null){
                $this->data = $this->database->query("INSERT INTO `view`(`page`, `url`, `nb_view`, `day`) VALUES ('$_SERVER[HTTP_HOST]','$_SERVER[REQUEST_URI]',1, '$date')");
            }elseif ($key['day'] === $date) {
                $nb_view = $key['nb_view'] + 1;
                $this->data = $this->database->query("UPDATE `view` SET `nb_view`= '$nb_view' WHERE `url` = '$_SERVER[REQUEST_URI]'");
            }
        }
    }

    public function indexAction()
    {
        $id_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);

        if ($id_type === null) {
            $this->data = $this->database->read('articles');
        } else {
            $this->data = $this->database->query('select * from articles where id_categories =' . $id_type);
        }

        $this->data3 = $this->database->query('select auteurArticle from articles GROUP BY auteurArticle');

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

        $this->data = $this->database->read('articles',$id_article,'id',true);

        $response = ['path' => 'PublicView/Pages/viewArticles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }
}