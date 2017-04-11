<?php  /// PLANNIFICATEUR DE TACHE N°1
       /// FREQUENCE : TOUS LES JOURS A 3H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
	   /// 30 3 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/1_cron_nuit.php
	   /// Press the Esc key and type :x and press ENTER to exit and save changes. 
	   /// CRON EXECUTÉ TOUS LES SOIRS À 23H55
		   
		 $NosRezo_scripts          = dirname(dirname(__FILE__));
		 $NosRezo_racine           = dirname($NosRezo_scripts);	   
		 require($NosRezo_scripts.'/config.php');                       
         require($NosRezo_scripts.'/functions.php');
         require($NosRezo_scripts.'/function_12345678910.php');
		 	
         $rapport_Load  = "";
		 $date_debut    = strtotime(date('Y-m-d H:i:s',time()));
		 $retour1       = "<br/>"; 
		 $retour2       = "<br/><br/>";     	     
		 $retour3       = "<br/><br/><br/>";
         $log_rapport   = date('Y-m-d H:i:s',time()+3600)." - SCRIPT 5_cron_nuit_IAD.php ".$retour2;
		 
		 //mail('benjamin.allais@gmail.com','LANCEMENT DU SCRIT 1', 'BAH ON COMMENCE 	' ); 		 
		 		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. LOAD DU FICHIER IAD FRANCE DES CONSEILLERS	   	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()+3600)."";
		 include($NosRezo_racine.'/scripts/Load_IAD_France_data.php'); 
		 $source_pays_partenaire = "france";
	
		 
		 $raport_load_data = DESACTIVATION_PARTENAIRES_ANCIEN_IAD($NosRezo_racine, $source_pays_partenaire);
		 $raport_load_data = str_replace("\"", "", $raport_load_data);			 
         $log_rapport      = $log_rapport." ".$raport_load_data.$retour1;			 
	 
		 
		 $raport_load_data = VA_BIENTOT_QUITTER_IAD($NosRezo_racine);	
	     $raport_load_data = str_replace("\"", "", $raport_load_data);	
         $log_rapport      = $log_rapport." ".$raport_load_data.$retour1;	
		 
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 5. FIN DU SCRIPT 	  
         $log_rapport    = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - FIN DU SCRIPT  ".$retour1;
         $date_fin       = strtotime(date('Y-m-d H:i:s',time()));
         $diff           = ($date_fin - $date_debut); 
         $secondes       = $diff % 60;
         $minutes        = floor( ($diff - $secondes) /60 )% 60;

		 $log_rapport    = $log_rapport." &nbsp &nbsp &nbsp &nbsp >> ".$minutes." min - ".$secondes." sec.";
		 
		 
		 $log_rapport = stripslashes($log_rapport);
		 $log_rapport = addslashes($log_rapport); 
         $log_rapport = str_replace("\"", "", $log_rapport);
		 
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// X. ENVOI MAIL DE RAPPORT TOUS LES SOIRS		  

$mail  = "benjamin.allais@gmail.com";		
		 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
RAPPORT CRON, <br />
<br />
$log_rapport <br />
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NR.<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Rapport IAD - TEST";
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

