<?php

namespace Core\Controller;

use Core\View\Twig\TwigAdd;

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

    protected $test;

    const CONST_PATH = '\App\Controller\\';

    public function __construct()
    {
        $this->rend();
        $this->urlParser();
        $this->execController();
        $this->execCrud();
    }

    public function rend()
    {

        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . '/src/View');
        $twig = new \Twig\Environment($loader, [
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
                $this->action = $pages[1];
            }
            if (is_array($pages) && count($pages) >= 3) {
                $this->test = $pages[2];
            }
        } else {
            $this->page = 'public';
        }
    }

    public function execController()
    {
        $this->page = ucfirst(strtolower($this->page));
        $this->type = ucfirst(strtolower($this->type));

        $this->controller = $this->type . 'Controller';
        $this->controller = self::CONST_PATH . $this->page . 'Controller\\' . $this->controller;

        $this->rootLoader = dirname(dirname(__DIR__)) . '/src/Controller/' . $this->page . 'Controller/' . $this->type . 'Controller.php';

        if (file_exists($this->rootLoader)) {
            if (!class_exists($this->controller) || $this->page === '') {
                exit($this->notfound());
            } else {
                $this->route = $this->page . 'View/Pages/' . $this->type . '.twig';
            }
        } else {
            exit($this->notfound());
        }
    }

    public function execCrud()
    {

        if(is_null($this->test )){
            $this->cruder = $this->action . 'Action';
        } else{
            $this->cruder = $this->test . 'Action';
        }

        if (!method_exists($this->controller, $this->cruder)) {
            $this->cruder = 'indexAction';
        }
    }

    public function run(string $fastRun = null)
    {
        $this->execCrud();

        if (isset($fastRun) ) {

            echo $this->twig->render($fastRun);

        } else {

            if (class_exists($this->controller)) {

                $this->controller = new $this->controller;
                $response = call_user_func([$this->controller, $this->cruder]);

            }

            if (isset($this->test) && !is_null($this->test)) {
                echo $this->twig->render($this->page . 'View/pages/' . $this->test . ucfirst($this->action) . '.twig', $response);
            } elseif ($response === NULL)
            {
                echo $this->twig->render($this->route);
            }
            else {
                echo $this->twig->render($this->route, $response);
            }


        }
    }
}