<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\Model;

class ArticlesController extends FrontController
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