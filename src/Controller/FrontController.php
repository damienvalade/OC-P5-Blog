<?php

namespace App\Controller;

use TwigAdd\View\TwigAdd;

class FrontController extends Controller
{

    protected $rootLoader;
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

        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addExtension(new TwigAdd());

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

        $this->page = ucfirst(strtolower($this->page));
        $this->type = ucfirst(strtolower($this->type));

        $this->controller = $this->type . 'Controller';
        $this->controller = self::CONST_PATH . $this->page .'Controller/'. $this->controller;

        $this->rootLoader = __DIR__ . '/' . $this->page . 'Controller/' . $this->type. 'Controller.php';

        var_dump($this->controller);
        var_dump(!class_exists($this->controller));

        if (!file_exists($this->rootLoader) || class_exists($this->controller) || $this->page === '' ) {
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