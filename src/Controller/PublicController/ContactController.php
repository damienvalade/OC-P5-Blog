<?php

namespace App\Controller\PublicController;

use Core\Controller\FrontController;
use Core\Model\Mail\Mail;
use Core\Model\View\View;

/**
 * Class ContactController
 * @package App\Controller\PublicController
 */
class ContactController extends FrontController
{
    /**
     * @var Mail
     */
    protected $mail;

    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->mail = new Mail();
        $this->view->addView();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $sujet = filter_input(INPUT_POST, 'sujet', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        if ($nom !== null && $email !== null && $sujet !== null && $message !== null) {

            $data = [
                'expediteur' => $email,
                'nom-expediteur' => $nom,
                'objet' => $sujet,
                'message' => $message
            ];

            if($this->mail->mailTo($data) === true){
                $this->cookies->setCookies('mail', 'V - Message envoyer');
            }else{
                $this->cookies->setCookies('mail', 'E - Problème d\\\'envoie du mail');
            }

            $this->redirect('/public/contact');

        }
        $response = [ 'path' => 'PublicView/Pages/contact.twig',
            'data' => []
        ];

        return $response;
    }
}
