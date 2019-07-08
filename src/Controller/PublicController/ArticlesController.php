<?php

namespace App\Controller\PublicController;

use App\Model\PublicModel\ArticlesModel;
use Core\Controller\FrontController;

use Core\Model\View\View;

/**
 * Class ArticlesController
 * @package App\Controller\PublicController
 */
class ArticlesController extends FrontController
{

    /**
     * @var Model
     */
    protected $database;

    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->database = new ArticlesModel();
        $this->view->addview();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $id_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);
        $id_auteur = filter_input(INPUT_GET, 'auteur', FILTER_SANITIZE_STRING);

        if ($id_auteur !== null) {
            $article = $this->database->read('articles', $id_auteur, 'auteur_article', false);
        } elseif ($id_type !== null) {
            $article = $this->database->read('articles', $id_type, 'id_categories', false);
        } else {
            $article = $this->database->read('articles');
        }

        $author = $this->database->read('articles', 'auteur_article', null, true, true);

        $commentary = $this->database->read('categories');

        $response = ['path' => 'PublicView/Pages/articles.twig',
            'data' => ['articles' => $article,
                'categories' => $commentary,
                'auteur' => $author],
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function viewAction()
    {

        $id_article = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_STRING);

        if($commentaire !== null){

            $id_user = $this->database->read('users' , $this->cookie->dataJWT('user','name'), 'name', false );

            $array_commentary = [
                'id_article' => $id_article,
                'commentaire' => $commentaire,
                'id_auteur' => $id_user[0]['id'],
                'date_creation' => date("Y-m-d H:i:s")
            ];

            $this->database->create('commentaire', $array_commentary);
        }

        $article = $this->database->read('articles', $id_article, 'id', false);

        $value = 'commentaire.commentaire, commentaire.date_creation, users.username, users.image';

        $array = [
            'users.id = commentaire.id_auteur',
            'commentaire.id_article =' . $id_article
        ];

        $commentary = $this->database->read('commentaire, users',$value, null,true,false,true,$array);

        $response = ['path' => 'PublicView/Pages/viewArticles.twig',
            'data' => [
                'articles' => $article,
                'commentaires' => $commentary
                ],
        ];

        return $response;
    }
}
