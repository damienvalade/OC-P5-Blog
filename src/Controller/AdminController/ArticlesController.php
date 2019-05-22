<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\ArticlesModel;
use Core\Controller\FrontController;


class ArticlesController extends FrontController
{

    protected $data;
    protected $data2;
    protected $database;

    public function __construct()
    {
        $this->database = new ArticlesModel();
    }

    public function indexAction()
    {
        $this->data = $this->database->innerJoin('','','');

        return ['articles' => $this->data];
    }

    public function updateAction(){

        $this->data = $this->database->read('articles', '1', 'id', true);
        $this->data2 = $this->database->read('categories');

        return ['articles' => $this->data,
            'types' => $this->data2] ;
    }

    public function createAction(){
        // TODO
    }

}