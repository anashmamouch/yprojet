<?php  /// PLANNIFICATEUR DE TACHE N°2
       /// FREQUENCE : TOUS LES JOURS A 11H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
	   /// 10 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/2_cron_jour_light.php
	   /// Press the Esc key and type :x and press ENTER to exit and save changes.
       /// 11 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/2_cron_jour_light.php		   

	   
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
         $log_rapport   = date('Y-m-d H:i:s',time()-3600)." - SCRIT 2_cron_jour_light.php ".$retour2;
		 

/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. MODULE HAPPY B'DAYYYY TO YOUUUUUUUUUUU   
         include($NosRezo_scripts.'/email/happy_B_day.php'); 
		 $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()-3600)." - MODULE HAPPY B'DAY   ".$retour1;

         $result = mysql_query("
		        SELECT ad.id_affiliate, ad.birth_date
                FROM affiliate_details ad, affiliate aa
                WHERE ad.id_affiliate = aa.id_affiliate
				AND   aa.is_activated = 1
				AND   aa.id_affiliate > 10
				AND   substr( birth_date, 1, LOCATE( '/', birth_date ) -1 ) = DATE_FORMAT( NOW( ) , '%d' )
                AND   substr( birth_date, LOCATE( '/', birth_date ) +1, LOCATE( '/', birth_date ) -1 ) = DATE_FORMAT( NOW( ) , '%m' )   ") or die("Requete pas comprise - #ASE31! ");
	     
		 $liste_des_affilies = "ID : ";
		 $rapport_Load       = "";
		 while ($reponse = mysql_fetch_array($result))
		     {
                 $liste_des_affilies = $liste_des_affilies.$reponse['id_affiliate']." - ";
                 $rapport_Load  = $rapport_Load.send_happy_b_day($reponse['id_affiliate'], $serveur);
             }			 
         $log_rapport   = $log_rapport." ".$rapport_Load;

		 //mail('benjamin.allais@gmail.com','Envoi de 2_cron_jour_light.php MODULE HAPPY BDAYYYY TO YOUUUUUU',phpversion()); 		 

		 
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 2. MAJ PROMOS ET NOTIFS 	   	
         $log_rapport   = $log_rapport.$retour2.date('Y-m-d H:i:s',time()-3600)." - MAJ PROMOS ET NOTIFS  ".$retour1;
		 $rapport_Load  = "";
		 $rapport_Load  = maj_promotion_suivi(0, 0);
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;

		 //mail('benjamin.allais@gmail.com','Envoi de 2_cron_jour_light.php MAJ PROMOS ET NOTIFS',phpversion()); 		 



/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 3. RELANCE PARTENAIRE ETAPE 2	   	
         $log_rapport   = $log_rapport.$retour2.date('Y-m-d H:i:s',time()-3600)." - RELANCE PARTENAIRE E2 ".$retour1;
		 $rapport_Load  = "";
		 $rapport_Load  = GESTION_DES_RELANCES_PARTENAIRES_ETAPE_2(2, 0, $NosRezo_racine, $serveur); 
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;

		 //mail('benjamin.allais@gmail.com','Envoi de 2_cron_jour_light.php MAJ PROMOS ET NOTIFS',phpversion()); 


		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 4. FIN DU SCRIPT 	  
         $log_rapport    = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - FIN DU SCRIPT  ".$retour1;
         $date_fin       = strtotime(date('Y-m-d H:i:s',time()));
         $diff           = ($date_fin - $date_debut); 
         $secondes       = $diff % 60;
         $minutes        = floor( ($diff - $secondes) /60 )% 60;

		 $log_rapport    = $log_rapport." &nbsp &nbsp &nbsp &nbsp >> ".$minutes." min - ".$secondes." sec.";
		 
		 //mail('benjamin.allais@gmail.com','Envoi de 2_cron_jour_light.php FIN DU SCRIPT ',phpversion()); 		 
		 //echo $log_rapport;

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// X. ENVOI MAIL DE RAPPORT TOUS LES SOIRS	  

{
$mail  = "contact@nosrezo.com";		
		 
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
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a>
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "CRON - Rapport ";
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
}





?>

