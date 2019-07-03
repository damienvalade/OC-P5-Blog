<?php


namespace App\Controller\AdminController;


use Core\Controller\FrontController;
use Core\Model\Model;

/**
 * Class SettingsController
 * @package App\Controller\AdminController
 */
class SettingsController extends FrontController
{

    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $id_user = filter_input(INPUT_GET, 'request', FILTER_SANITIZE_NUMBER_INT);

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
                    'image' => '\\\\img\\\\photoprofil\\\\' . $filename,
                    'level_administration' => '3'
                ];

                $this->database->update('users', $id_user, $data, 'id');

                $this->cookies->setCookies('inscription', 'Bravo vous êtes bien inscrit !');

            } else {
                $this->cookies->setCookies('inscription', 'Mot de passe différent');
            }
        }

        $users = $this->database->read('users', $id_user, 'id', false);

        $response = [ 'path' => 'AdminView/Pages/Settings.twig',
            'data' => ['users' => $users],
        ];

        return $response;
    }

}