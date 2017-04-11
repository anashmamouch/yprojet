<?php // SCRIPT AJAX LANCÉ PAR LA PAGE INTRANET_MON_PROFIL_PARTENAIRE.PHP

    // 1. CONNECTION AUX PARAMETRES DES BASES DE DONNÉES
	include_once('../config_PDO.php'); 
	List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	
		 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	IF ( $connection_ok2 == 0 )
    {
        echo "langues_parlees.php - Failed to connect to PDO: " . $message_erreur2;		
    } 
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ELSE 
    {
         if (isset($_REQUEST['id_partner'])) 
		 {
             $id_partner = $_REQUEST['id_partner'];
         } else 
		 {
             $id_partner = 0;
         }
         
         if (isset($_REQUEST['lang_fr'])) {
             $lang_fr = $_REQUEST['lang_fr'];
         } else {
             $lang_fr = 0;
         }
         
         if (isset($_REQUEST['lang_us'])) {
             $lang_us = $_REQUEST['lang_us'];
         } else {
             $lang_us = 0;
         }
         
         if (isset($_REQUEST['lang_es'])) {
             $lang_es = $_REQUEST['lang_es'];
         } else {
             $lang_es = 0;
         }
         
         if (isset($_REQUEST['lang_pt'])) {
             $lang_pt = $_REQUEST['lang_pt'];
         } else {
             $lang_pt = 0;
    }
	

          try {
	            $result = $connection_database2->prepare( " UPDATE partner_list SET lang_fr =:lang_fr, lang_us =:lang_us, lang_pt =:lang_pt, lang_es =:lang_es  WHERE id_partner = :id_partner   " );
	            $result->bindParam(":lang_fr", $lang_fr);
				$result->bindParam(":lang_us", $lang_us);
				$result->bindParam(":lang_pt", $lang_pt);
				$result->bindParam(":lang_es", $lang_es);
				$result->bindParam(":id_partner", $id_partner);
				$result->execute();
				echo 1;
				
	     } catch ( PDOException $e ) 
		 {
	     	$message_erreur = 'Une erreur MySQL PDO est arrivee: ' . $e->getMessage () ;
			echo 0;
	     }	 
    
    

}
?>