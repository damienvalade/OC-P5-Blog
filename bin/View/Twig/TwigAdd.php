<?php

namespace Core\View\Twig;

use Core\Controller\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAdd extends AbstractExtension
{

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


    public function currentUrl(string $url = null, array $params = [])
    {
        $pageCurrent = isset($_GET['side']) ? 'side=' . $_GET['side'] : 'side=public';
        $pageCurrent .= isset($_GET['rubric']) ? '&rubric=' . $_GET['rubric'] : '';
        $pageCurrent .= isset($_GET['request']) ? '&request=' . $_GET['request'] : '';

        if ($pageCurrent === $url) {
            return ' active';
        } else {
            return '';
        }
    }

    public function pathPost()
    {

        if (isset ($_GET['side'])) {
            $pathPost = 'index.php?side=' . $_GET['side'];
        }

        if(isset ($_GET['rubric']))
        {
            $pathPost .= '&rubric=' . $_GET['rubric'];
        }

        if(isset ($_GET['request']))
        {
            $pathPost .= '&request=' . $_GET['request'];
        }



        if (isset($_GET['id'])) {
            $pathPost .= '&id=' . $_GET['id'];
        }

        return $pathPost;
    }

    public function errors(string $page)
    {
        if (isset($_SESSION['error'][$page])) {
            $error = $_SESSION['error'][$page];
            $_SESSION['error'][$page] = '';
            return $error;
        }
    }

    public function validate(string $page)
    {
        if (isset($_SESSION['validate'][$page])) {
            $validate = $_SESSION['validate'][$page];
            $_SESSION['validate'][$page] = '';
            return $validate;
        }
    }

    public function isLoged(string $howto = null)
    {
        if (Session::isLogged() === true) {
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

    public function authorized()
    {

    }

    public function userName()
    {
        return Session::isLogged() === true ? ucfirst($_SESSION['user']['name']) : '';
    }

    public function userImage()
    {
        return Session::isLogged() === true ? $_SESSION['user']['image'] : '';
    }

    public function userLevel()
    {
        return Session::isLogged() === true ? $_SESSION['user']['level'] : '';
    }

}
