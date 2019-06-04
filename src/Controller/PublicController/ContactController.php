<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;

class ContactController extends FrontController
{
    public function indexAction()
    {
        $response = [ 'path' => 'PublicView/Pages/contact.twig',
            'data' => []
        ];

        return $response;
    }
}