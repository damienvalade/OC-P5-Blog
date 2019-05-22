<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\ArticlesModel;
use Core\Controller\FrontController;


class ArticlesController extends FrontController
{

    protected $data;
    protected $database;

    public function __construct()
    {
        $this->database = new ArticlesModel();
    }

    public function indexAction()
    {
        $this->data = $this->database->innerJoin('','','');

        return ['articles' => $this->data] ;
    }

    public function updateAction(){
        // TODO
    }

    public function createAction(){
        // TODO
    }

}