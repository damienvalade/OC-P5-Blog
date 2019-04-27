<?php

namespace App\Controller;

class Controller
{

    public function rend(string $views)
    {

        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/View');
        $twig = new \Twig\Environment($loader,[
            'cache' => false,
        ]);

        echo $twig->render($views);
    }

    protected function unauthorized()
    {
        header('HTTP/1.0 401 Unauthorized');

        return $this->rend('errors/401.twig');
    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');

        return $this->rend('errors/403.twig');
    }

    protected function notfound()
    {
        header('HTTP/1.0 404 Not Found');

        return $this->rend('errors/404.twig');
    }
}