<?php

namespace App\Controller\PublicController;

use App\Session\Session;
use App\Model\Model;

class LoginController
{

    public function loginAction()
    {
        if (!empty($_POST)) {

            $user = Model::read($_POST['username'], 'username');

            if (password_verify($_POST['pass'], $user['pass'])) {
                Session::createSession(
                    $user['id'],
                    $user['name'],
                    $user['email'],
                    $user['image'],
                    $user['level']
                );
            }
        }
    }
}