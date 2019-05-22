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
        if( Session::isLogged())
        {
            if( Session::isAdmin() === true){

                $this->data = $this->database->innerJoin('','','');

                return ['users' => $this->data] ;

            }else{
                exit($this->unauthorized());
            }
        }else{
            exit($this->unauthorized());
        }
    }

    public function updateAction(){

        $id = (int)$_GET['id'];

        $this->data = $this->database->read('users', $id, 'id', true);

        return ['users' => $this->data] ;
    }

    public function createAction(){

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

        return ['users' => $this->data] ;
    }
}