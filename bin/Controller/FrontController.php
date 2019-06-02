<?php

namespace Core\Controller;

use Core\View\Twig\TwigAdd;

class FrontController extends Controller
{

    protected $side;
    protected $rubric;
    protected $request;

    protected $isError = false;
    protected $typeError;

    protected $rootLoader;
    protected $route;
    protected $twig;
    protected $url;

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
        $this->execAction();
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
        if (isset ($_GET['side'])) {
            $this->side = filter_input(INPUT_GET, 'side');
        } else {
            $this->side = 'public';
        }

        if(isset ($_GET['rubric']))
        {
            $this->rubric = filter_input(INPUT_GET, 'rubric');
        } else{
            $this->rubric = 'home';
        }

        if(isset ($_GET['request']))
        {
            $this->request = filter_input(INPUT_GET, 'request');
        }
    }

    public function execController()
    {
        $this->side = ucfirst(strtolower($this->side));
        $this->rubric = ucfirst(strtolower($this->rubric));

        $this->controller = $this->rubric . 'Controller';
        $this->controller = self::CONST_PATH . $this->side . 'Controller\\' . $this->controller;

        $this->rootLoader = dirname(dirname(__DIR__)) . '/src/Controller/' . $this->side . 'Controller/' . $this->rubric . 'Controller.php';

        if (file_exists($this->rootLoader)) {
            if (!class_exists($this->controller) || $this->side === '') {
                $this->typeError = 'notfound';
                $this->isError = true;
            } else {
                $this->route = $this->side . 'View/Pages/' . $this->rubric . '.twig';
            }
        } else {
            $this->typeError = 'notfound';
            $this->isError = true;
        }
    }

    public function execAction()
    {
        if(is_null($this->request )){
            $this->cruder = $this->rubric . 'Action';
        }else{
            $this->cruder = $this->request . 'Action';
        }

        if (!method_exists($this->controller, $this->cruder)) {
            $this->cruder = 'indexAction';
        }
    }

    public function run(string $fastRun = null)
    {

        if($this->isError === false){
            if (isset($fastRun) ) {

                echo $this->twig->render($fastRun);

            } else {

                if (class_exists($this->controller)) {

                    $this->controller = new $this->controller;
                    $response = call_user_func([$this->controller, $this->cruder]);

                }

                if (isset($this->request) && !is_null($this->request) && !is_null($response)) {
                    echo $this->twig->render($this->side . 'View/pages/' . $this->request . ucfirst($this->rubric) . '.twig', $response);

                } elseif ($response === NULL)
                {
                    echo $this->twig->render($this->route);
                }
                else {
                    echo $this->twig->render($this->route, $response);
                }

            }
        }else{
            $error = $this->typeError;
            $this->isError = false;
            $this->$error();
        }
    }
}