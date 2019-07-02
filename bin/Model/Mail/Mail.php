<?php


namespace Core\Model\Mail;


use Core\Controller\Cookies\Cookies;
use Core\Model\Model;

/**
 * Class Mail
 * @package Core\Model\Mail
 */
class Mail
{

    /**
     * @var Model
     */
    protected $database;
    /**
     * @var Cookies
     */
    protected $coockie;
    /**
     * @var false|string
     */
    protected $date;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->coockie = new Cookies();
        $this->database = new Model();

        date_default_timezone_set('Europe/Paris');
        $this->date = date('Y-m-d H:i:s');
    }

    /**
     * @param string $destinataire
     * @param string $objet
     * @param string $message
     * @param string $headers
     * @return bool
     */
    public function send(string $destinataire, string $objet, string $message, string $headers)
    {
        if (mail($destinataire, $objet, $message, $headers)) {
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     */
    public function mailTo(array $data)
    {

        $destinataire = 'fireteam87@gmail.com';
        $expediteur = $data['expediteur'];
        $nomExpediteur = $data['nom-expediteur'];
        $objet = $data['objet'];
        $message = self::designMail($nomExpediteur, $data['message']);


        $headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Reply-To: ' . $expediteur . "\n"; // Mail de reponse
        $headers .= 'From: <' . $nomExpediteur . '>' . "\n"; // Expediteur
        $headers .= 'Delivered-to: ' . $destinataire . "\n"; // Destinataire

        if (self::send($destinataire, $objet, $message, $headers)) {

            $request = [
                'email' => $expediteur,
                'nom' => $nomExpediteur,
                'objet' => $objet,
                'message' => $data['message'],
                'date' => $this->date
            ];

            $this->database->create('mail',$request);

            $data['objet'] = 'Message : ' . $data['objet'] . '. A bien été envoyer';
            $data['message'] = 'Rappel du message : ' . $data['message'];

            return self::mailCC($data);
        }

        return $this->coockie->setCookies('mail', 'Problème d\\\'envoie du mail');

    }

    /**
     * @param array $data
     */
    public function mailCC(array $data)
    {

        $destinataire = $data['expediteur'];
        $nomExpediteur = 'Damien Valade';
        $expediteur = 'fireteam87@gmail.com';
        $objet = $data['objet'];
        $message = self::designMail($nomExpediteur, $data['message']);

        $headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Reply-To: ' . $expediteur . "\n"; // Mail de reponse
        $headers .= 'From: <' . $nomExpediteur . '>' . "\n"; // Expediteur
        $headers .= 'Delivered-to: ' . $destinataire . "\n"; // Destinataire

        if (self::send($destinataire, $objet, $message, $headers)) {
            return $this->coockie->setCookies('mail', 'Mail envoyer');
        }

    }


    /**
     * @param string $nomExpediteur
     * @param string $message
     * @return string|string
     */
    public function designMail(string $nomExpediteur, string $message)
    {
        $message = '
                <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
                <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


                <style>

                    body {
                        padding: 0;
                        margin: 0;
                        }

                    html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
                    @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
                                *[class="table_width_100"] {
                                    width: 96% !important;
                                }
                    	*[class="border-right_mob"] {
                                    border-right: 1px solid #dddddd;
                    	}
                    	*[class="mob_100"] {
                                    width: 100% !important;
                                }
                    	*[class="mob_center"] {
                                    text-align: center !important;
                    	}
                    	*[class="mob_center_bl"] {
                                    float: none !important;
                    		display: block !important;
                    		margin: 0px auto;
                    	}	
                    	.iage_footer a {
                                    text-decoration: none;
                    		color: #929ca8;
                    	}
                    	img.mob_display_none {
                                    width: 0px !important;
                    		height: 0px !important;
                    		display: none !important;
                    	}
                    	img.mob_width_50 {
                                    width: 40% !important;
                                    height: auto !important;
                    	}
                    }
                    .table_width_100 {
                                width: 680px;
                    }
                   </style>



<div id="mailsub" class="notification" align="center">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">

<table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
    <tr><td>

	</td></tr>

	<tr><td align="center" bgcolor="#ffffff">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td align="center">
			    		<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; text-align:center; font-size: 13px;">
									<font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">
									<img src="https://portfoliov1.damienvalade.fr/img/logo/EMAIL.jpg" width="100%" alt="bandeau" border="0"  /></font></a>
					</td>
					<td align="right">
			</td>
			</tr>
		</table>
	</td></tr>



	<tr><td align="center" bgcolor="#fbfcfd">
	    <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
		<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 3rem; margin-bottom: 3rem">
			<tr><td>
        Message de : ' . $nomExpediteur . '<br/>
		'. $message .'<br/>
			</td></tr>
		</table>
		</font>
	</td></tr>




	<tr><td class="iage_footer" align="center" bgcolor="#ffffff">

		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td align="center" style="padding:20px;flaot:left;width:100%; text-align:center;">
				<font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
				<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
            2019 © CTM. ALL Rights Reserved.
				</span></font>				
			</td></tr>			
		</table>
		
	</td></tr>

	<tr><td>

	</td></tr>
</table>

</td></tr>
</table>

 
</td></tr>
</table>';

        return $message;
    }
}