<?php

namespace App\Controller;

class FrontController extends Controller
{

    protected $route;
    protected $twig;
    protected $url;
    protected $page;
    protected $type = 'Home';
    protected $action;
    protected $controller;
    protected $cruder;

    const CONST_PATH = '\App\Controller\\';

    public function __construct()
    {
        $this->rend();
        $this->urlParser();
    }

    public function rend()
    {

        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/View');
        $twig = new \Twig\Environment($loader,[
            'cache' => false,
        ]);

        $this->twig = $twig;
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
        }else{
            $this->page = 'public';
        }
        $this->execController();
    }

    public function execController()
    {

        $this->controller = ucfirst(strtolower($this->type)) . 'Controller';
        $this->controller = self::CONST_PATH . $this->controller;

        if (!file_exists(__DIR__ . '/' . $this->type . 'Controller.php') || $this->page === '' ) {
            exit($this->notfound());
        } else {
            $this->route = $this->page . '/' . $this->type . '.twig';
        }

    }

    public function execCrud()
    {
        $this->cruder = ucfirst(strtolower($this->action)) . 'Crud';
        $this->cruder = self::CONST_PATH . $this->cruder;
    }


    public function run($fastrun = null)
    {
        if(isset($fastrun)){
            echo $this->twig->render($fastrun);
        }else {
            echo $this->twig->render($this->route);
        }
    }
}