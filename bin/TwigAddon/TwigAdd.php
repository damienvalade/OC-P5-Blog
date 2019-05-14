<?php

namespace Core\TwigAddon;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAdd extends AbstractExtension
{

    public function getFunctions()
    {
        return array(
            new TwigFunction('currentUrl', array($this, 'currentUrl')),
            new TwigFunction('pathPost', array ($this, 'pathPost')),
            new TwigFunction('errorLogin', array ($this, 'errorLogin'))
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
        if (isset ($_GET['page']))
        {
            $pathPost = 'index.php?page=' . $_GET['page'];

            return $pathPost;
        }
    }

    public function errorLogin()
    {
        $error = $_SESSION['error'];
        $_SESSION['error'] = '';
        return $error;
    }
}
