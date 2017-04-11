<?php 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

     // CALLED BY APPS MOBILE ONLY
 
     session_start ();                // ON OUVRE LA SESSION EN COURS        
     require('../functions.php');     // ON DÉFINI LES FUNCTIONS             
     include('../config.php');        // ON SE CONNECTE A LA BASE DE DONNÉE
	 include('../config_PDO.php');
	 List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	 
	 
     $postdata                   = file_get_contents("php://input");       # RÉCUPÉRATION DU JSON
     $request                    = json_decode($postdata);                 # DÉCODAGE DU JSON EN ARRAY
     $id_affiliate               = $request->id_affiliate;
	 $latitude                   = $request->latitude;  
     $longitude                  = $request->longitude; 
     $service                    = $request->category; 
	                             
     $id_partenaire_is_iad       = $request->id_partenaire_is_iad;
	 $parrain_is_iad             = $request->parrain_is_iad;
	 
	 $id_partenaire_du_parrain_1 = $request->id_partenaire_du_parrain_1;
	 $service_du_parrain_1       = $request->service_du_parrain_1;
	 
	 $parrain_2_is_iad           = $request->parrain_2_is_iad;
	 $id_parrain_2_is_iad        = $request->id_parrain_2_is_iad;
	 
	 $id_partenaire_du_parrain_2 = $request->id_partenaire_du_parrain_2;
	 $service_du_parrain_2       = $request->service_du_parrain_2;
	 
	     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     
	     List($first_name, $id_affiliate, $id_partenaire, $email, $id_upline, $id_partenaire_is_iad, $source, $parrain_is_iad, $id_parrain_is_iad, $id_parrain_2_is_iad, $last_name, $phone_number, $address, $zip_code, $city, $birth_date, $birth_place, $nationality, $id_securite_sociale, $logement_affiliate, $statut_logement,  $photo_profil, $id_partenaire_du_parrain_1, $service_du_parrain_1, $parrain_2_is_iad, $id_partenaire_du_parrain_2, $service_du_parrain_2, $numero_de_pack, $service_de_l_affilie  ) = RETURN_SESSION_FROM_ID_AFFILIATE($connection_database2, $id_affiliate );
	     $json                  = array();
 	     $ENVOI_AU_PARRAIN_IAD  = 0;
	     mysql_query('SET NAMES utf8');	
						
		 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 // LE RECRUTEMENT IMMOBILIER N'AFFICHE PAS LA LISTE DES PARTENAIRES MAIS LE NOM DU PARRAIN LE PLUS PROCHE EN LEVEL
		 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         IF ( $service == 8) // SERVICE RECRUTEMENT
		 {
			 List($id_partenaire_du_parrain_2, $service_du_parrain, $id_affiliate_parrain, $partenaire_nom ) = RETURN_PARTENAIRE_PLUS_PROCHE_IAD($connection_database2, $id_upline );
			 IF ( $id_partenaire_du_parrain_2 == 0 )     { array_push( $json, array('val' => 0, 'partenaire' =>'1er UPLINE IAD'));                             }
			 ELSE                                        { array_push( $json, array('val' => $id_partenaire_du_parrain_2, 'partenaire' => $partenaire_nom ));  }
             echo json_encode($json); 				 
		 }
		 ELSE
		 {	

		             ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		             // 1.       SI JE SUIS UN PROFESSIONNEL                               ON AFFICHE TOUT
		             // 2. SINON SI MON PARRAIN EST UN PROFESSIONNEL                       ON AFFICHE QUE MON PARRAIN SUR SON SECTEUR
		             // 3. SINON SI LE PARRAIN DE MON PARRAIN EST UN PROFESSIONNEL         ON AFFICHE QUE LE PARRAIN DE MON PARRAIN SUR SON SECTEUR
		             ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     
		             IF  (    $latitude        <> ''                                 ///  UNE VILLE EST CHOISIE
    	             	  AND $service_de_l_affilie <> $service                      ///  JE NE SUIS PAS UN PROFESSIONNEL DE CE SERVICE
		                  AND $id_partenaire_du_parrain_1 > 0                        ///  MON PARRAIN EST UN PROFESSIONNEL
		             	 )
		                 {											   
		             		     List( $result_2, $row2,  $temp ) = RETURN_RESULT_RECHERCHE_PARTENAIRE($connection_database2, $id_parrain_is_iad , $service, $service_de_l_affilie) ; 
		             		     List( $distance, $ENVOI_AU_PARRAIN_IAD, $ON_AFFICHE_PARTENAIRE )= LISTE_PARTENAIRE_DISTANCE_OK( $latitude, $longitude, $row2['p_lat'], $row2['p_long'], $row2['p_rayon_level1'], "WEB" );								
		             		     IF ( $ON_AFFICHE_PARTENAIRE == 1 ) 						 
		             		        {   
                                        array_push( $json, array('val' => $row2['id_partner'], 'partenaire' => $row2['p_contact']) ); 									 
		             		        }							 
		             	 }			 
		             ////  SINON  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		             ELSE IF (    $latitude        <> ''                              ///  UNE VILLE EST CHOISIE
    	             	      AND $service_de_l_affilie <> $service                   ///  JE NE SUIS PAS UN PROFESSIONNEL DE CE SERVICE
		                      AND $id_partenaire_du_parrain_2 > 0                     ///  MON PARRAIN EST UN PROFESSIONNEL
		             	 )
		                 {				 
		             		 List( $result_2, $row2,  $temp ) = RETURN_RESULT_RECHERCHE_PARTENAIRE($connection_database2, $id_parrain_2_is_iad , $service, $service_de_l_affilie) ; 
		             		 List( $distance, $ENVOI_AU_PARRAIN_IAD, $ON_AFFICHE_PARTENAIRE )= LISTE_PARTENAIRE_DISTANCE_OK( $latitude, $longitude, $row2['p_lat'], $row2['p_long'], $row2['p_rayon_level1'], "WEB" );								
		             		     IF ( $ON_AFFICHE_PARTENAIRE == 1 ) 						 
		             		        {   
                                        array_push( $json, array('val' => $row2['id_partner'], 'partenaire' => $row2['p_contact']) ); 
                                        									
		             		        }
		             	 }
		             	 
                     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		             //////////////////////////    LE PARRAIN N'EST PAS CHEZ IAD ET : JE PEUX ÊTRE CHEZ IAD     ////////////////////////////////////////////////////////////////////////////////
		             	 
		             IF ( $ENVOI_AU_PARRAIN_IAD   == 0   )     // LES 2 REQUÊTES CI-DESSUS SONT VIDES
		                 {
		             	     ////////////////// DÉCLARATION DE LA MATRICE TABLEAU 
                             $Liste_partenaire = array();
		             		 $compteur         = 0;
		             		 
		             		 $sql    = " SELECT pl.id_partner, CONCAT( p_last_name, ' ', p_first_name) AS p_contact, p_secteur, p_lat, p_long, p_rayon, p_zip_code, p_city , pn.Total_points_algo 
		             					 FROM partner_list pl, partner_list_services pls, partner_notation pn 
                                         WHERE pl.is_activated = 1
                                         AND   pls.id_service  = ".$service."  
                                         AND   pl.id_partner   = pls.id_partner      
		             					 AND   pl.id_partner   = pn.id_partner_notation  
                                         AND   pls.id_partner  = pn.id_partner_notation 			 " ;
		             					 
		                     $result = mysql_query($sql) or die(" Requete pas comprise : Choix des partenaires ! #269 ");
		             		 
		             		 WHILE ($row = mysql_fetch_array($result)) 
		                     {
                                 List( $distance, $ENVOI_AU_PARRAIN_IAD, $ON_AFFICHE_PARTENAIRE )= LISTE_PARTENAIRE_DISTANCE_OK( $latitude, $longitude, $row['p_lat'], $row['p_long'], $row['p_rayon'], "WEB" );								
		             			 IF ( $ON_AFFICHE_PARTENAIRE == 1 ) 						 
		             		         {   
		             			    			 list($points_distance , $points_total) = RETURN_POINTS_DISTANCE_ALGORITHME($distance, $row['Total_points_algo']);
		             					         $Liste_partenaire[$compteur] = array($points_total, $row['id_partner'], $row['p_contact'], $distance, $row['p_zip_code'], $row['p_city'], $row['Total_points_algo'], $points_distance );
		             					         $compteur                    = $compteur + 1;			 
		             				 }						 
		             	     }
		                     						         
		             		 rsort($Liste_partenaire); // CLASSEMENT DU TABLEAU PAR DISTANCE 
		             		 $compteur = 0;
                     
		                     FOREACH($Liste_partenaire as $cle => $valeur)
                                {
		             				$compteur = $compteur + 1;										 
		             				if($cle == 0) {
		             					IF ($service == 8) 
		             					{  
		             						 array_push( $json, array('val' => $valeur[1], 'partenaire' => 'Laissez NosRezo choisir pour vous le meilleur formateur sur le secteur') ); 
 	                 
		             					} ELSE 
		             					{   
		             						 array_push( $json, array('val' => $valeur[1], 'partenaire' => 'Laissez l\'algorithme choisir pour vous le meilleur partenaire') ); 
		             					}			
		             				}
		             														 
		             								 IF ( $id_affiliate < 3  )
		             						            { 									
		             										 array_push( $json,  array('val' => $valeur[1], 'partenaire' => $valeur[2]) );
		             										 
		             									}
		             	                             ELSE										 
		             								    { 
		             										array_push( $json, array('val' => $valeur[1], 'partenaire' => $valeur[2]) );
		             									}					    
		             					
                                }
		             			 
		             			 IF ($compteur == 0) 
		             			 { 
		             				array_push( $json,  array('val' => 0, 'partenaire' =>'Laissez l\'algorithme choisir pour vous le meilleur partenaire'));
		             			 }
		             			 
		             			  echo json_encode($json);
		             			 
		                 }
		             	 ELSE
		             	 {  
		                     echo json_encode($json);  
		             	 }
		 }	

?> 
