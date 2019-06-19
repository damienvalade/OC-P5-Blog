<?php

namespace Core\View\Twig;

use Core\Controller\Cookies\Cookies;
use Core\Controller\Session\Session;
use http\Cookie;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAdd extends AbstractExtension
{

    protected $cookies;

    public function __construct()
    {
        $this->cookies = new Cookies();
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('currentUrl', array($this, 'currentUrl')),
            new TwigFunction('pathPost', array($this, 'pathPost')),
            new TwigFunction('errors', array($this, 'errors')),
            new TwigFunction('isLoged', array($this, 'isLoged')),
            new TwigFunction('userName', array($this, 'userName')),
            new TwigFunction('userImage', array($this, 'userImage')),
            new TwigFunction('userLevel', array($this, 'userLevel')),
            new TwigFunction('validate', array($this, 'validate')),
            new TwigFunction('authorized', array($this, 'authorized')),
        );
    }

    public function currentUrl(string $url = null)
    {

        $side = filter_input(INPUT_GET, 'side');
        $rubric = filter_input(INPUT_GET, 'rubric');
        $request = filter_input(INPUT_GET, 'request');

        if ($side !== null) {
            $pageCurrent = 'side=' . $side;
        } else {
            $pageCurrent = 'side=public';
        }

        if($rubric !== null)
        {
            $pageCurrent .= '&rubric=' . $rubric;
        }

        if($request !== null)
        {
            $pageCurrent .= '&request=' . $request;
        }

        if ($pageCurrent === $url) {
            return ' active';
        } else {
            return '';
        }
    }

    public function pathPost()
    {

        $side = filter_input(INPUT_GET, 'side');
        $rubric = filter_input(INPUT_GET, 'rubric');
        $request = filter_input(INPUT_GET, 'request');
        $id_path = filter_input(INPUT_GET, 'id');

        if ($side !== null) {
            $pathPost = '/' . $side;
        }

        if($rubric !== null)
        {
            $pathPost .= '/' . $rubric;
        }

        if($request !== null)
        {
            $pathPost .= '/' . $request;
        }

        if ($id_path !== null) {
            $pathPost .= '/' . $id_path;
        }

        return $pathPost;
    }

    public function errors($page)
    {
        $error = $this->cookies->getCookies($page);

        if ($error !== false) {
            $this->cookies->unsetCookies($page);
            return $error;
        }
    }

    public function validate(string $page)
    {
        $validate = $this->cookies->getCookies($page);

        if ($validate !== false) {
            $this->cookies->unsetCookies($page);
            return $validate;
        }
    }

    public function isLoged(string $howto = null)
    {

        if ($this->cookies->dataJWT('user','id') !== false) {
            if ($howto === 'toHidde') {
                return 'hidden';
            } else if ($howto === 'toVisible') {
                return '';
            }
        } else {

            if ($howto === 'toHidde') {
                return '';
            } else if ($howto === 'toVisible') {
                return 'hidden';
            }

        }
    }


    public function userName()
    {
        return $this->cookies->dataJWT('user','name') !== false ? ucfirst($this->cookies->dataJWT('user','name')) : '';
    }

    public function userImage()
    {
        return $this->cookies->dataJWT('user','image') !== false ? $this->cookies->dataJWT('user','image') : '';
    }

    public function userLevel()
    {
        return $this->cookies->dataJWT('user','level') !== false ? ucfirst($this->cookies->dataJWT('user','level')) : '';
    }

}
