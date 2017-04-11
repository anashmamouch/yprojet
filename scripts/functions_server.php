<?php function get_ip() {
    /**
     * Récupérer la véritable adresse IP d'un visiteur
     */
    // IP si internet partagé
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
    }
    // IP derrière un proxy
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Sinon : IP normale
    else {
    return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function save_bdd_full_serveur($NosRezo_racine)
{	// https://www.drupal.org/upgrade/backing-your-site-command-line
			
     include($NosRezo_racine.'/scripts/config.php');
     $path_save_db  = $NosRezo_racine."/scripts/DB_backup";	 	 	 		 
	 $command       = "mysqldump --opt -h ".$host_save." -S ".$mysqlsocket." -u ".$mysql_user." -p".$mysql_pwd." ".$select_db." | gzip > ".$path_save_db."/SauveBD_".date('d_n_Y_H_i_s').".sql.gz";  	 
     
	      //echo $command;
	 exec($command);
	 
     // SUPPRESSION DES VIEUX FICHIERS DE SAUVEGARDE
         // $folder = new DirectoryIterator($path_save_db);
		 // $NbJours = 5;
         // foreach($folder as $file){
         //               if( ($file->isFile()) && (!$file->isDot()) ) {
         //                           if (time() - $file->getMTime() > $NbJours*24*3600) unlink($file->getPathname());  
         //                                                            }
         //                           }

	 return ($path_save_db); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

