<?php  function SEND_EMAIL_INSCRIPTION_NOUVEAU_PORTUGAL($connection_database2, $id_affiliate, $serveur )
{      
	 // REQUETTE DE REMPLISSAGE DU MAIL 
     mysql_query('SET NAMES utf8');
     $result        = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #31! ");
	 $mail          = $result['email'];
	 //$mail          = "benjamin.allais@gmail.com";
     $first_name    = ucwords(strtolower($result['first_name']));
	 $last_name     = $result['last_name'];
	 $zip_code      = $result['zip_code'];
	 $city          = $result['city'];	 
	 
 
	 $parrain       = nom_prenom_id_parrain_affilie($connection_database2, return_id_parrain($id_affiliate));	 
	 $mail_cc       = mail_parrain_affilie($id_affiliate); 
	 
 	 $dn2    = mysql_fetch_array(mysql_query('SELECT password FROM affiliate WHERE id_affiliate = "'.$id_affiliate.'"    ')) or die("."); 
     $mdp    = $dn2['password'];

		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$message_txt = "script PHP.";
$message_html = "

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1' />
  <title>NosRezo</title>
  <style type='text/css'>
.ReadMsgBody { width: 100%; background-color: #ffffff; }
.ExternalClass { width: 100%; background-color: #ffffff; }
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
html { width: 100%; }
body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }
table { border-spacing: 0; border-collapse: collapse; table-layout: fixed; margin: 0 auto; }
table table table { table-layout: auto; }
img { display: block !important; over-flow: hidden !important; }
table td { border-collapse: collapse; }
.yshortcuts a { border-bottom: none !important; }
img:hover { opacity:0.9 !important;}
a { color: #14c1e0; text-decoration: none; }
span { font-weight: 600 !important; }
.textbutton a { font-family: 'open sans', arial, sans-serif !important; color: #ffffff; }
.preference a { color: #14c1e0 !important; text-decoration: underline !important; }

/*Responsive*/
@media only screen and (max-width: 640px) {
body { width: auto !important; }
table[class='table-inner'] { width: 90% !important; }
table[class='table-full'] { width: 100% !important; text-align: center !important; }
/* Image */
img[class='img1'] { width: 100% !important; height: auto !important; }
}

@media only screen and (max-width: 479px) {
body { width: auto !important; }
table[class='table-inner'] { width: 90% !important; }
table[class='table-full'] { width: 100% !important; text-align: center !important; }
/* image */
img[class='img1'] { width: 100% !important; height: auto !important; }
}
</style>
</head>

<body>
  <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#FAFAFA'>
    <tr>
      <td align='center' height='25'></td>
    </tr>
    <tr>
      <td align='center'>
        <table align='center' class='table-inner' width='500' border='0' cellspacing='0' cellpadding='0'>
          <!--Header Logo-->
          <tr>
            <td align='left' style='line-height: 0px;'><img style='display:block; line-height:0px; font-size:0px; border:0px;'   src='http://www.nosrezo.com/fichiers/images_email/logo.png' alt='logo' width='150' height='50' /></td>
          </tr>
          <!--end Header Logo-->
          <tr>
            <td height='5'></td>
          </tr>
          <!--slogan-->
          <tr>
            <td align='left' style=\"font-family: 'Open Sans', Arial, sans-serif; color:#898989; font-size:11px;line-height: 28px; font-style:; font-weight:200;\">Você inscreveu à comunidade NosRezo</td>
          </tr>
          <!--end slogan-->
          <tr>
            <td height='20'></td>
          </tr>
        </table>
        <table bgcolor='#14c1e0' background='http://www.nosrezo.com/fichiers/images_email/container-bg.png' style='border-top-left-radius:6px;border-top-right-radius:6px; background-size:100% auto; background-repeat:repeat-x;' width='500' border='0' align='center' cellpadding='0' cellspacing='0' class='table-inner'>
          <tr>
            <td height='50'></td>
          </tr>
          <tr>
            <td align='center'>
              <table class='table-inner' align='center' width='400' border='0' cellspacing='0' cellpadding='0'>
                <!--title-->
                <tr>
                  <td align='center' style=\"font-family: 'Century Gothic', Arial, sans-serif; color:#ffffff; font-size:24px;font-weight: bold; letter-spacing: 1px;\">Bem-vindo $first_name,</td>
                </tr>
                <!--end title-->
                <tr>
                  <td height='30'></td>
                </tr>
                <!--content-->
                <tr>
                  <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> Acaba de integrar NosRezo, portal líder na Europa em recomendação de negócios</td>
                </tr>
                <tr>
                  <td height='20'></td>
                </tr>
                <tr>
                  <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\">
                                         <u>A sua cidade</u> :  <b>  $zip_code $city </b> <br />
                                         <u>Padrinho</u> :  <b>  $parrain </b> <br />
                                         <u>O seu utilizador</u> : <b>  <font color=#2d5f8b> $id_affiliate </font></b> <br />
                                         <u>A sua senha</u> : <b>  <font color=#2d5f8b> $mdp </font></b> <br /> 
									<br/>				  
				  </td>
                </tr>

              </table>
            </td>
          </tr>
        </table>
        <table bgcolor='#FFFFFF' style='border-bottom-left-radius:6px;border-bottom-right-radius:6px;' align='center' class='table-inner' width='500' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='35'></td>
          </tr>
          <tr>
            <td align='center'>
              <table align='center' class='table-inner' width='420' border='0' cellspacing='0' cellpadding='0'>
                <!--content-->
                <tr>
                  <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#7f8c8d; font-size:12px; line-height: 20px; font-weight:200;\"> Pode agora conectar-se à sua conta NosRezo a partir do seu computador ou da sua aplicação. <br/><br/> Na sua primeira conexão, sugerimos que personalize o seu código de acesso e que preencha o seu perfil no menu “O meu perfil”. </td>
                </tr>
                <!--end content-->
                <tr>
                  <td height='25'></td>
                </tr>
                <!--button-->
                <tr>
                  <td align='center'>
                    <!--left-->
                    <table width='420' border='0' align='left' cellpadding='0' cellspacing='0' class='table-full'>
                      <tr>
                        <td align='center'>
                          <table class='table-full' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#14c1e0' style='border-radius:4px;'>
                            <tr>
                              <td class='textbutton' height='40' align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#FFFFFF; font-size:14px;padding-left: 20px;padding-right: 20px; font-weight:200;\"><a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' >conectar-se</a></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td> 
                </tr>
                <tr>
                  <td height='40'></td>
                </tr>
     
               <table class='buttonbox' border='0' align='center' cellpadding='0' cellspacing='0'>
                      <tr>
                        <td>
                          <!--left-->
                          <table width='150' align='left'  border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <!--image-->
                                <td align='center' style='line-height: 0px;'><a href='https://itunes.apple.com/fr/app/nosrezo-france/id1054618680?mt=8' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_apple_pt.png' alt='img' width='150' height='auto' /></a></td> 
                                <!--end image-->
                            </tr>
                          </table>
                          <!--end left-->
                          <!--Space-->
                          <table width='1' border='0' cellpadding='0' cellspacing='0' align='left'>
                            <tr>
                              <td height='30' style='font-size: 0;line-height: 0px;border-collapse: collapse;'>
                                <p style='padding-left: 20px;'>&nbsp;</p>
                              </td>
                            </tr>
                          </table>
                          <!--End Space-->
                          <!--right-->
                          <table width='150' align='right'  border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                               <!--image-->
                              <td align='center' style='line-height: 0px;'><a href='https://play.google.com/store/apps/details?id=com.nosrezo.appnosrezo2&hl=fr' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_android_pt.png' alt='img' width='150' height='auto' /></a></td> 
                              <!--end image-->
                            </tr>
                          </table>
                          <!--end right-->
                        </td>
                      </tr>
                       <tr>
                        <td height='40'></td>
                       </tr>
                    </table>
                  
                <!--end button-->
              </table>
            </td>
          </tr>
          <tr>
            <td height='45'></td>
          </tr>
        </table>
        <table align='center' class='table-inner' width='500' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td height='10'></td>
          </tr>
          <tr>
            <td align='left' class='preference' style=\"font-family: 'Open sans', Arial, sans-serif; color:#95a5a6; font-size:10px; line-height:14px; font-weight:100;\"> Este mensage foi enviado ao <a href='mailto:$mail'>$mail</a>. Se jà nao quer receber nosso messagem, você pode modificar vossas preferências do vosso perfil.	
            </td>
          </tr>
          <tr>
            <td height='10'></td>
          </tr>
          <tr>
              
            <td align='left'>
              <!--social-->
              <table width='60' border='0' align='left' cellpadding='0' cellspacing='0'>
                <tr>
                  <td align='left' style='line-height: 0px;'>
                    <a href='https://www.facebook.com/Nosrezo-331807033627841/'> <img style='display:block; line-height:0px; font-size:0px; border:0px;' src='http://www.nosrezo.com/fichiers/images_email/facebook.png' alt='img' /> </a>
                  </td>
                  <td width='5'></td>
                  <td align='left' style='line-height: 0px;'>
                    <a href='https://twitter.com/NosRezeaux'> <img style='display:block; line-height:0px; font-size:0px; border:0px;' src='http://www.nosrezo.com/fichiers/images_email/twitter.png' alt='img' /> </a>
                  </td>
                  <td width='5'></td>
                  <td align='left' style='line-height: 0px;'>
                    <a href='https://www.linkedin.com/company/10423174?trk=tyah&trkInfo=clickedVertical%3Acompany%2CclickedEntityId%3A10423174%2Cidx%3A1-1-1%2CtarId%3A1454885076375%2Ctas%3Anosrezo'> <img style='display:block; line-height:0px; font-size:0px; border:0px;' src='http://www.nosrezo.com/fichiers/images_email/linkedin.png' alt='img' /> </a>
                  </td>
                </tr>
              </table>
              <!--end social-->
            </td>
              
          </tr>
          <tr>
            <td height='30'></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html> ";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = " Bem-vindo(a) ao NosRezo ! ";
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
//$header.= "Cc:".$mail_cc."".$passage_ligne;
$header.= "Cc:".$mail_cc.", contact@nosrezo.com, karim@nosrezo.com ".$passage_ligne;
//$header.= "Cci: karim.ouali@iadfrance.fr ".$passage_ligne;
$header.= "Reply-to: ".$mail_cc.$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
