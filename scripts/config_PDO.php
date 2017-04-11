<?php function PDO_CONNECT($NosRezo_scripts, $param2, $param3)
{
         $connection_ok       =  0;
	     $message_erreur      =  "";
	     $fournisseur         =  "1AND1";
		 $origine_script      =  "";
		 $connection_database2 = "";
	
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
		 List ($host , $mysql_user, $mysql_pwd, $select_db, $host_save, $mysqlsocket, $provenance, $serveur, $host_mail, $user_ftp ) = MASTER_CONNECTION_PARAMETERS("", $fournisseur, $NosRezo_racine, "PDO", $origine_script );
		 
	// 3. ON LANCE LA CONNECTION À LA BASE DE DONNÉES 	 ///////////////////////////////////////////////////////////////////////////////////////	  	     
          try {
				 $connection_database2 = new PDO ("mysql:unix_socket=$mysqlsocket;dbname=$select_db","$mysql_user","$mysql_pwd");
	     	     $connection_database2->setAttribute ( PDO::ATTR_CASE, PDO::CASE_LOWER );
	     	     $connection_database2->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	     	     $connection_database2->exec ( "SET NAMES utf8" );
				 $connection_ok = 1;
	     } catch ( PDOException $e ) 
		 {
	     	$message_erreur = 'Une erreur MySQL PDO est arrivee: ' . $e->getMessage () ;
			echo $message_erreur ;
	     }	 

	 return array ($connection_database2, $connection_ok , $message_erreur );	

}	
?>

