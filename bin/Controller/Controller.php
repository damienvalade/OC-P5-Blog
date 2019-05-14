<?php

namespace Core\Controller;


class Controller
{
    protected $route;

    protected function unauthorized()
    {
        header('HTTP/1.0 401 Unauthorized');

        $this->run('errors/401.twig');
    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');

        $this->run( 'errors/403.twig');
    }

    protected function notfound()
    {
        header('HTTP/1.0 404 Not Found');

        $this->run('errors/404.twig');
    }

    protected function serverError()
    {
        header('HTTP/1.0 500 Internal Server Error');

        $this->run('errors/500.twig');
    }
}