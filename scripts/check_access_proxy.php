<?php
 /// $id_affiliate EST SOIT UN ID, SOIT UN PID, SOIT UN EMAIL
     session_start();
	 require('functions.php');
     include('config.php');
	 include('config_PDO.php');
	 List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	

 IF (! session_id ()) { session_start (); }	
     //print_r($_SESSION); IF (isset($_SESSION['proxy_user']['id']))       { echo $_SESSION['proxy_user']['id']; } IF (isset($_SESSION['proxy_user']['lastname'])) { echo $_SESSION['proxy_user']['lastname']; }
	
	IF (isset($_SESSION['proxy_user']['email']))    
	    { 
		 $email   = trim(mysql_real_escape_string($_SESSION['proxy_user']['email']));
		 
		 IF ( strstr($email, "@"))  
             { 	 IF (preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i', $email)) 
			         { 
						 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
						                          FROM affiliate_details ad, affiliate aa 
												  WHERE ad.id_affiliate = aa.id_affiliate 
												  AND aa.is_activated = 1 
												  AND ad.email = \''.$email.'\'    limit 0,1 ') or die(".");
		                 $dn      = mysql_fetch_array($req);
                         GESTION_PARAMETRES_SESSION($connection_database2, $dn['first_name'], $dn['id_affiliate'], $dn['id_partenaire'], $dn['email'], $dn['id_upline'], 0, 0, 0, "IAD");
				     }
                 ELSE { 
					     /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
    	                 echo '<body onLoad="alert(\'Votre compte '.$email.' est en cours d\'activation : pour toute question contact@nosrezo.com \')">'; 
                         echo '<meta http-equiv="refresh" content="0;URL=../login.php">'; 
                      }
             }

        }
?>

