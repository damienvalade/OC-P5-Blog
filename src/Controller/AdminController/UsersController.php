<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\UsersModel;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;

class UsersController extends FrontController
{

    protected $data;
    protected $database;
    protected $cookies;

    public function __construct()
    {
        $this->database = new UsersModel();
        $this->cookies = new Cookies();
    }

    public function indexAction()
    {

        $response = [ 'path' => $this->unauthorized(),
            'data' => [],
        ];

        $this->data = $this->database->innerjoin();

        if( $this->cookies->dataJWT('user','id') !== false )
        {
            $response = [ 'path' => 'AdminView/Pages/users.twig',
                'data' => ['users' => $this->data]
            ];

        }

        return $response;
    }

    public function updateAction(){

        $id_user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $username = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_SPECIAL_CHARS);
        $eamail = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'inputPassword1', FILTER_SANITIZE_STRING);
        $passwordVerif = filter_input(INPUT_POST, 'inputPassword2', FILTER_SANITIZE_STRING);
        $nom = filter_input(INPUT_POST, 'inputNom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'inputPrenom', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($username !== null && $eamail !== null
            && $password !== null && $passwordVerif !== null) {

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

                    $this->database->update('users', $id_user, $data, 'id');

                    $this->cookies->setCookies('inscription', 'Bravo vous êtes bien inscrit !');

                } else {
                    $this->session->setError('inscription', 'Mot de passe différent');
                }
        }

        $this->data = $this->database->read('users', $id_user, 'id', true);

        $response = [ 'path' => 'AdminView/Pages/updateUsers.twig',
            'data' => ['users' => $this->data],
        ];

        return $response;
    }

    public function createAction(){

            $username = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_SPECIAL_CHARS);
            $eamail = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'inputPassword1', FILTER_SANITIZE_STRING);
            $passwordVerif = filter_input(INPUT_POST, 'inputPassword2', FILTER_SANITIZE_STRING);
            $nom = filter_input(INPUT_POST, 'inputNom', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'inputPrenom', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($username !== null && $eamail !== null
                && $password !== null && $passwordVerif !== null) {

                $this->users = $this->database->read('users', $eamail, 'email', true);

                if ($this->users === '') {

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

        $response = [ 'path' => 'AdminView/Pages/createUsers.twig',
            'data' => ['users' => $this->data],
        ];

        return $response; ;
    }
}