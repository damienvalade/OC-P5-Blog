<?php

namespace Core\TwigAddon;

use Core\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAdd extends AbstractExtension
{

    public function getFunctions()
    {
        return array(
            new TwigFunction('currentUrl', array($this, 'currentUrl')),
            new TwigFunction('pathPost', array($this, 'pathPost')),
            new TwigFunction('errorLogin', array($this, 'errorLogin')),
            new TwigFunction('isLoged', array($this, 'isLoged'))
        );
    }


    public function currentUrl(string $url = null, array $params = [])
    {
        $pageCurrent = isset($_GET['page']) ? $_GET['page'] : 'page';

        if ($pageCurrent === $url) {
            return ' active';
        } else {
            return '';
        }
    }

    public function pathPost()
    {
        if (isset ($_GET['page'])) {
            $pathPost = 'index.php?page=' . $_GET['page'];

            return $pathPost;
        }
    }

    public function errorLogin()
    {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            $_SESSION['error'] = '';
            return $error;
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
}
