<?php


namespace App\Controller\AdminController;


use Core\Model\Model;

class ArticlesController
{

    protected $data;
    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {
        $this->data = $this->database->read('articles');

        return ['articles' => $this->data] ;
    }

}