<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

     // API API_FORGOT_PASSWORD.PHP - CALLED BY APPS MOBILE ONLY
     // RETURN 0   : EMAIL NON INSCRIT      	   
     // RETURN 10  : NOUVEAU MOT DE PASSE ENVOYE
	 // CALL       : http://nosrezo.com/scripts/API_MOBILE/api_forgot_password.php
	 //              https://www.hurl.it/	 
	 //      	{
	 // 	  			"email":"benjamin.allais@iadfrance.fr"	 
	 //			}

     session_start();                 // ON OUVRE LA SESSION EN COURS         
     require('../functions.php');     // ON DÉFINI LES FUNCTIONS             
     include('../config.php');        // ON SE CONNECTE A LA BASE DE DONNÉE 
     //require('../config_PDO.php');                                 // ON SE CONNECTE A LA BASE DE DONNÉE 	
     List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");
     
     $postdata = file_get_contents("php://input");    # Récupération du JSON
     $request  = json_decode($postdata);              # Décodage du JSON en array
     $email    = $request->email; 
	 
     $email    = trim(mysql_real_escape_string($email));
	 $email    = strtolower($email);
	 
	 
	IF ($email <> "")
	{
 		$req  = mysql_query(' select aa.id_affiliate AS id_affiliate, lower(email) as email 
		                      FROM affiliate_details ad, affiliate aa 
							  WHERE ad.id_affiliate = aa.id_affiliate 
							  AND aa.is_activated = 1 
							  AND email= "'.$email.'"   ');
		$dn   = mysql_fetch_array($req);
		mysql_query('SET NAMES utf8');
		//ON LE COMPARE A CELUI QU IL A ENTRÉ ET ON VERIFIE SI LE MEMBRE EXISTE
				
		IF(trim($dn['email'])== $email and mysql_num_rows($req)>0)
		     { 
             insert_action_list("Send MDP oublié", 6, $email, 0,0,$dn['id_affiliate'], "FERME", " Email : [ ".$email." ]" ,"", "Service Admin", 0, "");
 			 send_password($dn['email'], "OUBLIE");
    	                  /// EMAIL OK CHEZ NOSREZO
                          echo json_encode(                          
                              array(                          
                                  "data" => 10
                                   )
                          ); 			
			 }
		ELSE
		    {
		      $req  = mysql_query(' select aa.id_affiliate AS id_affiliate, pl.p_contact_mail as email, pl.id_partner 
			                        FROM affiliate_details ad, affiliate aa, partner_list pl 
									WHERE ad.id_affiliate = aa.id_affiliate 
									AND   aa.is_activated = 1 
									AND   pl.id_partner = aa.id_partenaire 
									AND   pl.p_contact_mail = "'.$email.'"    ');			  
			  $dn   = mysql_fetch_array($req);
		      mysql_query('SET NAMES utf8');
		      //On le compare a celui qu il a entré et on verifie si le membre existe
				
		     IF(trim($dn['email'])==$email and mysql_num_rows($req)>0)
		          { 
                    insert_action_list("Send MDP oublié", 6, $email, 0,0,$dn['id_affiliate'], "FERME", " Email : [ ".$email." ]" ,"", "Service Admin", 0, "");
					send_password_partenaire($dn['id_partner'], "OUBLIE");
					
    	                  /// EMAIL OK CHEZ NOSREZO
                          echo json_encode(                          
                              array(                          
                                  "data" => 10
                                   )
                          ); 			
			       }
             ELSE		
		           {
    	                  /// EMAIL NON INSCRIT CHEZ NOSRREZO
                          echo json_encode(                          
                              array(                          
                                  "data" => 0
                                   )
                          );
		           }
            }				   
    }
	 ELSE
		     {
    	                  /// EMAIL NON INSCRIT CHEZ NOSRREZO
                          echo json_encode(                          
                              array(                          
                                  "data" => 0
                                   )
                          );
		     }

?>

