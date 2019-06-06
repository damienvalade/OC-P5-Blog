<?php

namespace Core\Controller;

use Core\Controller\Session\Session;
use Core\Model\Database\Database;

class Controller
{

    protected function unauthorized()
    {
        header('HTTP/1.0 401 Unauthorized');

        return 'ErrorsView/401.twig';
    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');

        return 'ErrorsView/403.twig';
    }

    protected function notfound()
    {
        header('HTTP/1.0 404 Not Found');

        return 'ErrorsView/404.twig';
    }

    protected function serverError()
    {
        header('HTTP/1.0 500 Internal Server Error');

        return 'ErrorsView/500.twig';
    }

    public function upload($fileDir)
    {
        $fileError = $_FILES['avatar']['error'];

        if ($fileError > 0) {
            htmlspecialchars(Session::setError('warning', 'Erreur lors du transfert du fichier...'));
        } else {

            $uniqid = str_replace( '.', '' , uniqid('', true));
            $type = str_replace( 'image/', '' , $_FILES['avatar']['type']);

            $uniqname = $uniqid . '.' . $type;

            $filePath = dirname(dirname(__DIR__)) . "/public/img/{$fileDir}/{$uniqname}";
            $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath);
            if ($result) {
                htmlspecialchars(Session::setValidate('fichier', 'Fichier bien transferer'));
            }
            return $uniqname;
        }
    }
}