<?php


namespace App\Controller\PublicController;


class DeconnexionController
{
    public function IndexAction()
    {
        $_SESSION['user'] = '';
        session_destroy();

        exit(header('Location: index.php?page=public'));
    }
}