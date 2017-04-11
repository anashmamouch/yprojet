<?php  /// PLANNIFICATEUR DE TACHE N°2
       /// FREQUENCE : TOUS LES JOURS A 11H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
	   /// 10 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/2_cron_jour_light.php
	   /// Press the Esc key and type :x and press ENTER to exit and save changes.
       /// 33 3 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/1_cron_nuit.php
       /// 30 10 * * 5 /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/4_cron_once_a_week.php.php		 // TOUS LES VENDREDIS   
		 	
		 $NosRezo_scripts          = dirname(dirname(__FILE__));
		 $NosRezo_racine           = dirname($NosRezo_scripts);	   
		 require($NosRezo_scripts.'/config.php');                       
         require($NosRezo_scripts.'/function_12345678910.php');
         require($NosRezo_scripts.'/functions.php');
		 $src_banniere = "<img style='border-radius:0px;' src='http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG'  > ";
         $src_carre    = "<img style='border-radius:0px;' src='http://www.nosrezo.com/fichiers/carre_bleu3.PNG'              > ";
		 
         $rapport_Load  = "";
		 $date_debut    = strtotime(date('Y-m-d H:i:s',time()));
		 $retour1       = "<br/>"; 
		 $retour2       = "<br/><br/>";     	     
		 $retour3       = "<br/><br/><br/>";
         $log_rapport   = date('Y-m-d H:i:s',time()+3600)." - SCRIPT 4_cron_once_a_week.php ".$retour2;

	 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. RELANCE CONTRATS PARTENAIRES    	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - RELANCE CONTRATS PARTENAIRES  ".$retour1;		 
		 $rapport_class = RELANCE_PARTENAIRE_DOCUMENTS_MISSING($NosRezo_racine);
         $log_rapport   = $log_rapport." ".$rapport_class.$retour2;		 

/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 2. DÉSACTIVATION DES PARTENAIRES QUI N'ONT TOUJOURS PAS ENVOYÉS LEURS DOCUMENTS    	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - DÉSACTIVATION PARTENAIRES  ".$retour1;		 
		 $rapport_class = DESACTIVATED_PARTENAIRE_DOCUMENTS_MISSING($NosRezo_racine);
         $log_rapport   = $log_rapport." ".$rapport_class.$retour2;	

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 2. FIN DU SCRIPT 	  
         $log_rapport    = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - FIN DU SCRIPT  ".$retour1;
         $date_fin       = strtotime(date('Y-m-d H:i:s',time()));
         $diff           = ($date_fin - $date_debut); 
         $secondes       = $diff % 60;
         $minutes        = floor( ($diff - $secondes) /60 )% 60;

		 $log_rapport    = $log_rapport." &nbsp &nbsp &nbsp &nbsp >> ".$minutes." min - ".$secondes." sec.";		 
		 

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// X. ENVOI MAIL DE RAPPORT 		  

$mail  = "contact@nosrezo.com";		
		 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body>
      <div style='width:auto height:auto; margin-top:0px;'  >
	    $src_banniere
     </div>
     <div style='width:auto; height:auto; margin-top:2px;   background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
RAPPORT CRON, <br />
<br />
$log_rapport <br />
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NR.<br />
<a href='www.nosrezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "CRON - CONTRAT / ASSURANCE PARTENAIRE ";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
//$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
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
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////



		 

?>

