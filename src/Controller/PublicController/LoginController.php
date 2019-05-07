<?php

namespace App\Controller\PublicController;

use App\Session\Session;
use App\Model\Model;

class LoginController
{

    public function loginAction()
    {
        if (!empty($_POST)) {

            $user = ModelFactory::get('User')->read($_POST['email'], 'email');

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