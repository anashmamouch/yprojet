<?php  function MASTER_CONNECTION_PARAMETERS($param1, $fournisseur, $NosRezo_racine, $provenance, $param2)
{   // CONNECTION AU SERVEUR ET A LA BASE DE DONNÉES
      
	 $serveur = 'TEST'; // TEST - PRODUCTION
	 IF ($serveur == 'PRODUCTION')                  
	 {                      
        IF  ($fournisseur == '1AND1')
		     {
	          $host         = 'db584998543.db.1and1.com';
              $mysql_user   = 'dbo584998543';
	          $mysql_pwd    = 'XXXXXX';
	          $select_db    = 'db584998543';
			  $host_save    = 'localhost';
			  $mysqlsocket  = '/var/lib/mysql/mysql.sock';
			 }
     }
	 ELSE ///////////////////////////////////////////////////////////////////////// BASE DE TEST EN LOCAL
	 {       
	          $host             = 'localhost';
              $mysql_user       = 'root';
	          $mysql_pwd        = 'root';
	          $select_db        = 'nosrezo';
			  $host_save        = '';
	          $mysqlsocket      = '';
     }
	 
	 $host_mail = "tri-force.fr";
	 $user_ftp  = "u81660947";
	 
	 return array ($host , $mysql_user, $mysql_pwd, $select_db, $host_save, $mysqlsocket, $provenance, $serveur, $host_mail, $user_ftp );  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php function PDO_CONNECT($NosRezo_scripts, $param2, $param3) // 1. FICHIER D'APPEL A LA CONNECTION A LA BASE DE DONNEE 
{   // FICHIER DE CONFIGURATION - TOUS LES SCRIPTS FONT APPEL A CE MODULE	
    $connection_ok   = 0;
	$message_erreur  = "";
	
    // 1. SUR QUEL SITE NOUS SOMMES ? //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 $fournisseur = "1AND1"; 
		 IF ( $NosRezo_scripts == "")
		 {
		     $NosRezo_racine    = dirname(dirname(__FILE__));
		 }
		 ELSE // LE CRON RENTRE DANS CETTE CATÉGORIE CAR LES CRONS SE LANCENT AVEC DES CHEMINS ABSOLU
		 {
			 $NosRezo_racine    = $NosRezo_scripts;
		 }

	// 2. ENVIRONNEMENT DE TEST OU DE PRODUCTION; //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 List ($host , $mysql_user, $mysql_pwd, $select_db, $host_save, $mysqlsocket, $provenance, $serveur, $host_mail, $user_ftp ) = MASTER_CONNECTION_PARAMETERS("", $fournisseur, $NosRezo_racine, "config2", "");
		 
	// 3. ON LANCE LA CONNECTION À LA BASE DE DONNÉES 	 	     
     try {
		$connection_database = new PDO ( "mysql:host=$host;dbname=$select_db", "$mysql_user", "$mysql_pwd" );
		$connection_database->setAttribute ( PDO::ATTR_CASE, PDO::CASE_LOWER );
		$connection_database->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$connection_database->exec ( "SET NAMES utf8" );
		$connection_ok   = 1;
	} catch ( PDOException $e ) {
		$message_erreur = 'Une erreur MySQL est arrivée: ' . $e->getMessage () ;
	}
     
	 return array ($connection_database, $connection_ok , $message_erreur, $serveur );	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}	 
?>

