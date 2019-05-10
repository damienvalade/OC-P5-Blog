<?php

namespace App\Controller\PublicController;

use App\Controller\Controller;
use App\Controller\FrontController;
use App\Session\Session;
use App\Model\Model;

class LoginController extends FrontController
{

    protected $users;
    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function loginAction()
    {
        if (!empty($_POST)) {

            if(!empty($_POST['password']) && !empty($_POST['username'])) {

                $username = $_POST['username'];
                $password = $_POST['password'];

                $this->users = $this->database->read('users', $username, 'username', true);

                if ($password === $this->users->password) {
                    Session::createSession(
                        $this->users->id,
                        $this->users->username
                    );

                    header('Location: index.php?page=admin');

                }
            }
        }
    }

}