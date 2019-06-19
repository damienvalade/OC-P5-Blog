<?php

namespace Core\Controller;

use Core\Controller\Cookies\Cookies;

class Controller
{
    protected $cookies;

    public function __construct()
    {
        $this->cookies = new Cookies();
    }

    protected function redirect($page){
        header('Location: ' . $page);
        exit;
    }

    protected function redirectError($error){
        header('HTTP/1.0 ' . $error);
    }

    protected function unauthorized()
    {
        self::redirectError('401 Unauthorized');
        return 'ErrorsView/401.twig';
    }

    protected function forbidden()
    {
        self::redirectError('403 Forbidden');
        return 'ErrorsView/403.twig';
    }

    protected function notfound()
    {
        self::redirectError('404 Not Found');
        return 'ErrorsView/404.twig';
    }

    protected function serverError()
    {
        self::redirectError('500 Internal Server Error');
        return 'ErrorsView/500.twig';
    }

    public function upload($fileDir)
    {
        $file = $_FILES;

        if ($file['avatar']['error'] > 0) {
            htmlspecialchars(Session::setError('warning', 'Erreur lors du transfert du fichier...'));
        } else {

            $uniqid = str_replace( '.', '' , uniqid('', true));
            $type = str_replace( 'image/', '' , $file['avatar']['type']);

            $uniqname = $uniqid . '.' . $type;

            $filePath = "img/{$fileDir}/{$uniqname}";
            $result = move_uploaded_file($file['avatar']['tmp_name'], $filePath);
            if ($result) {
                htmlspecialchars($this->cookies->setCookies('fichier', 'Fichier bien transferer'));
            }
            return $uniqname;
        }
    }
}