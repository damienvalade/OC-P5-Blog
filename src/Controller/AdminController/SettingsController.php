<?php


namespace App\Controller\AdminController;


class SettingsController
{

    public function indexAction()
    {



        $response = [ 'path' => 'AdminView/Pages/settings.twig',
            'data' => [
            ]
        ];

        return $response;
    }

}