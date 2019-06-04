<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\UserssettingsModel;
use Core\Controller\FrontController;
use Core\Controller\Session\Session;

class UserssettingsController extends FrontController
{

    protected $data;
    protected $database;
    protected $session;

    public function __construct()
    {
        $this->database = new UserssettingsModel();
        $this->session = new Session();
    }

    public function indexAction()
    {
        if( $this->session->isLogged())
        {
            if( $this->session->isAdmin() === true){

                $this->data = $this->database->innerJoin();

                $response = [ 'path' => 'AdminView/Pages/userssettings.twig',
                    'data' => ['users' => $this->data]
                ];

            }else{
                $response = [ 'path' => $this->unauthorized(),
                    'data' => []
                ];
            }
        }else{
            $response = [ 'path' => $this->unauthorized(),
                'data' => []
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

                    $this->session->setValidate('inscription', 'Bravo vous êtes bien inscrit !');

                } else {
                    $this->session->setError('inscription', 'Mot de passe différent');
                }
        }

        $this->data = $this->database->read('users', $id_user, 'id', true);

        $response = [ 'path' => 'AdminView/Pages/updateUserssettings.twig',
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

        $response = [ 'path' => 'AdminView/Pages/createUserssettings.twig',
            'data' => ['users' => $this->data],
        ];

        return $response; ;
    }
}