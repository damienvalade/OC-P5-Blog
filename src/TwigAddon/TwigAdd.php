<?php

namespace TwigAdd\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAdd extends AbstractExtension
{

    public function getFunctions()
    {
        return array(
          new TwigFunction('currentUrl',  array($this , 'currentUrl'))
        );
    }


    public function currentUrl(string $url = null, array $params = [])
    {
        $pageCurrent = isset($_GET['page']) ? $_GET['page'] : 'page';

        if($pageCurrent === $url)
        {
            return ' active';
        }else{
            return $_GET['page'] . ' ' . $url;
        }
    }
}