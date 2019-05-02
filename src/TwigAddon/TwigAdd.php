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


    public function currentUrl(string $pageTry = null, array $params = [])
    {
        $pageCurrent = $_GET['page'];

        if($pageCurrent === $pageTry)
        {
            return ' active';
        }else{
            return $pageCurrent . ' ' . $pageTry;
        }
    }
}