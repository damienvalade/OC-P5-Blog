<?php


namespace App\Controller\AdminController;


use Core\Controller\FrontController;

/**
 * Class SettingsController
 * @package App\Controller\AdminController
 */
class SettingsController extends FrontController
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