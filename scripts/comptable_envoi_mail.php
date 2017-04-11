<?php  function ENVOI_COMPTABLE($connection_database2, $path_nosrezo_racine, $file_name)
{       
     require $path_nosrezo_racine."/scripts/config.php"; 	 
	 mysql_query('SET NAMES utf8');
	 
     $mail_destinataire          = "benjamin.allais@gmail.com"; 


	
require_once $path_nosrezo_racine."/phpmailer/class.phpmailer.php"; 
            $mail = new PHPmailer(); 
            $mail->IsMail(); 
            $mail->IsHTML(true); 
            $mail->Host       = $host_mail ; 
            $mail->Username   = $user_mail ;
            $mail->Password   = $password ;
            $mail->From       = 'contact@nosrezo.com'; 
            $mail->AddAddress($mail_destinataire); 
            $mail->AddAddress('contact@nosrezo.com'); 
            $mail->AddAddress('cy-florette@soregor.fr'); 
            $mail->AddReplyTo('contact@nosrezo.com');      
            $mail->Subject ='Fichier Comptable NosRezo'; 

//=====Déclaration des messages au format texte et au format HTML.
            $src          = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
            $src_carre    = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
            $src_facebook = 'http://www.nosrezo.com/fichiers/facebook.png';
            $src_twitter  = 'http://www.nosrezo.com/fichiers/twitter.png';

$mail->Body = "
<html><head></head><body style='background-color:#FFFFFF;'>
     <div style='width:auto height:auto; margin-top:0px; border-color:#FFFFFF; ' >
	    <img src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px;   background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour Cynthia, <br /> 
<br />
Comme attendu, vous trouverez ci-joint un export automatique de nos bases  <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>.  <br /><br />
En cas de question n'hésitez pas à revenir vers Karim qui est responsable Europe de l'ensemble de la stratégie, du juridique, de la comptabilité, du développement, des RH et aussi des timbres. 
<br />

</p>
</div>
<br />
     <div style='width:auto; height:auto; margin-top:2px;    background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>

<br />
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
Benjamin, stagiaire confirmé de la Team NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>NosRezo.com</b></a><br />
<br />
</p>
</div>
<div style='width:auto height:auto; margin-top:15px; background-color:#2886c9; border-style: solid; text-align:center; border-radius:3px;   border-color:#2375b0;' >
	    <a href=\"https://www.facebook.com/pages/Nosrezo/331807033627841\" target=\"_blank\"><img style='text-align: center;' src=$src_facebook ></a> 	
	    <a href=\"https://twitter.com/NosRezeaux?refsrc=email\" target=\"_blank\"><img style='text-align: center; margin-left:20px;' src=$src_twitter ></a> 	
</div>

 
 </body></html>	";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
// Pièce jointe 1
$path         = $path_nosrezo_racine.'/scripts/reporting/comptable/';
	
         IF (file_exists($path.$file_name))
         {
            $mail->AddAttachment($path.$file_name); 
 
             IF ($serveur == 'PRODUCTION')
             { 
                 if(!$mail->Send()) { echo $mail->ErrorInfo;} 
                 else               { echo '>>. Mail envoyé avec succès <br/>'; } 
                 $mail->SmtpClose(); 
                 unset($mail); 			
	         }	
         }	
         ELSE 
         { 
             echo "&nbsp &nbsp  Le fichier ".$path.$file_name ." n'est pas encore cree sur le serveur.  <br/>";
         }  
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>