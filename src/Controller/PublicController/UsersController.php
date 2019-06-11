<?php

namespace App\Controller\PublicController;

use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;
use Core\Model\Model;

class UsersController extends FrontController
{

    protected $users;
    protected $database;
    protected $cookies;

    public function __construct()
    {
        $this->database = new Model();
        $this->cookies = new Cookies();
    }

    public function loginAction()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($username !== null && $password !== null) {

            $this->users = $this->database->read('users', $username, 'username', true);

            if (is_null($this->users->image)) {
                $this->users->image = 'img\photoprofil\default.png';
            }

            if (is_object($this->users)) {
                if ($password === $this->users->password) {

                    $data = $this->cookies->encodeJWT($this->users->id,
                        $this->users->username,
                        $this->users->email,
                        $this->users->image,
                        $this->users->level_administration);

                    $this->cookies->setCookies('user',$data);

                    $this->redirect('index.php?side=admin');

                } else {
                    $this->session->setError('login', 'Mauvais Password');
                }
            } else {
                $this->session->setError('login', 'Mauvais Login');
            }
        }

        $response = ['path' => 'PublicView/Pages/login.twig',
            'data' => [],
        ];

        return $response;
    }


    public function subcribeAction()
    {

        $username = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_SPECIAL_CHARS);
        $eamail = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'inputPassword1', FILTER_SANITIZE_STRING);
        $passwordVerif = filter_input(INPUT_POST, 'inputPassword2', FILTER_SANITIZE_STRING);
        $nom = filter_input(INPUT_POST, 'inputNom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'inputPrenom', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($username !== null && $eamail !== null
            && $password !== null && $passwordVerif !== null) {

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
            } else {
                $this->session->setError('inscription', 'Adresse Email déjà utilisé');
            }
        }

        $response = ['path' => 'PublicView/Pages/inscription.twig',
            'data' => [],
        ];

        return $response;
    }

    public function disconnectAction()
    {

        $this->cookies->unsetCookies('user');
        $this->redirect('index.php?side=public');

        $response = ['path' => 'PublicView/Pages/home.twig',
            'data' => [],
        ];

        return $response;
    }

}