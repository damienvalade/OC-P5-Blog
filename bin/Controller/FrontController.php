<?php

namespace Core\Controller;

use Core\View\Twig\TwigAdd;

/**
 * Class FrontController
 * @package Core\Controller
 */
class FrontController extends Controller
{

    /**
     * @var
     */
    protected $side;
    /**
     * @var
     */
    protected $rubric;
    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $twig;

    /**
     * @var
     */
    protected $controller;
    /**
     * @var
     */
    protected $cruder;

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $this->rend();
        $this->urlParser();
        $this->execController();
        $this->execAction();
    }

    /**
     *
     */
    public function rend()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addExtension(new TwigAdd());

        $this->twig = $twig;
    }

    /**
     *
     */
    public function urlParser()
    {
        if (filter_input(INPUT_GET, 'side') !== null) {
            $this->side = filter_input(INPUT_GET, 'side');
        } else {
            $this->side = 'public';
        }

        if (filter_input(INPUT_GET, 'rubric') !== null) {
            $this->rubric = filter_input(INPUT_GET, 'rubric');
        } else {
            $this->rubric = 'home';
        }

        if (filter_input(INPUT_GET, 'request') !== null) {
            $this->request = filter_input(INPUT_GET, 'request');
        }
    }

    /**
     * @return string
     */
    public function execController()
    {
        $this->side = ucfirst(strtolower($this->side));
        $this->rubric = ucfirst(strtolower($this->rubric));

        $this->controller = $this->rubric . 'Controller';
        $this->controller = '\App\Controller\\' . $this->side . 'Controller\\' . $this->controller;

        $rootLoader = '../src/Controller/' . $this->side . 'Controller/' . $this->rubric . 'Controller.php';

        if (file_exists($rootLoader)) {
            if (!class_exists($this->controller) || $this->side === '') {
                return $this->notfound();
            }
        }
    }

    /**
     *
     */
    public function execAction()
    {
        if ($this->request === null) {
            $this->cruder = $this->rubric . 'Action';
        }

        if($this->request !== null) {
            $this->cruder = $this->request . 'Action';
        }

        if (!method_exists($this->controller, $this->cruder)) {
            $this->cruder = 'indexAction';
        }
    }

    /**
     *
     */
    public function run()
    {
        if (class_exists($this->controller)) {
            $this->controller = new $this->controller;
            $response_function = call_user_func([$this->controller, $this->cruder]);

            $rendu =  $this->twig->render($response_function['path'], $response_function['data']);
        }

        if(!isset($rendu)){
            $this->notfound();
            $rendu =  $this->twig->render($this->notfound());
        }

        echo $rendu;

    }
}
