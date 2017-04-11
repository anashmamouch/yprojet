<?php  /// PLANNIFICATEUR DE TACHE N°2
       /// FREQUENCE : TOUS LES JOURS A 11H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
       /// 11 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/6_cron_relance_evry_hour.php	
	   /// Press the Esc key and type :x and press ENTER to exit and save changes.

       /// 0 8-20 * * 1-5 /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/6_cron_relance_evry_hour.php		   

	   
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
         $log_rapport   = " RUN JOURS OUVRÉS DE 8H À 20H ".$retour2;
		 
		 //mail('benjamin.allais@gmail.com','RUN JOURS OUVRÉS DE 8H À 20H : 1/3 ', $log_rapport ); 


/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. VACANCES   	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()-3600)." - ANALYSE VACANCES : ".$retour1;
         $rapport_Load  = VACANCES_TOUS_PARTENAIRES_SAUF_IAD($NosRezo_racine);
		 $rapport_Load  = str_replace("\"", "", $rapport_Load);	
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;		 

		 //mail('benjamin.allais@gmail.com','RUN JOURS OUVRÉS DE 8H À 20H : 2/3 ', $log_rapport ); 	

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 2. RELANCE PARTENAIRE ETAPE 3/4/5/6 MAJ   	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()-3600)." - E3/4/5/6 MAJ : ".$retour1;
         $rapport_Load  = RELANCES_PARTENAIRES_MAX_DATE("", $NosRezo_racine, $serveur);
		 $rapport_Load  = str_replace("\"", "", $rapport_Load);	
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;		 

		 //mail('benjamin.allais@gmail.com','RUN JOURS OUVRÉS DE 8H À 20H : 2/3 ', $log_rapport ); 	
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 3. RELANCE PARTENAIRE ETAPE 3	   	
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()-3600)." - E3 NON MAJ : ".$retour1;
         $rapport_Load  = GESTION_DES_RELANCES_PARTENAIRES_ETAPE_3(3, "", $NosRezo_racine, $serveur);
		 $rapport_Load  = str_replace("\"", "", $rapport_Load);	
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;

		 //mail('benjamin.allais@gmail.com','RUN JOURS OUVRÉS DE 8H À 20H : 3/3 ', $log_rapport ); 
		 
	 


	 
	 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 4. FIN DU SCRIPT 	  
         $log_rapport    = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - FIN DU SCRIPT  ".$retour1;
         $date_fin       = strtotime(date('Y-m-d H:i:s',time()));
         $diff           = ($date_fin - $date_debut); 
         $secondes       = $diff % 60;
         $minutes        = floor( ($diff - $secondes) /60 )% 60;

		 $log_rapport    = $log_rapport." &nbsp &nbsp &nbsp &nbsp >> ".$minutes." min - ".$secondes." sec.";
		 
		 //mail('benjamin.allais@gmail.com','RUN JOURS OUVRÉS DE 8H À 20H : FIN DU SCRIPT  ', $log_rapport ); 		 
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
$sujet = "CRON - RELANCES PARTENAIRES ";
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

