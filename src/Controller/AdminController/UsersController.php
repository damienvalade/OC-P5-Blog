<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\UsersModel;
use Core\Controller\Cookies\Cookies;
use Core\Controller\FrontController;

/**
 * Class UsersController
 * @package App\Controller\AdminController
 */
class UsersController extends FrontController
{

    /**
     * @var
     */
    protected $data;
    /**
     * @var UsersModel
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
        $this->database = new UsersModel();
        $this->cookies = new Cookies();
    }

    /**
     * @return array
     */
    public function indexAction()
    {

        $response = [ 'path' => $this->unauthorized(),
            'data' => [],
        ];

        $users = $this->database->innerjoin();

        if( $this->cookies->dataJWT('user','id') !== false )
        {
            $response = [ 'path' => 'AdminView/Pages/users.twig',
                'data' => ['users' => $users]
            ];

        }

        return $response;
    }

    /**
     * @return array
     */
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

        $response = [ 'path' => 'AdminView/Pages/updateUsers.twig',
            'data' => ['users' => $users],
        ];

        return $response;
    }

    /**
     * @return array
     */
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
                            'image' => '\\\\\\img\\\\photoprofil\\\\' . $filename,
                            'level_administration' => '3'
                        ];

                        $this->database->create('users', $data);

                        $this->cookies->setCookies('inscription', 'Bravo vous êtes bien inscrit !');

                    } else {
                        $this->cookies->setCookies('inscription', 'Mot de passe différent');

                    }
                }else{ $this->cookies->setCookies('inscription', 'Adresse Email déjà utilisé');}
            }

        $response = [ 'path' => 'AdminView/Pages/createUsers.twig',
            'data' => [],
        ];

        return $response; ;
    }

    /**
     * @return array
     */
    public function deleteAction(){

        $id_users = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $article = $this->database->read('articles',$id_users,'id_auteur', false);
        $commentaire = $this->database->read('commentaire',$id_users,'id_auteur', false);

        foreach ( $commentaire as $commentaire){
            $this->database->delete('commentaire', $commentaire['id']);
        }

        foreach ( $article as $article){
            $this->database->delete('commentaire', $article['id'],'id_article');
            $this->database->delete('articles', $article['id']);
        }

        $this->database->delete('users', $id_users);

        return self::indexAction();
    }
}
