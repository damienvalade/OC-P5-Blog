<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Controller\Session\Session;
use Core\Model\Model;

class LoginController extends FrontController
{

    protected $users;
    protected $database;
    protected $session;

    public function __construct()
    {
        $this->database = new Model();
        $this->session = new Session();
    }

    public function loginAction()
    {
        if (!empty($_POST)) {

            if(!empty($_POST['password']) && !empty($_POST['username'])) {

                $username = $_POST['username'];
                $password = $_POST['password'];

                $this->users = $this->database->read('users', $username, 'username', true);

                if(is_null($this->users->image))
                {
                    $this->users->image = 'img\photoprofil\default.png';
                }

                if(is_object($this->users)){
                    if ($password === $this->users->password) {

                        $this->session->createSession(
                            $this->users->id,
                            $this->users->username,
                            $this->users->email,
                            $this->users->image,
                            $this->users->level_administration
                        );

                        header('Location: index.php?page=admin');

                    }else{ $this->session->setError('login', 'Mauvais Password'); }
                }else{ $this->session->setError('login','Mauvais Login');}
            }
        }
    }

}