<?php
     /// $id_affiliate EST SOIT UN ID, SOIT UN PID, SOIT UN EMAIL
     session_start();
	 require('functions.php');
     include('config.php');
	 include('config_PDO.php');
	 List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	
	 
	 $pageName       = $_SERVER["DOCUMENT_ROOT"];	 
	 $id_affiliate   = trim(mysql_real_escape_string($_POST['id_affiliate'])); 
     $password_aff   = trim($_POST['password']);
	 $ERROR_FORMAT   = 1;                               ///// PAR DEFAUT LE FORMAT EST MAUVAIS 
	 
 
	
	 IF ( strstr($pageName,'nosreso') AND ($id_affiliate <> 1 AND $id_affiliate <> 12) ) // SI SITE nosreSo ALORS REDIRECTION vers nosreZo
         { 
		   echo '<body onLoad="alert(\'Redirection vers le site : www.nosreZo.com, avec un Z ! \')">'; 
		   echo '<meta http-equiv="refresh" content="0; URL=http://www.nosrezo.com/index.php"> ';
		  }
     ELSE
     { //////////// #123	 
  
     /////////////// 1er CONTROLE DES FORMATS
     IF (($id_affiliate == "")  OR ($password_aff  == "") OR (strlen($id_affiliate) < 1)  OR (strlen($password_aff) < 2) OR strstr(strtolower($id_affiliate), "script") OR strstr(strtolower($id_affiliate), "alert") OR strstr(strtolower($password_aff), "alert") OR strstr($password_aff, "="))
        {               /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
    	             echo '<body onLoad="alert(\'Saisie incorrecte de vos identifiants. \')">'; 
                     echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; 	
        }    
	/////////////// 2EME CONTROLE DES FORMATS
     ELSE 
    {    
		 IF (is_num($id_affiliate) == 1)                  ///// RECHERCHE PAR ID_AFFILIE
		     {
				 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
				                          FROM affiliate_details ad, affiliate aa 
										  WHERE ad.id_affiliate = aa.id_affiliate 
										  AND aa.is_activated = 1 
										  AND ad.id_affiliate ="'.$id_affiliate.'"   ');
		         $dn      = mysql_fetch_array($req);
			     $ERROR_FORMAT = 0;			 
			 }
		 ELSE                                             ///// RECHERCHE PAR ID_PARTENAIRE
		 IF (strlen($_POST['id_affiliate']) < 11 and strtoupper(substr($id_affiliate,0,1)) =="P" and is_num(trim(substr($id_affiliate,1,5))) == 1 ) 
             {   
			     $id_partenaire = trim(substr($id_affiliate,1,8));
 		         $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
				                          FROM  affiliate_details ad, affiliate aa 
										  WHERE ad.id_affiliate = aa.id_affiliate 
										  AND   aa.is_activated = 1 
										  AND aa.id_partenaire ="'.$id_partenaire.'"  limit 0,1 ');
		         $dn      = mysql_fetch_array($req);
			     $ERROR_FORMAT = 0; 
             }			 
		 ELSE                                             ///// RECHERCHE PAR MAIL
		 IF ( strstr($id_affiliate, "@"))  
             { 	 IF (preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i', $id_affiliate)) 
			         { 
			             $email   = $id_affiliate;
						 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
						                          FROM affiliate_details ad, affiliate aa 
												  WHERE ad.id_affiliate = aa.id_affiliate 
												  AND aa.is_activated = 1 
												  AND ad.email =\''.$email.'\'    limit 0,1 ');
		                 $dn      = mysql_fetch_array($req);
			             $ERROR_FORMAT = 0; 
				     }
                 ELSE { 
					     /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
    	                 echo '<body onLoad="alert(\'Saisie incorrecte de vos identifiants. \')">'; 
                         echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; 
                      }
             }	
	}
	
	IF ($ERROR_FORMAT == 0)        // LE FORMAT EST OK - COMMENCONS LES VERIFICATIONS
	     {      
                 IF($dn['password'] == $password_aff and mysql_num_rows($req)>0)
		         { 
                    GESTION_PARAMETRES_SESSION($connection_database2, $dn['first_name'], $dn['id_affiliate'], $dn['id_partenaire'], $dn['email'], $dn['id_upline'], 0, 0, 0, "SITE");
		         }
		     ELSE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		         {
                 insert_log_track_actions($_POST['id_affiliate'],'-', 'connection', 'check_access.php','Mot de passe incorrect');
    		     echo '<body onLoad="alert(\'Membre non reconnu ou inactif - Contactez : contact@nosrezo.com\')">'; 
                 echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; 			
		         }

		 }
		 ELSE
		 {    /// MAUVAIS FORMAT 
    	      echo '<body onLoad="alert(\'Saisie incorrecte de vos identifiants. \')">'; 
              echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; 	
         }
		 
     } //////////// #123	 
  

?>

