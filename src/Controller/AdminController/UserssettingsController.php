<?php


namespace App\Controller\AdminController;


use App\Model\AdminModel\UserssettingsModel;
use Core\Controller\Session\Session;

class UserssettingsController
{

    protected $data;
    protected $database;

    public function __construct()
    {
        $this->database = new UserssettingsModel();
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
        // TODO
    }

    public function createAction(){
        // TODO
    }
}