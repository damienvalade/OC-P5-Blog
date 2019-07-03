<?php

namespace App\Controller\PublicController;

use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;
use Core\Model\Model;

/**
 * Class UsersController
 * @package App\Controller\PublicController
 */
class UsersController extends FrontController
{

    /**
     * @var
     */
    protected $users;
    /**
     * @var Model
     */
    protected $database;
    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->database = new Model();
        $this->cookies = new Cookies();
    }

    /**
     * @return array
     */
    public function loginAction()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($username !== null && $password !== null) {

            $this->users = $this->database->read('users', $username, 'username', false);

            if ($this->users !== '' && !empty($this->users)) {

                foreach ($this->users as $value => $key){
                    $idUSer = $key['id'];
                    $passwordVerif = $key['password'];
                    $image = $key['image'];
                    $username = $key['username'];
                    $email = $key['email'];
                    $level_administration = $key['level_administration'];
                }

                if ($password === $passwordVerif) {

                    if ($image === null) {
                        $image = '\img\photoprofil\default.png';
                    }

                    $data = $this->cookies->encodeJWT($idUSer,
                        $username,
                        $email,
                        $image,
                        $level_administration);

                    $this->cookies->setCookies('user',$data);

                    $this->redirect('/admin/home');

                } else {
                    $this->cookies->setCookies('login', 'Mauvais Password');
                    $this->redirect('/public/users/login');
                }
            } else {
                $this->cookies->setCookies('login', 'Mauvais Login');
                $this->redirect('/public/users/login');
            }
        }

        $response = ['path' => 'PublicView/Pages/login.twig',
            'data' => [],
        ];

        return $response;
    }


    /**
     * @return array
     */
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

            if ($this->users === '' && !empty($this->users)) {

                $filename = $this->upload('photoprofil', $username);

                if ($password === $passwordVerif) {
                    $data = [
                        'firstname' => $prenom,
                        'name' => $nom,
                        'username' => $username,
                        'password' => $password,
                        'email' => $eamail,
                        'image' => '\\\\\\img\\\\photoprofil\\\\' . $filename,
                        'level_administration' => '3'
                    ];

                    $this->database->create('users', $data);

                    $this->cookies->setCookies('inscription', 'Bravo vous êtes bien inscrit !');
                    $this->redirect('/public/users/login/subcribe');

                } else {
                    $this->cookies->setCookies('inscription', 'Mot de passe différent !');
                    $this->redirect('/public/users/login/subcribe');
                }
            } else {
                $this->cookies->setCookies('inscription', 'Adresse Email déjà utilisé !');
                $this->redirect('/public/users/login/subcribe');
            }
        }

        $response = ['path' => 'PublicView/Pages/inscription.twig',
            'data' => [],
        ];

        return $response;
    }

    /**
     * @return array
     */
    public function disconnectAction()
    {

        $this->cookies->unsetCookies('user');
        $this->redirect('/public/home');

        $response = ['path' => 'PublicView/Pages/home.twig',
            'data' => [],
        ];

        return $response;
    }

}

