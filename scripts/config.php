<?php
// FICHIER DE CONFIGURATION - TOUS LES SCRIPTS FONT APPEL A CE MODULE		 
    // 1. SUR QUEL SITE NOUS SOMMES ?
		 $NosRezo_racine    = dirname(dirname(__FILE__));
         $fournisseur       = "1AND1"; 

	// 2. ENVIRONNEMENT DE TEST OU DE PRODUCTION          //////////////////////////////////////////////////////////////////////////////////////////////////////// 
		 include_once($NosRezo_racine.'/scripts/config_master.php'); 
		 List ($host , $mysql_user, $mysql_pwd, $select_db, $host_save, $mysqlsocket, $provenance, $serveur, $host_mail, $user_ftp )= MASTER_CONNECTION_PARAMETERS("", $fournisseur, $NosRezo_racine, "config", "");
		 
	 // 3. ON LANCE LA CONNECTION À LA BASE DE DONNÉES     ////////////////////////////////////////////////////////////////////////////////////////////////////////	 
         IF (!@mysql_connect($host, $mysql_user, $mysql_pwd ))                 // SI PAS DE CONNECTION POSSIBLE
	         {       // ON DÉTRUIT LES VARIABLES DE NOTRE SESSION ET ON DÉTRUIT NOTRE SESSION
                     session_unset ();  
                     session_destroy (); 	 
	     	         echo '<meta http-equiv="refresh" content="0;URL=http://www.nosrezo.com/index.php">';
                     echo '<body onLoad="alert(\' Le site NosRezo.com est actuellement en maintenance pour 30 minutes environ ! \')">'; 
              }
         ELSE 
	          {
	     	         mysql_select_db($select_db);
              }
 			  
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	 // DONNÉES DE CONNEXION POUR LA GESTION DES MAILS 
         $host_mail                 = 'www.nosrezo.com';
		 $user_mail                 = 'u74776789';
		 $password                  = $mysql_pwd;
			       
	 // DONNÉES DE CONNEXION AU SERVEUR FTP
         $ftpServer                 =  'ftp.nosreso.com';  // 'nosrezo.com';
         $ftpUser                   =  'nosreso';          // 'u74776789';
         $ftpPwd                    =  'S9Z7dfkh';         // 
         $ftpTarget                 =  'scripts/DB_backup/';		 
	
     //EMAIL SERVICES NOSREZO
         $mail_communication        = 'contact@nosrezo.com';
         $mail_parrain_siege        = 'contact@nosrezo.com';
	     $nom_prenom_parrain_siege  = 'NosRezo';
	     $telephone_siege           = '0686495254';
		 $telephone_call_center     = "04 11 92 03 36";
		 $mail_partenaire           = 'partenaires@nosrezo.com'; 
	     $mail_support              = 'support@nosrezo.com';
		 $lien_webinar              = 'https://www.youtube.com/user/nosrezo/videos';
		 $lien_webinar_iad_france   = 'https://attendee.gotowebinar.com/rt/7446515438792588289';

	 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 // ÉSTHÉTIQUE
		 $fabolt       = '<div class="label label-sm label-danger">  <i class="fa fa-bolt"> </i> </div> ';
         $faplus       = '<div class="label label-sm label-info">    <i class="fa fa-plus"> </i> </div> ';
         $fabell       = '<div class="label label-sm label-info">    <i class="fa fa-bell"> </i> </div> ';		 
         $fafile       = '<div class="label label-sm label-info">    <i class="fa fa-file"> </i> </div> ';
         $favalide     = '<h3> <span class="label label-success">  VALIDÉ </span> </h3>';
         $faprogress   = '<h3> <span class="label label-warning">  EN COURS </span> </h3>';
         $faprogress2  = '<h3> <span class="label label-success">  EN COURS </span> </h3>';
		 $faclose      = '<div class="label label-sm label-danger">  <i class="fa fa-times"> </i> </div> ';		 
		 $facheck      = '<div class="label label-sm label-success"> <i class="fa fa-check"> </i> </div> ';	


		 
     //ADRESSE DU DOSSIER DE LA TOP SITE
         $url_root = 'http://www.nosrezo.com/index.php';
		 
/******************************************************
---------------- CONFIGURATION OPTIONNELLE --------------
******************************************************/

//Nom du fichier de l'accueil
         $url_home = '../index.php';

?>