<?php


namespace App\Controller\PublicController;

use Core\Controller\Controller;
use Core\Model\Model;
use Core\Session\Session;

class InscriptionController extends Controller
{
    protected $session;
    protected $users;

    public function __construct()
    {
        $this->session = new Session();
        $this->database = new Model();
    }

    public function IndexAction()
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
    }
}