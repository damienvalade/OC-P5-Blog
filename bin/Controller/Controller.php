<?php

namespace Core\Controller;

use Core\Controller\Cookies\Cookies;

class Controller
{
    protected $cookies;
    protected $redirect;

    public function __construct()
    {
        $this->cookies = new Cookies();
    }

    protected function redirect($redirect, $error = false){

        if($error === true){
            $this->redirect = 'HTTP/1.0 ' . $redirect;
        }

        if($error === false){
            $this->redirect = 'Location: ' . $redirect;
        }

        header($this->redirect);
    }

    protected function unauthorized()
    {
        self::redirect('401 Unauthorized', true);
        return 'ErrorsView/401.twig';
    }

    protected function forbidden()
    {
        self::redirect('403 Forbidden', true);
        return 'ErrorsView/403.twig';
    }

    protected function notfound()
    {
        self::redirect('404 Not Found', true);
        return 'ErrorsView/404.twig';
    }

    protected function serverError()
    {
        self::redirect('500 Internal Server Error', true);
        return 'ErrorsView/500.twig';
    }

    public function upload($fileDir)
    {
        $file = $_FILES;

        if ($file['avatar']['error'] === 0) {
            $uniqid = str_replace( '.', '' , uniqid('', true));
            $type = str_replace( 'image/', '' , $file['avatar']['type']);

            $uniqname = $uniqid . '.' . $type;

            $filePath = "img/{$fileDir}/{$uniqname}";
            move_uploaded_file($file['avatar']['tmp_name'], $filePath);

            return $uniqname;
        }
       }
}