<?php  function SEND_EMAIL_ENVOI_POA_IADFRANCE($connection_database2, $id_affiliate, $serveur, $mode, $path_nosrezo_racine )
{    

     require $path_nosrezo_racine."/scripts/config.php";     
     mysql_query('SET NAMES utf8');
	 List( $id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p, $address_p, $zip_code_p, $city_p, $firt_last_id , $is_activated, $last_connection_date, $password, $is_protected  ) = RETURN_INFO_AFFILIATE($id_affiliate);
	 
	 $mail_destinataire     = $email_p; 
	 
	         IF ( $mode == "TEST") // TESTER L'ENVOI DU MAIL
	         {
	             $mail_destinataire          = "benjamin.allais@gmail.com"; 	 
	             $mail_cc                    = "benjamin.allais@gmail.com";
	         }
			 
	
require_once $path_nosrezo_racine."/phpmailer/class.phpmailer.php"; 
            $mail = new PHPmailer(); 
            $mail->IsMail(); 
            $mail->IsHTML(true); 
            $mail->Host       = $host_mail ; 
            $mail->Username   = $user_mail ;
            $mail->Password   = $password ;
            $mail->From       = 'contact@nosrezo.com'; 
            $mail->AddAddress($mail_destinataire); 
            $mail->AddAddress('xavier.join@iadfrance.fr'); 
            $mail->AddAddress('contact@nosrezo.com'); 
            $mail->AddReplyTo('contact@nosrezo.com');      
            $mail->Subject =" Envie de changer de vie ? ";			

$mail->Body = "

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1' />
  <title>Déclaration préalable de Travaux | Groupe Triforce</title>
  <style type='text/css'>
.ReadMsgBody { width: 100%; background-color: #ffffff; }
.ExternalClass { width: 100%; background-color: #ffffff; }
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
html { width: 100%; }
body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }
table { border-spacing: 0; border-collapse: collapse; table-layout: fixed; margin: 0 auto; }
table table table { table-layout: auto; }
img { display: block !important; }
table td { border-collapse: collapse; }
.yshortcuts a { border-bottom: none !important; }
img:hover { opacity:0.9 !important;}
a { color: #1ba9d3; text-decoration: none; }
.textbutton a { font-family: 'open sans', arial, sans-serif !important; color: #ffffff !important; }
.text-link a { color: #EE7633 !important; }
.bold {font-weight: 500;}
.orange {color: #EE7633}

@media only screen and (max-width: 640px) {
body { width: auto !important; }
table[class='table-inner'] { width: 90% !important; }
table[class='table-full'] { width: 100% !important; text-align: center !important; }
/* Image */
img[class='img1'] { width: 100% !important; height: auto !important; }
}

@media only screen and (max-width: 479px) {
body { width: auto !important; }
table[class='table-inner'] { width: 290px !important; }
table[class='table-inner'] { width: 90% !important; }
table[class='table-full'] { width: 100% !important; text-align: center !important; }
/* Image */
img[class='img1'] { width: 100% !important; height: auto !important; }
}
</style>
</head>

<body>
  <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#fff' style='background-size:cover; background-position:center;'>
    <tr>
      <td align='center'>
        <table class='table-inner' width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
          <tr>
            <td height='10'></td>
          </tr>
          <tr>
            <td align='center' style='border-top:1px solid #1ba9d3; border-radius:4px;' bgcolor='#FFFFFF'>
              <table width='550' align='center' class='table-inner' border='0' cellspacing='0' cellpadding='0'>

                <tr>
                  <td>
                    <tr>
                    <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:14px; font-weight:600; color:#1ba9d3; line-height:20px;'>Objet : Invitation gratuite a un événement</td> 
                    </tr>
                    </table>
                  </td>
                </tr>
               
              </table>
            </td>
          </tr>
          <tr>
            <td align='center' bgcolor='#FFFFFF' style=' border-radius:4px;'>
              <table align='center' class='table-inner' width='500' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td height='20'></td>
                </tr>
                <!-- content -->
				
                <tr>
                  <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:12px; font-weight:400; color:#7f8c8d; line-height:20px;'>Bonjour $first_name_p,  
                  </td>
                </tr>
				
                <tr>
                  <td height='20'></td>
                </tr>
				
                <tr>
                  <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:12px; font-weight:400; color:#7f8c8d; line-height:20px;'>
				  		   En tant qu'affilié <b>NosRezo</b> nous avons le plaisir de te communiquer en avant première cette information.<br/>
						   <b>IAD France</b>, partenaire privilégié de NosRezo est le premier réseau immobilier de France avec plus de 3 200 conseillers répartis sur le territoire. Dans le cadre de son développement, IAD s'implante dorénavant sur la région Auvergne : Nous allons donc recruter dès cet automne plusieurs conseillers immobiliers.<br/>
                  </td>
                </tr>
				
                <tr>
                  <td height='20'></td>
                </tr>				

                <tr>
                  <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:12px; font-weight:200; color:#7f8c8d; line-height:20px;'>
				  <b>Le secteur de l'immobilier t'intéresse  ? Tu souhaites faire profiter de cette opportunité à quelqu'un de ton entourage ?  </b>
                </tr>
				
                <tr>
                  <td height='20'></td>
                </tr>				

                <tr>
                  <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:12px; font-weight:200; color:#7f8c8d; line-height:20px;'>
				  Nous  t'invitons à venir assister à une réunion d'information qui se déroulera le 14 septembre à 19h à l'Epicentre Factory. (5 rue St Dominique 63 000 Clermont Ferrand). <br/> <br/>
				  Inscription obligatoire car les places sont limitées.
                </tr>				
				
				
                <tr>
                  <td height='20'></td>
                </tr>
                <tr>
            <td>
              <!-- left -->
             <table align='left' width='200' border='0' cellspacing='0' cellpadding='0'>

                <tr>
                    <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:12px; font-weight:200; color:#1ba9d3; line-height:30px;'>Xavier JOIN</td>
                </tr>
                <tr>
                    <td class='text-link' align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:11px; font-weight:200; color:#7f8c8d; line-height:15px;'>+33(0)6 62 25 29 96</td>
                </tr>
                <tr>
                    <td align='left' style='font-family: Open Sans, Arial, sans-serif; font-size:11px; font-weight:300; color:#1ba9d3; line-height:15px;'><a href='mailto:xavier.join@iadfrance.fr'> xavier.join@iadfrance.fr</a></td>
                </tr>
              </table>
              <!-- end left -->
            </td>
          </tr>
              </table>
            </td>
          </tr>
          <tr>
             <td height='40'></td>
          </tr>
          <tr>
            <td>
              <!-- left -->
              <table align='left' class='table-full' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td style='font-family: Open Sans, Arial, sans-serif; font-size:09px; color:#bec1c9; line-height:15px;'> © 2016 Groupe NosRezo, pour ne plus recevoir de mail, répondez stop à ce dernier. </td>
                </tr>
              </table>
              <!-- end left -->
              <!--Space-->
              <table width='1' height='25' border='0' cellpadding='0' cellspacing='0' align='left'>
                <tr>
                  <td height='25' style='font-size: 0;line-height: 0;border-collapse: collapse;'>
                    <p style='padding-left: 24px;'>&nbsp;</p>
                  </td>
                </tr>
              </table>
              <!--End Space-->
              
            </td>
          </tr>
          <!-- option -->
          <tr>
            <td height='60'></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>

";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  	

             IF ($serveur == 'PRODUCTION')
             { 
                 if(!$mail->Send()) { echo $mail->ErrorInfo;} 
                 else               { echo '>>. Mail envoyé avec succès <br/>'; } 
                 $mail->SmtpClose(); 
                 unset($mail); 			
	         }	
	
  
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>