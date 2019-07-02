<?php


namespace App\Controller\AdminController;


/**
 * Class SettingsController
 * @package App\Controller\AdminController
 */
class SettingsController
{

    /**
     * @return array
     */
    public function indexAction()
    {



        $response = [ 'path' => 'AdminView/Pages/settings.twig',
            'data' => [
            ]
        ];

        return $response;
    }

}