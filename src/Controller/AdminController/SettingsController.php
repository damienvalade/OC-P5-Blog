<?php


namespace App\Controller\AdminController;


use App\Controller\ErrorsController\ErrorsController;
use App\Model\AdminModel\SettingsModel;
use Core\Controller\FrontController;

/**
 * Class SettingsController
 * @package App\Controller\AdminController
 */
class SettingsController extends FrontController
{

    /**
     * @var Model
     */
    protected $database;
    /**
     * @var array
     */
    protected $response;

    /**
     * SettingsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->database = new SettingsModel();
        $errors = new ErrorsController();

        if ($this->cookies->dataJWT('user', 'level') === false) {
            $this->response = ['path' => $errors->unauthorized(),
                'data' => []
            ];
        }
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        if (!isset($this->response)) {

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
                        'password' => password_hash($password,PASSWORD_DEFAULT),
                        'email' => $eamail,
                        'image' => '\\\\img\\\\photoprofil\\\\' . $filename,
                    ];

                    $this->database->update('users', $id_user, $data, 'id');

                    $this->cookies->setCookies('settings', 'V - Profil mis à jour !');
                    $this->redirect("/admin/settings/$id_user");
                } else {
                    $this->cookies->setCookies('settings', 'E - Mot de passe différent');
                    $this->redirect("/admin/settings/$id_user");
                }
            }

            $users = $this->database->read('users', $id_user, 'id', false);

            $this->response = ['path' => 'AdminView/Pages/Settings.twig',
                'data' => ['users' => $users],
            ];
        }

        return $this->response;
    }

}
