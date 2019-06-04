<?php


namespace App\Controller\AdminController;


class AdministrationController
{

    public function indexAction()
    {
        $response = [ 'path' => 'AdminView/Pages/home.twig',
            'data' => [],
        ];

        return $response;
    }
}