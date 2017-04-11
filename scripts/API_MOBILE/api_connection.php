<?php 
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Origin: *');

     // API API_CONNECTION.PHP - CALLED BY APPS MOBILE ONLY
     // RETURN 0   : ERROR DE FORMAT    
     // RETURN 1   : PB DE CONNECTION À LA BASE DE DONNÉES 
     // RETURN 2   : UNE NOUVELLE APPLICATION IPHONE EST DISPONIBLE 	 
     // RETURN 10  : MEMBRE NON RECONNU OU INACTIF - FAIRE DEMANDE DE MDP OU CONTACTER NOSREZO : CONTACT@NOSREZO.COM  
     // RETURN 100 : OK ON ENTRE DANS L'APPLICATION
	 // CALL       : http://nosrezo.com/scripts/API_MOBILE/api_connection.php  ?id_affiliate=11&password=TOF 
	 //              https://www.hurl.it/	 Content-Type  application/json
	 //      	{
	 // 	  			"id_affiliate":11,
	 //					"password":"TOF",
     //                 "version_application":"1.0.0"	 
	 //			}
	 // IF($_SERVER['REQUEST_METHOD'] == "OPTIONS") // CONTROLE CAR ACCES AVEC UN AUTRE SITE QUE www.nosrezo.com

     error_reporting(E_ALL);
     ini_set('display_errors', 1);


     include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE	 
     require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 
     //require('../config_PDO.php');                                 // ON SE CONNECTE A LA BASE DE DONNÉE 	
     List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");
	 
     $postdata              = file_get_contents("php://input");    // RÉCUPÉRATION DU JSON
     $request               = json_decode($postdata);              // DÉCODAGE DU JSON EN ARRAY
	 $id_affiliate          = $request->id_affiliate;          
     $password_aff          = $request->password; 
     $version_application   = $request->version_application;       // INITIALEMENT '1.0.0'


// 1. CONNECTION AUX PARAMETRES DES BASES DE DONNÉES 	
	 $connection_ok = 1	;

     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	 // 2. UNE NOUVELLE APPLICATION MOBILE EST DISPONIBLE
	 IF ( $connection_ok == 0 ) 
	 //IF ( $version_application <> '1.0.0' ) 
     {
          echo json_encode(                          
              array(                          
                  "data" => 2
                   )

          );  		
     }
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 // 3. PROBLEME DE CONNECTION À LA BASE DE DONNÉES
	 ELSE IF ( $connection_ok == 0 )  
     {
          echo json_encode(                          
              array(                          
                  "data" => 1
                   )

          );  		
     } 
	 ELSE
	 {
     /////////////// 1ER CONTROLE DES FORMATS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     IF (   ($id_affiliate  == "")  
		 OR ($password_aff  == "") 
	     OR (strlen($id_affiliate) < 1)  
		 OR (strlen($password_aff) < 2) 
		 OR strstr(strtolower($id_affiliate), "script") 
		 OR strstr(strtolower($id_affiliate), "alert") 
		 OR strstr(strtolower($password_aff), "alert") 
		 OR strstr($password_aff, "="))
        {              
    	                  /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
              echo json_encode(                          
                  array(                          
                      "data" => 0
                       )

              ); 
        }    
	/////////////// 2EME CONTROLE DES FORMATS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     ELSE  
    { 
		 IF (is_num($id_affiliate) == 1)                  ///// RECHERCHE PAR ID_AFFILIE ET NON P123 
		     {
				 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
				                          FROM   affiliate_details ad, affiliate aa 
										  WHERE  ad.id_affiliate = aa.id_affiliate 
										  AND    aa.is_activated = 1 
										  AND    ad.id_affiliate ="'.$id_affiliate.'"   ');
		         $dn      = mysql_fetch_array($req);
			     $ERROR_FORMAT = 0;			 
			 }
		 ELSE                                             ///// RECHERCHE PAR ID_PARTENAIRE
		 IF (strlen($id_affiliate) < 10 and strtoupper(substr($id_affiliate,0,1)) =="P" and is_num(trim(substr($id_affiliate,1,5))) == 1 ) 
             {   
			     $id_partenaire = trim(substr($id_affiliate,1,8));
 		         $req      = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
				                           FROM   affiliate_details ad, affiliate aa 
							               WHERE  ad.id_affiliate  = aa.id_affiliate 
							               AND    aa.is_activated  = 1 
							               AND    aa.id_partenaire = "'.$id_partenaire.'"  limit 0,1 ');
		         $dn       = mysql_fetch_array($req);
			     $ERROR_FORMAT  = 0; 
             }			 
		 ELSE                                             ///// RECHERCHE PAR MAIL
		 IF ( strstr($id_affiliate, "@"))  
             { 	 IF (preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i', $id_affiliate)) 
			         { 
			             $email   = $id_affiliate;
						 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline  
						                          FROM affiliate_details ad, affiliate aa 
												  WHERE ad.id_affiliate = aa.id_affiliate 
												  AND aa.is_activated   = 1 
												  AND ad.email = \''.$email.'\'    limit 0,1 ') or die(".");
		                 $dn      = mysql_fetch_array($req);
			             $ERROR_FORMAT = 0; 
				     }
                 ELSE {   /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
                          echo json_encode(                          
                              array(                          
                                  "data" => 0
                                   )
                          );        
                      }
             }	

	
	IF ($ERROR_FORMAT == 0)        // LE FORMAT EST OK - COMMENCONS LES VÉRIFICATIONS
	     {      
                 IF( $dn['password'] == $password_aff and mysql_num_rows($req) > 0 )
		         { 
			              insert_log_track_actions($dn['id_affiliate'],$dn['first_name'], 'connection', 'api_connection.php','Connection APPLI MOBILE');
						  echo json_encode(                          
                              array(                          
                                  "data" => GESTION_PARAMETRES_SESSION($connection_database2, $dn['first_name'], $dn['id_affiliate'], $dn['id_partenaire'], $dn['email'], $dn['id_upline'], 0, 0, 0, "MOBILE" )
                                 // "data" => 100
                                   )
                          ); 
		         }
		     ELSE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		         {
                 insert_log_track_actions($dn['id_affiliate'],'-', 'connection', 'check_access.php','Mot de passe incorrect');
    	         /// MEMBRE NON RECONNU OU INACTIF
			              echo json_encode(                          
                              array(                          
                                  "data" => 10
                                   )
                          ); 
		         }
		 }
		 ELSE
		 {    
                 /// MAUVAIS FORMAT : PAS DE CONNECTION AVEC LA BASE DE DONNÉES - INUTILE
			              echo json_encode(                          
                              array(                          
                                  "data" => 0
                                   )
                          ); 
         }
		 	 
    }
	
}
?>