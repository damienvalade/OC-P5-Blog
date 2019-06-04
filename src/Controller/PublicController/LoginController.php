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

                        header('Location: index.php?side=admin');

                    }else{ $this->session->setError('login', 'Mauvais Password'); }
                }else{ $this->session->setError('login','Mauvais Login');}
            }
        }
        $response = [ 'path' => 'PublicView/Pages/login.twig',
            'data' => [],
        ];

        return $response;
    }


    public function subcribeAction()
    {
        if (!empty($_POST)) {

            if (!empty($_POST['inputName']) && !empty($_POST['inputEmail'])
                && !empty($_POST['inputPassword1']) && !empty($_POST['inputPassword2'])) {

                $username = $_POST['inputName'];
                $eamail = $_POST['inputEmail'];
                $password = $_POST['inputPassword1'];
                $passwordVerif = $_POST['inputPassword2'];
                $nom = $_POST['inputNom'];
                $prenom = $_POST['inputPrenom'];

                $this->users = $this->database->read('users', $eamail, 'email', true);

                if (!is_object($this->users)) {

                    $filename = $this->upload('photoprofil', $username);

                    if ($password === $passwordVerif) {
                        $data = [
                            'firstname' => $prenom,
                            'name' => $nom,
                            'username' => $username,
                            'password' => $password,
                            'email' => $eamail,
                            'image' => 'img\\\\photoprofil\\\\' . $filename,
                            'level_administration' => '3'
                        ];

                        $this->database->create('users', $data);

                        $this->session->setValidate('inscription', 'Bravo vous êtes bien inscrit !');

                    } else {
                        $this->session->setError('inscription', 'Mot de passe différent');
                    }
                }else{ $this->session->setError('inscription', 'Adresse Email déjà utilisé'); }
            }
        }
        $response = [ 'path' => 'PublicView/Pages/inscription.twig',
            'data' => [],
        ];

        return $response;
    }

    public function disconnectAction()
    {
        $_SESSION['user'] = '';
        session_destroy();

        $response = [ 'path' => 'PublicView/Pages/home.twig',
            'data' => [],
        ];

        return $response;
    }

}