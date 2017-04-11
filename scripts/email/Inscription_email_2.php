<?php  function SEND_EMAIL_INSCRIPTION_NOUVEAU($connection_database2, $id_affiliate, $serveur, $link_webinar, $mode, $texte_complement, $titre)
{   // ATTENTION CE SCRIPT CONTIENT PLUSIEURS FUNCTIONS D'ENVOI DE MAIL

     // 1. INFORMATIONS SUR LE DESTINATAIRE	 
     mysql_query('SET NAMES utf8');
     $result        = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #31! ");
	 $mail          = $result['email'];
     $first_name    = ucwords(strtolower($result['first_name']));
	 $last_name     = $result['last_name'];
	 $zip_code      = $result['zip_code'];
	 $city          = $result['city'];	 	 

	 // 2. INFORMATIONS SUR LE PARRAIN
	 List($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p) = RETURN_INFO_AFFILIATE( RETURN_ID_PARRAIN($id_affiliate) );
	 $mail_cc        = $email_p.", karim@nosrezo.com "; //contact@nosrezo.com 
	
     // 2. INFORMATIONS SUR UN TEXTE SPÉCIFIQUE À AFFICHER	 	 
	 $texte_complement  = trim(stripslashes($texte_complement));
	 $texte_complement  = addslashes($texte_complement);
	 IF ( $texte_complement == "10 JOURS" ) 
	     { 
          $texte_complement = "<b>$first_name_p</b> vient de vous offrir une de ses places pour utiliser l'Appli qui rend service et vous rémunère. <br/>
				               <br/>
						       Vous avez <b>10 jours</b> pour valider votre compte gratuit en inscrivant un ami.<br/>
                               <br/> 
                               Vous n’avez que <b>5 places</b>, elles sont précieuses, alors choisissez des personnes en qui vous croyez.
                               <br/>";
	     }
	 ELSE IF ( $texte_complement == "48 HEURES" ) 
	     { 
          $texte_complement = "<b>$first_name_p</b> vous a offert une de ses places pour utiliser l'Appli qui rend service et vous rémunère. <br/>
				               <br/>
						       $first_name, il vous reste <b>48 heures</b> pour inscrire une personne sur NosRezo.<br/>
                               <br/> 
                               Vous n’avez que <b>5 places</b>, elles sont précieuses, alors choisissez des personnes en qui vous croyez.
                               <br/>";
	     }
		 

	 // 3. INFORMATION SUR LE MOT DE PASSE POUR UNE PREMIERE CONNECTION
 	 $dn2            = mysql_fetch_array(mysql_query('SELECT password FROM affiliate WHERE id_affiliate = "'.$id_affiliate.'"    ')) or die("."); 
     $mdp            = $dn2['password'];
	 
	 
	 // 4. FILTRE SPECIFIQUE POUR LES TESTS
     IF ( $mode == "TEST") // TESTER L'ENVOI DU MAIL
     {
         $mail       = "benjamin.allais@gmail.com"; 	 
         $mail_cc    = "benjamin.allais@gmail.com"; // , teamgolf@gmail.com
     }
	 
	 // 5. GESTION DU TITRE DU MAIL
	 IF ( $titre == "" )  { $titre = "Activation de votre compte provisoire NosRezo"; }
	 
		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }
 
                                         //<u>Votre ville</u> :  <b>  $zip_code $city </b> <br />
                                         //<u>Votre Parrain</u> :  <b>  $first_name_p $last_name_p </b> <br />

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
            <td align='left' style=\"font-family: 'Open Sans', Arial, sans-serif; color:#898989; font-size:11px;line-height: 28px; font-style:; font-weight:200;\">
			     Vous êtes inscrit à la communauté NosRezo</td>
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
                  <td align='center' style=\"font-family: 'Century Gothic', Arial, sans-serif; color:#ffffff; font-size:24px;font-weight: bold; letter-spacing: 1px;\">
				      Bienvenue $first_name,</td>
                </tr>
                <!--end title-->
                <tr>
                  <td height='30'></td>
                </tr>
                <!--content-->
                <tr>
                     <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> 
				         $texte_complement 
					 
					 </td>
                </tr>
                <tr>
                  <td height='20'></td>
                </tr>
                <tr>
                  <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\">
                                         <u>Votre identifiant</u> : <b>  <font color=#2d5f8b> $id_affiliate </font></b> <br />
                                         <u>Mot de passe</u> : <b>  <font color=#2d5f8b> $mdp </font></b> <br /> 
									<br/>				  
				  </td>
                </tr>

                  
                <tr>
                         <td height='5'></td>
                </tr>

				
				<tr>
                  <!--image-->
					<td align='center' style='line-height: 0px;'>
						<a href='https://www.youtube.com/watch?v=_XzbcUfpoAI' style='text-decoration: none; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 20px;'> <img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/assets/img/email/video.jpg' alt='img' width='100%' height='auto' /></a>							
					</td>
                  <!--end image-->
				</tr>				
				

                  <td height='40'></td>
				  
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
                  <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#7f8c8d; font-size:12px; line-height: 20px; font-weight:200;\">
						 Une inactivité lors de ces 10 premiers jours entraîne la désactivation <b>définitive</b> de votre compte gratuit : 
                         seule possibilité ensuite, attendre la version Premium payante de Septembre 2017.<br/>
						 <br/>
						 Lors de votre première connexion, nous vous conseillons de personnaliser votre mot de passe et de remplir votre profil depuis l'onglet Mon profil. </td>
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
                              <td class='textbutton' height='40' align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#FFFFFF; font-size:14px;padding-left: 20px;padding-right: 20px; font-weight:200;\"><a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' >Se connecter</a></td>
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
                                <td align='center' style='line-height: 0px;'><a href='https://itunes.apple.com/fr/app/nosrezo-france/id1054618680?mt=8' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_apple.png' alt='img' width='150' height='auto' /></a></td> 
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
                              <td align='center' style='line-height: 0px;'><a href='https://play.google.com/store/apps/details?id=com.nosrezo.appnosrezo2&hl=fr' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_android.png' alt='img' width='150' height='auto' /></a></td> 
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
            <td align='left' class='preference' style=\"font-family: 'Open sans', Arial, sans-serif; color:#95a5a6; font-size:10px; line-height:14px; font-weight:100;\"> Ce message a été envoyé à <a href='mailto:$mail'>$mail</a>. Si vous ne souhaitez plus recevoir nos e-mails, vous pouvez modifier vos préférences dans votre profil.	
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
$sujet = $titre ;
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc:".$mail_cc."".$passage_ligne;
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function SEND_EMAIL_RELANCE_PARRAIN_AVANT_DESACTIVATION($id_affiliate, $serveur, $link_webinar, $mode, $texte_complement, $titre)
{      
     // 1. INFORMATIONS SUR LE DESTINATAIRE	 
     mysql_query('SET NAMES utf8');
     $result        = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate, phone_number FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #31! ");
	 $mail          = $result['email'];
     $first_name    = ucwords(strtolower($result['first_name']));
	 $last_name     = $result['last_name'];
	 $zip_code      = $result['zip_code'];
	 $city          = $result['city'];
     $phone_number  = $result['phone_number'];	 

	 
	 // 2. INFORMATIONS SUR LE PARRAIN
	 List($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p) = RETURN_INFO_AFFILIATE( RETURN_ID_PARRAIN($id_affiliate) );
	 $mail           = $email_p;
	 $mail_cc        = " karim@nosrezo.com "; //contact@nosrezo.com 

	
	
     // 2. INFORMATIONS SUR UN TEXTE SPÉCIFIQUE À AFFICHER	 	 
	 $texte_complement  = trim(stripslashes( $texte_complement ));
	 $texte_complement  = addslashes( $texte_complement );
	 $texte_complement  = strtolower( $texte_complement );
		 
		 
	 // 3. INFORMATION SUR LE MOT DE PASSE POUR UNE PREMIERE CONNECTION
 	 $dn2            = mysql_fetch_array(mysql_query('SELECT password FROM affiliate WHERE id_affiliate = "'.$id_affiliate.'"    ')) or die("."); 
     $mdp            = $dn2['password'];
	 
	 
	 // 4. FILTRE SPECIFIQUE POUR LES TESTS
     IF ( $mode == "TEST") // TESTER L'ENVOI DU MAIL
     {
         $mail       = "benjamin.allais@gmail.com"; 	 
         $mail_cc    = "benjamin.allais@gmail.com"; // , teamgolf@gmail.com
     }
	 
		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }
 
                                         //<u>Votre ville</u> :  <b>  $zip_code $city </b> <br />
                                         //<u>Votre Parrain</u> :  <b>  $first_name_p $last_name_p </b> <br />

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
            <td align='left' style=\"font-family: 'Open Sans', Arial, sans-serif; color:#898989; font-size:11px;line-height: 28px; font-style:; font-weight:200;\">
			     Vous êtes inscrit à la communauté NosRezo</td>
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
                  <td align='center' style=\"font-family: 'Century Gothic', Arial, sans-serif; color:#ffffff; font-size:24px;font-weight: bold; letter-spacing: 1px;\">
				      $first_name_p,</td>
                </tr>
                <!--end title-->
                <tr>
                  <td height='30'></td>
                </tr>
                <!--content-->
                <tr>
                     <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> 
                               Il reste <b>$texte_complement</b> à votre filleul <b>$first_name</b> pour inscrire une personne à son tour.
						       Dans le cas contraire, son compte gratuit sera définitivement supprimé.<br/>
                               <br/> 
                               Vous n’avez que <b>5 places</b>, elles sont précieuses.
                               <br/>
					 
					 </td>
                </tr>
                <tr>
                  <td height='20'></td>
                </tr>
                  
                <tr>
                     <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> 
                               <b>$first_name</b> a-t-il vu cette vidéo ?<br/> 
							   Et si vous la regardiez ensemble ? <br/>
					 </td>
                </tr>

				
				<tr>
                  <!--image-->
					<td align='center' style='line-height: 0px;'>
						<a href='https://www.youtube.com/watch?v=_XzbcUfpoAI' style='text-decoration: none; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 20px;'> <img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/assets/img/email/video.jpg' alt='img' width='100%' height='auto' /></a>							
					</td>
                  <!--end image-->
				</tr>				
				

                  <td height='40'></td>
				  
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

 				 <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#7f8c8d; font-size:12px; line-height: 20px; font-weight:200;\">
						 Une inactivité lors des 10 premiers jours entraîne la désactivation <b>définitive</b> du compte gratuit de <b>$first_name</b> que vous pouvez joindre au $phone_number : 
                         seule possibilité ensuite, attendre la version Premium payante de Septembre 2017.<br/>
						 <br/>
				 </td>

                </tr>
                <!--end content-->

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
                                <td align='center' style='line-height: 0px;'><a href='https://itunes.apple.com/fr/app/nosrezo-france/id1054618680?mt=8' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_apple.png' alt='img' width='150' height='auto' /></a></td> 
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
                              <td align='center' style='line-height: 0px;'><a href='https://play.google.com/store/apps/details?id=com.nosrezo.appnosrezo2&hl=fr' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_android.png' alt='img' width='150' height='auto' /></a></td> 
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
            <td align='left' class='preference' style=\"font-family: 'Open sans', Arial, sans-serif; color:#95a5a6; font-size:10px; line-height:14px; font-weight:100;\"> Ce message a été envoyé à <a href='mailto:$mail'>$mail</a>. Si vous ne souhaitez plus recevoir nos e-mails, vous pouvez modifier vos préférences dans votre profil.	
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
$sujet = $titre ;
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc:".$mail_cc."".$passage_ligne;
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



<?php  function SEND_EMAIL_DESACTIVATION_DU_COMPTE($id_affiliate, $serveur, $link_webinar, $mode, $texte_complement, $titre)
{      
     // 1. INFORMATIONS SUR LE DESTINATAIRE	 
     mysql_query('SET NAMES utf8');
     $result        = mysql_fetch_array(mysql_query(" SELECT af.id_upline, af.password, ad.first_name, ad.last_name, ad.address, ad.zip_code, ad.city, ad.phone_number, ad.email, ad.creation_date, ad.birth_place, ad.nationality, ad.birth_date, af.last_connection_date, af.is_activated, ad.contract_signed, af.id_partenaire , numero_de_pack, contact_association, id_securite_sociale, is_protected
					                                  FROM affiliate_details ad, affiliate af   
					                                  WHERE ad.id_affiliate = af.id_affiliate 
								                      AND ad.id_affiliate   = ".$id_affiliate."  ")) or die("Requete pas comprise - #31! ");
	 $mail          = $result['email'];
     $first_name    = ucwords(strtolower($result['first_name']));
	 $last_name     = $result['last_name'];
	 $zip_code      = $result['zip_code'];
	 $city          = $result['city'];
     $phone_number  = $result['phone_number'];	 
     $id_upline     = $result['id_upline'];	
	 
	 // 2. INFORMATIONS SUR LE PARRAIN
	 List($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p) = RETURN_INFO_AFFILIATE( $id_upline );
	 $mail_cc        = $email_p.", karim@nosrezo.com "; //contact@nosrezo.com 

	
	
     // 2. INFORMATIONS SUR UN TEXTE SPÉCIFIQUE À AFFICHER	 	 
	 $texte_complement  = trim(stripslashes( $texte_complement ));
	 $texte_complement  = addslashes( $texte_complement );
	 $texte_complement  = strtolower( $texte_complement );
		 
		 
	 // 3. INFORMATION SUR LE MOT DE PASSE POUR UNE PREMIERE CONNECTION
 	 $dn2            = mysql_fetch_array(mysql_query('SELECT password FROM affiliate WHERE id_affiliate = "'.$id_affiliate.'"    ')) or die("."); 
     $mdp            = $dn2['password'];
	 
	 
	 // 4. FILTRE SPECIFIQUE POUR LES TESTS
     IF ( $mode == "TEST") // TESTER L'ENVOI DU MAIL
     {
         $mail       = "benjamin.allais@gmail.com"; 	 
         $mail_cc    = "benjamin.allais@gmail.com"; // , teamgolf@gmail.com
     }
	 
		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }
 
                                         //<u>Votre ville</u> :  <b>  $zip_code $city </b> <br />
                                         //<u>Votre Parrain</u> :  <b>  $first_name_p $last_name_p </b> <br />

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
            <td align='left' style=\"font-family: 'Open Sans', Arial, sans-serif; color:#898989; font-size:11px;line-height: 28px; font-style:; font-weight:200;\">
			     Vous êtiez inscrit à la communauté NosRezo</td>
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
                  <td align='center' style=\"font-family: 'Century Gothic', Arial, sans-serif; color:#ffffff; font-size:24px;font-weight: bold; letter-spacing: 1px;\">
				     Bonjour $first_name,</td>
                </tr>
                <!--end title-->
                <tr>
                  <td height='30'></td>
                </tr>
                <!--content-->
                <tr>
                     <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> 
                               Nous sommes au regret de vous informer que votre compte a été <b>désactivé.</b><br/>
                               <br/>
							   Le nombre de places sur NosRezo est limité. <br/>
							   <br/>
                               Nous ne pouvons donc pas nous permettre de garder des profils inactifs.<br/>
                               <br/>
                               Merci pour votre compréhension.<br/>

                               <br/>
					 
					 </td>
                </tr>
                <tr>
                  <td height='20'></td>

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

 				 <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#7f8c8d; font-size:12px; line-height: 20px; font-weight:200;\">
						 Une inactivité lors des 10 premiers jours entraîne la désactivation <b>définitive</b> du compte gratuit : 
                         seule possibilité ensuite, attendre la version Premium payante de Septembre 2017.<br/>
						 <br/>
				 </td>

                </tr>
                <!--end content-->

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
                                <td align='center' style='line-height: 0px;'><a href='https://itunes.apple.com/fr/app/nosrezo-france/id1054618680?mt=8' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_apple.png' alt='img' width='150' height='auto' /></a></td> 
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
                              <td align='center' style='line-height: 0px;'><a href='https://play.google.com/store/apps/details?id=com.nosrezo.appnosrezo2&hl=fr' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_android.png' alt='img' width='150' height='auto' /></a></td> 
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
            <td align='left' class='preference' style=\"font-family: 'Open sans', Arial, sans-serif; color:#95a5a6; font-size:10px; line-height:14px; font-weight:100;\"> Ce message a été envoyé à <a href='mailto:$mail'>$mail</a>. Si vous ne souhaitez plus recevoir nos e-mails, vous pouvez modifier vos préférences dans votre profil.	
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
$sujet = $titre ;
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc:".$mail_cc."".$passage_ligne;
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
         {echo '';} //else {echo 'Mail pas envoye a '.$mail;}
	 }
	 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function SEND_EMAIL_VALIDATION_DU_COMPTE($id_affiliate, $serveur, $link_webinar, $mode, $texte_complement, $titre)
{      
     // 1. INFORMATIONS SUR LE DESTINATAIRE	 
     mysql_query('SET NAMES utf8');
     $result        = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate, phone_number FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #31! ");
	 $mail          = $result['email'];
     $first_name    = ucwords(strtolower($result['first_name']));
	 $last_name     = $result['last_name'];
	 $zip_code      = $result['zip_code'];
	 $city          = $result['city'];
     $phone_number  = $result['phone_number'];	 

	 
	 // 2. INFORMATIONS SUR LE PARRAIN
	 List($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p) = RETURN_INFO_AFFILIATE( RETURN_ID_PARRAIN($id_affiliate) );
	 $mail           = $email_p;
	 $mail_cc        = " karim@nosrezo.com "; //contact@nosrezo.com 

	
	
     // 2. INFORMATIONS SUR UN TEXTE SPÉCIFIQUE À AFFICHER	 	 
	 $texte_complement  = trim(stripslashes( $texte_complement ));
	 $texte_complement  = addslashes( $texte_complement );
	 $texte_complement  = strtolower( $texte_complement );
		 
		 
	 // 3. INFORMATION SUR LE MOT DE PASSE POUR UNE PREMIERE CONNECTION
 	 $dn2            = mysql_fetch_array(mysql_query('SELECT password FROM affiliate WHERE id_affiliate = "'.$id_affiliate.'"    ')) or die("."); 
     $mdp            = $dn2['password'];
	 
	 
	 // 4. FILTRE SPECIFIQUE POUR LES TESTS
     IF ( $mode == "TEST") // TESTER L'ENVOI DU MAIL
     {
         $mail       = "benjamin.allais@gmail.com"; 	 
         $mail_cc    = "benjamin.allais@gmail.com"; // , teamgolf@gmail.com
     }
	 
		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }
 
                                         //<u>Votre ville</u> :  <b>  $zip_code $city </b> <br />
                                         //<u>Votre Parrain</u> :  <b>  $first_name_p $last_name_p </b> <br />

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
            <td align='left' style=\"font-family: 'Open Sans', Arial, sans-serif; color:#898989; font-size:11px;line-height: 28px; font-style:; font-weight:200;\">
			     Vous êtes inscrit à la communauté NosRezo</td>
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
                  <td align='center' style=\"font-family: 'Century Gothic', Arial, sans-serif; color:#ffffff; font-size:24px;font-weight: bold; letter-spacing: 1px;\">
				     Félicitations $first_name_p,</td>
                </tr>
                <!--end title-->
                <tr>
                  <td height='30'></td>
                </tr>
                <!--content-->
                <tr>
                     <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#ffffff; font-size:13px; line-height: 24px; font-weight: 200;\"> 
                               Votre compte Gratuit est <b>validé.</b><br/>
                               <br/>
							   Votre filleul <b>$first_name</b> vient de nous rejoindre. <br/>
							   <br/>
							   Bienvenue dans notre communauté d’entraide et de partage. Vous avez désormais l’opportunité de vous constituer un complément de revenus <b>récurrent</b> et <b>croissant</b>. <br/>
							   <br/>
					 
					 </td>
                </tr>
                <tr>
                  <td height='20'></td>

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

 				 <td align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#7f8c8d; font-size:12px; line-height: 20px; font-weight:200;\">

				 </td>

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
                              <td class='textbutton' height='40' align='center' style=\"font-family: 'Open sans', Arial, sans-serif; color:#FFFFFF; font-size:14px;padding-left: 20px;padding-right: 20px; font-weight:200;\"><a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' >Se connecter</a></td>
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
                                <td align='center' style='line-height: 0px;'><a href='https://itunes.apple.com/fr/app/nosrezo-france/id1054618680?mt=8' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_apple.png' alt='img' width='150' height='auto' /></a></td> 
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
                              <td align='center' style='line-height: 0px;'><a href='https://play.google.com/store/apps/details?id=com.nosrezo.appnosrezo2&hl=fr' target='_blank'><img style='display:block; line-height:0px; font-size:0px; border:0px;' class='img1' src='http://www.nosrezo.com/fichiers/images_email/logo_android.png' alt='img' width='150' height='auto' /></a></td> 
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
            <td align='left' class='preference' style=\"font-family: 'Open sans', Arial, sans-serif; color:#95a5a6; font-size:10px; line-height:14px; font-weight:100;\"> Ce message a été envoyé à <a href='mailto:$mail'>$mail</a>. Si vous ne souhaitez plus recevoir nos e-mails, vous pouvez modifier vos préférences dans votre profil.	
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
$sujet = $titre ;
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc:".$mail_cc."".$passage_ligne;
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





