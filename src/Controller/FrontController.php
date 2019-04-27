<?php

namespace App\Controller;

class FrontController extends Controller
{

    protected $url;
    protected $page;
    protected $type = 'Home';
    protected $action;
    protected $controller;
    protected $cruder;

    const CONST_PATH = '\App\Controller\\';

    public function __construct()
    {
        $this->urlParser();
    }

    public function urlParser()
    {
        if (isset ($_GET['page'])) {

            $this->url = str_replace(' ', '', $_GET['page']);
            $pages = explode('.', $this->url);

            $this->page = $pages[0];

            if (is_array($pages) && count($pages) >= 2) {
                $this->type = $pages[1];
            }
            $this->execController();
        }
    }

    public function execController()
    {

            $this->controller = ucfirst(strtolower($this->type)) . 'Controller';
            $this->controller = self::CONST_PATH . $this->controller;

            if (!file_exists( __DIR__ . '/' . $this->type . 'Controller.php')) {
                exit($this->notfound());
            }else{
                $this->rend($this->page . '/' . $this->type . '.twig');
                die();
            }

    }

    public function execCrud()
    {
        $this->cruder = ucfirst(strtolower($this->action)) . 'Crud';
        $this->cruder = self::CONST_PATH . $this->cruder;
    }


    public function run()
    {
        $this->controller = new $this->controller();

        return $this->controller;
    }
}