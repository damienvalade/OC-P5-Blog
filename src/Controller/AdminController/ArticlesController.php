<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\ArticlesModel;


class ArticlesController
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

}