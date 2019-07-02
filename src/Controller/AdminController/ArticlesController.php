<?php

namespace App\Controller\AdminController;

use App\Model\AdminModel\ArticlesModel;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;


use \date;

/**
 * Class ArticlesController
 * @package App\Controller\AdminController
 */
class ArticlesController extends FrontController
{

    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $session;
    /**
     * @var
     */
    protected $data2;
    /**
     * @var ArticlesModel
     */
    protected $database;

    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->database = new ArticlesModel();
        $this->cookies = new Cookies();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $this->data = $this->database->innerJoin();

        $response = [ 'path' => 'AdminView/Pages/articles.twig',
            'data' => ['articles' => $this->data],
        ];

        return $response;
    }

    /**
     * @return array
     */
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
                'auteurArticle' => $this->cookies->dataJWT('user','name'),
                'id_categories' => $inputType,
                'contenueArticle' => $inputContenue,
                'image' => 'img\\\\photoarticle\\\\' . $filename,
                'dateCreation' => date("Y-m-d H:i:s")
            ];

            $this->database->update('articles', $id_article, $data, 'id');

            $this->cookies->setCookies('inscription', 'Article mis à jour');
        }

        $this->data = $this->database->read('articles', $id_article, 'id', false);
        $this->data2 = $this->database->read('categories');

        $response = [ 'path' => 'AdminView/Pages/updateArticles.twig',
            'data' => ['articles' => $this->data,
                'types' => $this->data2],
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function createAction()
    {

        $this->data2 = $this->database->read('categories');

        $inputName = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_STRING);
        $inputChapo = filter_input(INPUT_POST, 'inputChapo', FILTER_SANITIZE_STRING);
        $inputType = filter_input(INPUT_POST, 'inputType', FILTER_SANITIZE_STRING);
        $inputContenue = filter_input(INPUT_POST, 'inputContenue', FILTER_SANITIZE_SPECIAL_CHARS);
        $nomAuteur = $this->cookies->dataJWT('user','name');
        $id_auteur = $this->database->read('users', $nomAuteur, 'username', false);

        if ($inputName !== null && $inputChapo !== null
            && $inputType !== null && $inputContenue !== null) {

            $filename = $this->upload('photoarticle');

            $data = [
                'nomArticle' => $inputName,
                'chapoArticle' => $inputChapo,
                'auteurArticle' => $this->cookies->dataJWT('user','name'),
                'id_auteur' => $id_auteur[0]['id'],
                'id_categories' => $inputType,
                'contenueArticle' => $inputContenue,
                'image' => 'img\\\\photoarticle\\\\' . $filename,
                'dateCreation' => date('Y-m-d H:i:s')
            ];

            $this->database->create('articles', $data);

            $this->cookies->setCookies('inscription', 'Article mis en ligne');
        }


        $response = [ 'path' => 'AdminView/Pages/createArticles.twig',
            'data' => ['types' => $this->data2]
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $id_commentaire = $this->database->read('commentaire', $id_article, 'id_article', false);

        foreach ( $id_commentaire as $todelete){
            $this->database->delete('commentaire', $todelete['id']);
        }
            $this->database->delete('articles', $id_article);

        return self::indexAction();
    }

}