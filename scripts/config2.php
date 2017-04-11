<?php function CONFIG2_MYSQLI_PRIORITY($NosRezo_scripts, $param2, $param3)
{
         $connection_ok    =  0;
	     $message_erreur   =  "";
	     $fournisseur      =  "1AND1";
		 $origine_script   =  "";
	
	// FICHIER DE CONFIGURATION - TOUS LES SCRIPTS FONT APPEL A CE MODULE /////////////////////////////////////////////////////////////////////////////////////// 
    // 1. MODULE SPÉCIFIQUE POUR LES CRONS
		 IF ( $NosRezo_scripts == "") // TOUT SAUF POUR LES CRONS
		 {
			$NosRezo_racine    = dirname(dirname(__FILE__));
		    include_once($NosRezo_racine.'/scripts/config_master.php'); 
		 }
		 ELSE // LES CRONS SE LANCENT AVEC DES CHEMINS ABSOLU >> LE CRON RENTRE DANS CETTE CATÉGORIE
		 {		 
		     $origine_script   =  "CRON";
			 include_once($NosRezo_scripts.'/config_master.php');
			 $NosRezo_racine    = $NosRezo_scripts;
		 }
		 
	// 2. ENVIRONNEMENT DE TEST OU DE PRODUCTION ///////////////////////////////////////////////////////////////////////////////////////
		 List ($host , $mysql_user, $mysql_pwd, $select_db, $host_save, $mysqlsocket, $provenance, $serveur, $host_mail, $user_ftp ) = MASTER_CONNECTION_PARAMETERS("", $fournisseur, $NosRezo_racine, "config2", $origine_script );
		
		 
	// 3. ON LANCE LA CONNECTION À LA BASE DE DONNÉES 	 ///////////////////////////////////////////////////////////////////////////////////////	 
         IF ($serveur == 'PRODUCTION') 
         {	
	          IF ( $origine_script == "CRON" ) // TRAITEMENT SPÉCIFIQUE POUR LES CRONS
	          {
         	             $connection_database = mysqli_connect($host, $mysql_user, $mysql_pwd, $select_db, NULL,  $mysqlsocket);
                         $connection_ok   = 1;									 
	          }
			  ELSE
			  {
         	     $connection_database = mysqli_connect($host, $mysql_user, $mysql_pwd, $select_db, 3316, $mysqlsocket);
                 $connection_ok   = 1;
			  }

         } 
         ELSE ///////////////////////////////////////////////////////////////////////// BASE DE TEST EN LOCAL 
         {
         	$connection_database = mysqli_connect($host, $mysql_user, $mysql_pwd, $select_db);
			$connection_ok   = 1;
         }
     
     
         IF (mysqli_connect_errno()) // LA CONNEXION AU SERVEUR MYSQLI N'A PAS ABOUTI 
             {
	  	       $message_erreur = mysqli_connect_error();
             }


	 return array ($connection_database, $connection_ok , $message_erreur );	

}	
?>

