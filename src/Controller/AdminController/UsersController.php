<?php


namespace App\Controller\AdminController;


use App\Controller\ErrorsController\ErrorsController;
use App\Model\AdminModel\UsersModel;
use Core\Controller\FrontController;

/**
 * Class UsersController
 * @package App\Controller\AdminController
 */
class UsersController extends FrontController
{

    /**
     * @var UsersModel
     */
    protected $database;

    /**
     * @var
     */
    protected $pathErrors;


    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->database = new UsersModel();
        $errors = new ErrorsController();

        if ($this->cookies->dataJWT('user', 'level') > 1 || $this->cookies->dataJWT('user', 'level') === false) {
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

            $users = $this->database->innerjoin();

            $this->response = ['path' => 'AdminView/Pages/users.twig',
                'data' => ['users' => $users]
            ];

        }
        return $this->response;
    }

    /**
     * @return array
     */
    public function updateAction()
    {
        if (!isset($this->response)) {

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

                $nameReplace = str_replace('-','_',$username);
                $nameReplace = str_replace(' ','_',$nameReplace);

                if ($password === $passwordVerif) {
                    $data = [
                        'firstname' => $prenom,
                        'name' => $nom,
                        'username' => $username,
                        'password' => $password,
                        'email' => $eamail,
                        'image' => '\\\\img\\\\photoprofil\\\\' . $filename,
                    ];

                    $this->database->update('users', $id_user, $data, 'id');

                    $this->cookies->setCookies('users', 'V - Utilisateur mis à jour !');
                    $this->redirect('/admin/users');

                } else {
                    $this->cookies->setCookies('users', 'E - Mot de passe différent');
                    $this->redirect("/admin/users/update/$nameReplace-$id_user");
                }
            }

            $users = $this->database->read('users', $id_user, 'id', false);

            $this->response = ['path' => 'AdminView/Pages/updateUsers.twig',
                'data' => ['users' => $users],
            ];
        }

        return $this->response;
    }

    /**
     * @return array
     */
    public function createAction()
    {

        if (!isset($this->response)) {

            $username = filter_input(INPUT_POST, 'inputName', FILTER_SANITIZE_SPECIAL_CHARS);
            $eamail = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'inputPassword1', FILTER_SANITIZE_STRING);
            $passwordVerif = filter_input(INPUT_POST, 'inputPassword2', FILTER_SANITIZE_STRING);
            $nom = filter_input(INPUT_POST, 'inputNom', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'inputPrenom', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($username !== null && $eamail !== null
                && $password !== null && $passwordVerif !== null) {

                $this->users = $this->database->read('users', $eamail, 'email', false);

                if (empty($this->users) === true) {

                    $filename = $this->upload('photoprofil', $username);

                    if ($password === $passwordVerif) {
                        $data = [
                            'firstname' => $prenom,
                            'name' => $nom,
                            'username' => $username,
                            'password' => password_hash($password,PASSWORD_DEFAULT),
                            'email' => $eamail,
                            'image' => '\\\\\\img\\\\photoprofil\\\\' . $filename,
                            'level_administration' => '3'
                        ];

                        $this->database->create('users', $data);

                        $this->cookies->setCookies('users', 'V - Utilisateur bien inscrit !');
                        $this->redirect('/admin/users');

                    } else {
                        $this->cookies->setCookies('users', 'E - Mot de passe différent !');
                        $this->redirect('/admin/users/create');
                    }
                } else {
                    $this->cookies->setCookies('users', 'E - Adresse Email déjà utilisé !');
                    $this->redirect('/admin/users/create');
                }
            }

            $this->response = ['path' => 'AdminView/Pages/createUsers.twig',
                'data' => [],
            ];
        }

        return $this->response;
    }

    /**
     * @return array
     */
    public function deleteAction()
    {

        if (!isset($this->response)) {

            $id_users = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $article = $this->database->read('articles', $id_users, 'id_auteur', false);
            $commentaire = $this->database->read('commentaire', $id_users, 'id_auteur', false);

            foreach ($commentaire as $commentaire) {
                $this->database->delete('commentaire', $commentaire['id']);
            }

            foreach ($article as $article) {
                $this->database->delete('commentaire', $article['id'], 'id_article');
                $this->database->delete('articles', $article['id']);
            }

            $this->database->delete('users', $id_users);

        }

        $this->cookies->setCookies('users', 'V - Utilisateur bien supprimer !');
        $this->redirect('/admin/users');

        return self::indexAction();
    }
}
