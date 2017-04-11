<?php  /// PLANNIFICATEUR DE TACHE N°2
       /// FREQUENCE : TOUS LES JOURS A 11H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
	   /// 10 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/2_cron_jour_light.php
	   /// Press the Esc key and type :x and press ENTER to exit and save changes.
       /// 11 6 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/3_cron_save_data.php
       /// 11 11 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/2_cron_jour_light.php		   
		 	
		 $NosRezo_scripts          = dirname(dirname(__FILE__));
		 $NosRezo_racine           = dirname($NosRezo_scripts);	   
		 require($NosRezo_scripts.'/config.php');                       
         require($NosRezo_scripts.'/functions_server.php');
		 	
         $rapport_Load  = "";
		 $date_debut    = strtotime(date('Y-m-d H:i:s',time()));
		 $retour1       = "<br/>"; 
		 $retour2       = "<br/><br/>";     	     
		 $retour3       = "<br/><br/><br/>";
	 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. SAUVEGARDE DE LA BASE DE DONNÉE   	
         $log_rapport   = date('Y-m-d H:i:s',time()+3600)." - START SAUVEGARDE BDD - ";
		 
         save_bdd_full_serveur($NosRezo_racine);			 
	  
         $log_rapport   = $log_rapport.date('Y-m-d H:i:s',time()+3600)." - END SAUVEGARDE BDD";		
		 mail('benjamin.allais@gmail.com','CRON - SAVE BDD - Phase 2/2', $log_rapport ); 

?>

