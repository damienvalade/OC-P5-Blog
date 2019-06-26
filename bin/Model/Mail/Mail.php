<?php


namespace Core\Model\Mail;


use Core\Controller\Cookies\Cookies;

class Mail
{

    protected $coockie;

    public function __construct()
    {
        $this->coockie = new Cookies();
    }

    public function mailTo(array $data){

        $destinataire = 'fireteam87@gmail.com';
        $expediteur = $data['expediteur'];
        $nomExpediteur = $data['nom-expediteur'];
        $objet = $data['objet'];
        $message = $data['message'];


        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Nom_de_expediteur"<'.$nomExpediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire

        if (mail($destinataire, $objet, $message, $headers))
        {
            $data['objet'] = 'Message : ' . $data['objet'] . '. A bien été envoyer';
            $data['message'] = 'Rappel du message : ' . $data['message'];
            self::mailCC($data);
        }
        else
        {
            $this->coockie->setCookies('mail', 'Problème de envoie du mail');
        }

    }

    public function mailCC(array $data){

        $destinataire = $data['expediteur'];
        $expediteur = 'fireteam87@gmail.com';
        $objet = $data['objet'];
        $message = $data['message'];

        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire

        mail($destinataire, $objet, $message, $headers);

    }

}