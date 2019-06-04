<?php

namespace App\Controller\AdminController;

use App\Model\AdminModel\ArticlesModel;
use Core\Controller\FrontController;
use Core\Controller\Session\Session;

use \date;

class ArticlesController extends FrontController
{

    protected $data;
    protected $session;
    protected $data2;
    protected $database;

    public function __construct()
    {
        $this->database = new ArticlesModel();
        $this->session = new Session();
    }

    public function indexAction()
    {
        $this->data = $this->database->innerJoin('', '', '');

        $response = [ 'path' => 'AdminView/Pages/articles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }

    public function updateAction()
    {

        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $inputName = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_STRING);
        $inputChapo = filter_input(INPUT_POST, 'inputChapo', FILTER_SANITIZE_STRING);
        $inputType = filter_input(INPUT_POST, 'inputType', FILTER_SANITIZE_STRING);
        $inputContenue = filter_input(INPUT_POST, 'inputContenue', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($inputName !== null && $inputChapo !== null
            && $inputType !== null && $inputContenue !== null) {

            $filename = $this->upload('photoarticle');

            $data = [
                'nomArticle' => $inputName,
                'chapoArticle' => $inputChapo,
                'auteurArticle' => $this->session->userName(),
                'id_categories' => $inputType,
                'contenueArticle' => $inputContenue,
                'image' => 'img\\\\photoarticle\\\\' . $filename,
                'dateCreation' => date("Y-m-d H:i:s")
            ];

            $this->database->update('articles', $id_article, $data, 'id');

            $this->session->setValidate('inscription', 'Article mis à jour');
        }

        $this->data = $this->database->read('articles', $id_article, 'id', true);
        $this->data2 = $this->database->read('categories');

        $response = [ 'path' => 'AdminView/Pages/updateArticles.twig',
            'data' => ['articles' => $this->data,
                'types' => $this->data2],
        ];

        return $response;
    }

    public function createAction()
    {

        $this->data2 = $this->database->read('categories');

        $inputName = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_STRING);
        $inputChapo = filter_input(INPUT_POST, 'inputChapo', FILTER_SANITIZE_STRING);
        $inputType = filter_input(INPUT_POST, 'inputType', FILTER_SANITIZE_STRING);
        $inputContenue = filter_input(INPUT_POST, 'inputContenue', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($inputName !== null && $inputChapo !== null
            && $inputType !== null && $inputContenue !== null) {

            $filename = $this->upload('photoarticle');

            $data = [
                'nomArticle' => $inputName,
                'chapoArticle' => $inputChapo,
                'auteurArticle' => $this->session->userName(),
                'id_categories' => $inputType,
                'contenueArticle' => $inputContenue,
                'image' => 'img\\\\photoarticle\\\\' . $filename,
                'dateCreation' => date('Y-m-d H:i:s')
            ];

            $this->database->create('articles', $data);

            $this->session->setValidate('inscription', 'Article mis en ligne');
        }


        $response = [ 'path' => 'AdminView/Pages/updateArticles.twig',
            'data' => ['types' => $this->data2]
        ];

        return $response;
    }

}