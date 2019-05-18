<?php


namespace App\Controller\AdminController;


use Core\Model\Model;
use Core\Session\Session;

class UserssettingsController
{

    protected $data;
    protected $database;

    public function __construct()
    {
        $this->database = new Model();
    }

    public function indexAction()
    {
        if( Session::isLogged())
        {
            if( Session::isAdmin() === true){

                $this->data = $this->database->read('users');

                return ['users' => $this->data] ;

            }else{
                exit($this->unauthorized());
            }
        }else{
            exit($this->unauthorized());
        }
    }
}