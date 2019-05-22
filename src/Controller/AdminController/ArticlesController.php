<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\ArticlesModel;
use Core\Controller\FrontController;
use Core\Controller\Session\Session;


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
        $this->data = $this->database->innerJoin('','','');

        return ['articles' => $this->data];
    }

    public function updateAction(){

        $id = (int)$_GET['id'];

        $this->data = $this->database->read('articles', $id, 'id', true);
        $this->data2 = $this->database->read('categories');

        return ['articles' => $this->data,
            'types' => $this->data2] ;
    }

    public function createAction(){

        $this->data2 = $this->database->read('categories');

        if (!empty($_POST)) {

            if (!empty($_POST['inputName']) && !empty($_POST['inputChapo'])
                && !empty($_POST['inputType']) && !empty($_POST['inputContenue'])) {

                $inputName = $_POST['inputName'];
                $inputChapo = $_POST['inputChapo'];
                $inputType = $_POST['inputType'];
                $inputContenue = $_POST['inputContenue'];

                    $filename = $this->upload('photoprofil');

                        $data = [
                            'nomArticle' => $inputName,
                            'chapoArticle' => $inputChapo,
                            'auteurArticle' => $this->session->userName(),
                            'id_categories' => $inputType,
                            'contenueArticle' => $inputContenue,
                            'image' => 'img\\\\photoprofil\\\\' . $filename,
                        ];

                        $this->database->create('articles', $data);

                        $this->session->setValidate('inscription', 'Article mis en ligne');
            }
        }
        return ['types' => $this->data2] ;
    }

}