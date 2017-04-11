<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

       //ON VÉRIFIE QUE LE FORMULAIRE A ÉTÉ ENVOYÉ ET QUE LES DONNÉES NE SONT PAS VIDE
       // API API_INSERT_PRESCRIPTION.PHP - CALLED BY INTRANET
       // RETURN <20 : ERROR FORMAT
               // 2 : PB FORMAT AU NIVEAU DU NOM
               // 3 : PB FORMAT AU NIVEAU DU PRENOM	
               // X : ...			    
       // RETURN 1 : OK    -  ENVOI RECO OK	

     session_start ();                    // ON OUVRE LA SESSION EN COURS        
     require('../functions.php');         // ON DÉFINI LES FUNCTIONS             
     include('../config.php');            // ON SE CONNECTE À LA BASE DE DONNÉES
     //require('../config_PDO.php');                               // ON SE CONNECTE A LA BASE DE DONNÉE 	
     List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	 
	 

     $postdata                   = file_get_contents("php://input");    # Récupération du JSON
     $request                    = json_decode($postdata);              # Décodage du JSON en array

     $ERROR_FORMULAIRE           = 0;
	 $to_not_pay_checked         = 0;
	 $choose_to_pay_association  = 0;
	 $ERROR_MESSAGE              = '';
	 
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 // 1. INIT DES VARIABLES NON OBLIGATOIRES
     IF ( !isset($_POST['connection']))                      { $_POST['connection']                = "";}	
     IF ( !isset($_POST['cgu_checked']))                     { $_POST['cgu_checked']               = 1; }
	 IF ( !isset($_POST['email']) )                          { $_POST['email']                     = "";}
	 IF ( !isset($_POST['t_sub_category']))                  { $_POST['t_sub_category']            = "";}
	 IF ( !isset($_POST['ville-country']))                   { $_POST['ville-country']             = "";}
     IF ( !isset($_POST['to_not_pay_checked']))              { $to_not_pay_checked                 = 0; }	ELSE { $to_not_pay_checked                 = 1;}
     IF ( !isset($_POST['choose_to_pay_association']))       { $choose_to_pay_association          = 0; }	ELSE { $choose_to_pay_association          = 1;}
	 
     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	 
	 // 2. ENVOI ET CATCH DES VARIABLES ENVOYÉES PAR L'APPLICATION 
	 $id_affiliate                                    = $request->id_affiliate; 
	 $_POST['email']                                  = $request->email; 
	 $_POST['mobile']                                 = $request->mobile;
	 $_POST['s_sub_category_code']                    = $request->s_sub_category_code;
	 $_POST['ville-value']                            = $request->villevalue;
	 $_POST['nom']                                    = $request->nom;
	 $_POST['prenom']                                 = $request->prenom;
	 $_POST['commentaires']                           = $request->commentaires;	
	 //$_POST['t_sub_category']                       = $request->t_sub_category;
	 $_POST['ville']                                  = $request->ville;
	 $_POST['ville-latitude']                         = $request->villelatitude;
	 $_POST['ville-longitude']                        = $request->villelongitude;
	 $_POST['adresse']                                = $request->adresse;
	 //$_POST['connection']                           = $request->connection;
	 $_POST['partner']                                = $request->partner;
	 $_POST['first_id_partenaire_algorithme']         = $request->first_id_partenaire_algorithme;	 
	 

     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	 
	 // 3. INIT EN CAS DE PROBLÈMES D'ENVOI DES VARIABLES 

	 IF ( !isset($_POST['email']                              ))  { $_POST['email']                           = "";  }                   
	 IF ( !isset($_POST['mobile']                             ))  { $_POST['mobile']                          = "";  }         
	 IF ( !isset($_POST['s_sub_category_code']                ))  { $_POST['s_sub_category_code']             = "1";  }                        
	 IF ( !isset($_POST['ville-value']                        ))  { $_POST['ville-value']                     = "";  }                          
	 IF ( !isset($_POST['nom']                                ))  { $_POST['nom']                             = "";  }                  
	 IF ( !isset($_POST['prenom']                             ))  { $_POST['prenom']                          = "";  }         
	 IF ( !isset($_POST['commentaires']                       ))  { $_POST['commentaires']                    = "";  }         
	 IF ( !isset($_POST['t_sub_category']                     ))  { $_POST['t_sub_category']                  = "";  }         
	 IF ( !isset($_POST['ville']                              ))  { $_POST['ville']                           = "";  }         
	 IF ( !isset($_POST['ville-latitude']                     ))  { $_POST['ville-latitude']                  = "";  }         
	 IF ( !isset($_POST['ville-longitude']                    ))  { $_POST['ville-longitude']                 = "";  }         
	 IF ( !isset($_POST['adresse']                            ))  { $_POST['adresse']                         = "";  }         
	 IF ( !isset($_POST['connection']                         ))  { $_POST['connection']                      = "";  }         
	 IF ( !isset($_POST['partner']                            ))  { $_POST['partner']                         = "0";  }         
	 IF ( !isset($_POST['first_id_partenaire_algorithme']     ))  { $_POST['first_id_partenaire_algorithme']  = "0";  }

	 
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 
	 $_POST['email']                      = mysql_real_escape_string(stripslashes(trim($_POST['email'])));
	 $_POST['mobile']                     = trim($_POST['mobile']);	 

          IF ($_POST['s_sub_category_code'] == '0')           { $ERROR_FORMULAIRE = 15; $ERROR_MESSAGE = 'INVALIDE s_sub_category_code ';   }
     ELSE IF (empty($_POST['ville-value']))                   { $ERROR_FORMULAIRE = 5;  $ERROR_MESSAGE = 'INVALIDE ville-value ';   }
     ELSE IF (trim(is_num($_POST['ville-value']) == 0))       { $ERROR_FORMULAIRE = 11; $ERROR_MESSAGE = 'INVALIDE ville-value ';   }
     ELSE IF (strlen($_POST['ville-value']) < 4 )             { $ERROR_FORMULAIRE = 12; $ERROR_MESSAGE = 'INVALIDE ville-value ';   }
     ELSE IF (empty($_POST['nom']))                           { $ERROR_FORMULAIRE = 2;  $ERROR_MESSAGE = 'Nom invalide ';   }
     ELSE IF (trim($_POST['nom']) =='')                       { $ERROR_FORMULAIRE = 2;  $ERROR_MESSAGE = 'Nom invalide ';   }
     ELSE IF (empty($_POST['prenom']))                        { $ERROR_FORMULAIRE = 3;  $ERROR_MESSAGE = 'Prénom invalide';   }
     ELSE IF (trim($_POST['prenom']) =='')                    { $ERROR_FORMULAIRE = 3;  $ERROR_MESSAGE = 'Prénom invalide ';   }
     ELSE IF (empty($_POST['ville']))                         { $ERROR_FORMULAIRE = 6;  $ERROR_MESSAGE = 'Ville invalide ';   }	
     ELSE IF (trim($_POST['ville']) =='')                     { $ERROR_FORMULAIRE = 6;  $ERROR_MESSAGE = 'Ville invalide ';   }
     ELSE IF (empty($_POST['mobile']))                        { $ERROR_FORMULAIRE = 7;  $ERROR_MESSAGE = 'Numéro de mobile à changer ';   }
     //ELSE IF (is_num($_POST['mobile']) == 0)                  { $ERROR_FORMULAIRE = 9;  $ERROR_MESSAGE = 'Numéro de mobile à changer '.$id_affiliate ;   }
    // ELSE IF (strlen($_POST['mobile']) < 6)                   { $ERROR_FORMULAIRE = 10; $ERROR_MESSAGE = 'Numéro de mobile à changer ';   }	
     ELSE IF (strlen(trim($_POST['commentaires'])) < 10)      { $ERROR_FORMULAIRE = 14; $ERROR_MESSAGE = 'Commentaire trop court';   }
     ELSE IF (!isset($id_affiliate) )	                      { $ERROR_FORMULAIRE = 8;  $ERROR_MESSAGE = 'Merci de vous connecter avec votre identifiant.';   }
 	 
								   
IF ($ERROR_FORMULAIRE > 0 ) 
   {
						  echo json_encode(                          
                              array(                          
                                  "data" => $ERROR_FORMULAIRE,
								  "ERROR_MESSAGE" => $ERROR_MESSAGE
                                   )
                              );
   }	
ELSE IF( $id_affiliate > 10 )
{
		        IF(get_magic_quotes_gpc())
		        {       
			    $_POST['nom']            = stripslashes($_POST['nom']);
			    $_POST['prenom']         = stripslashes($_POST['prenom']);
			    $_POST['t_sub_category'] = stripslashes($_POST['t_sub_category']);
			    $_POST['mobile']         = stripslashes($_POST['mobile']);
			    $_POST['email']          = stripslashes($_POST['email']);
			    $_POST['adresse']        = stripslashes($_POST['adresse']);			
			    $_POST['ville']          = stripslashes($_POST['ville']);	
			    $_POST['ville-value']    = stripslashes($_POST['ville-value']);
			    $_POST['connection']     = stripslashes($_POST['connection']);
			    $_POST['commentaires']   = stripslashes($_POST['commentaires']); 
				}
				
				List($first_name_aff, $id_affiliate, $id_partenaire_aff, $email_aff, $id_upline, $id_partenaire_is_iad, $source, $parrain_is_iad, $id_parrain_is_iad, $id_parrain_2_is_iad ) = RETURN_SESSION_FROM_ID_AFFILIATE($connection_database2, $id_affiliate );

				mysql_query('SET NAMES utf8');										 						 	 
                $result_AZE             = mysql_fetch_array(mysql_query( " SELECT s_category FROM services WHERE id_services = ".$_POST['s_sub_category_code']."    " )) or die("Merci de ne pas modifier l'URL ! :( ");
				$s_category             = strtolower(trim($result_AZE['s_category']));
				

				
				$first_id_part_algo     = $_POST['first_id_partenaire_algorithme'];
				$first_name             = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['prenom']))));
				$last_name              = trim(strtoupper(mysql_real_escape_string($_POST['nom'])));
				$s_sub_category_code    = mysql_real_escape_string($_POST['s_sub_category_code']);	
				$t_sub_category         = mysql_real_escape_string($_POST['t_sub_category']);	
                $id_privileged_partner  = mysql_real_escape_string($_POST['partner']);				
				$mobile                 = mysql_real_escape_string($_POST['mobile']);	
				$email                  = trim(strtolower(mysql_real_escape_string($_POST['email'])));	
				$adresse                = trim(mysql_real_escape_string($_POST['adresse']));
				$ville                  = ucfirst(strtolower(mysql_real_escape_string(trim(substr($_POST['ville'], 6, 60)))));
				$cp                     = mysql_real_escape_string($_POST['ville-value']);	
				$connection             = mysql_real_escape_string($_POST['connection']);	
				$commentaires           = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['commentaires']))));
			    $id_reco_max            = mysql_fetch_array(mysql_query(" SELECT IFNULL(max(id_recommandation)+1, 1) as id_recommandation FROM recommandation_details "));
				$id_new_reco            = $id_reco_max['id_recommandation'];
				$source_recommandation  = "APPLI";
				
				//$id_privileged_partner  = 60; // BENJAMIN ALLAIS - A SUPPRIMER  // UNIQUEMENT POUR LES TESTS - A SUPPRIMER 

				mysql_query('SET NAMES utf8');				
			    $result                 = mysql_fetch_row(mysql_query("SELECT s_sub_category FROM services WHERE id_services =".$s_sub_category_code." limit 0,1")) or die("Requete pas comprise - Insert Recommandation ");
                $s_sub_category         = $result[0]; // mysql_fetch_row returns an array.
				
				
				IF ($id_privileged_partner == 0)  // PAS DE PARTENAIRE CHOISI PAR L'AFFILIE 
				 { 
				     $reco_statut = 2;  
					 IF ($first_id_part_algo > 0 AND $s_sub_category_code == 1)
					     {$reco_statut = 3; }
				 } 
				 ELSE 
				 {   
				     $reco_statut = 3;
					 // ON RÉAFFECTE A UN REMPLACANT SI LE PARTENAITRE EN A CHOISI UN 
					 List ( $id_privileged_partner , $the_same_partner  ) = ID_PARTENAIRE_REMPLACANT_VACANCES($connection_database2, $s_sub_category_code, $id_privileged_partner  );	
				 }

				date_default_timezone_set('Europe/Paris');
				$sql = ' insert into recommandation_details(id_recommandation, id_affiliate, r_status, r_creation_date, r_category, r_sub_category, r_sub_category_code, id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_country, r_lat, r_long, r_first_name, r_last_name, r_phone_number, r_email, r_connection_with, r_details, r_gain, r_commentary, r_managed_date, choose_to_not_pay, choose_to_pay_association, source ) 
				         values ( "'.$id_new_reco.'","'.$id_affiliate.'","'.$reco_statut.'", CURRENT_TIMESTAMP,"'.$s_category.'", "'.$s_sub_category.'","'.$s_sub_category_code.'", "'.$id_privileged_partner.'", "'.$t_sub_category.'","'.$adresse.'","'.$cp.'","'.$ville.'","'.$_POST['ville-country'].'","'.$_POST['ville-latitude'].'", "'.$_POST['ville-longitude'].'","'.$first_name.'", "'.$last_name.'","'.$mobile.'", "'.$email.'", "'.$connection.'","details","","'.$commentaires.'",CURRENT_TIMESTAMP,"'.$to_not_pay_checked.'","'.$choose_to_pay_association.'","'.$source_recommandation.'")	';
				
				IF( mysql_query( $sql ) )
					{
						 //////////////////////      SI ÇA A FONCTIONNÉ ON AFFICHE UNE CONFIRMATION      ///////////////////////////				
                         $result_1       = mysql_fetch_array(mysql_query("SELECT first_name, last_name, phone_number, email, id_affiliate, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #VGT31! ");
					     $details        = "- Service : ".$s_sub_category." \n - Recommandation : ".$first_name." ".$last_name." ".$adresse." ".$cp." ".$ville." - ".$email."  \n - Affilié : ".$result_1['first_name']	."  ".$result_1['last_name']."   ".$result_1['phone_number']."   ".$result_1['email']."  -  ".$result_1['zip_code']."  ".$result_1['city']."   ";
						 INSERT_ACTION_LIST("Étape 1", 10, " Recommandation envoyée à NosRezo"    , $id_new_reco , $id_privileged_partner, $id_affiliate, "FERME", $details ,"Dossier initialisé", "Service Admin", 0, ""); 
						 UPDATE_IS_PROTECTED_UP($connection_database2, $id_affiliate , "is_protected" , "1" ); 
						 
						 IF ($id_privileged_partner == 0)      //////////////////////////////// PARTENAIRE NON CHOISI DANS LA LISTE - À AFFÉCTER EN ÉTAPE 2
						 { 
						    IF ($first_id_part_algo > 0 AND $s_sub_category_code == 1) //////// PARTENAIRE CHOISI PAR ALGORITHME
							 {
						     UPDATE_INFORMATION_RECOMMANDATION_DETAILS($id_new_reco, $first_id_part_algo, $commentaires, 3);
							 INSERT_ACTION_LIST("Étape 2", 12, " Recommandation envoyée au partenaire par algorithme.", $id_new_reco, $first_id_part_algo, $id_affiliate, "FERME", $details ,"Partenaire choisi par l'algorithme", "Service Admin", 0, "NEW"); 
						     $details  =  $details ." \n - Partenaire algorithme : ".id_partner_to_p_contact_name($first_id_part_algo);
						     INSERT_ACTION_LIST("Étape 3", 13, " Traitement de la recommandation par le partenaire", $id_new_reco, $first_id_part_algo, $id_affiliate, "OUVERT", $details ,"En attente retour partenaire avant relance", "Service Admin", 2, "NEW"); 
						     SEND_EMAIL_PARTENAIRE_RECO($connection_database2, $id_new_reco, 1); 							 
							 }
						    ELSE  ////////////////////////////////////////////////////////////// PARTENAIRE NON CHOISI PAR ALGORITHME - À AFFÉCTER EN ÉTAPE 2
						     {
							  INSERT_ACTION_LIST("Étape 2", 11, " Affecter un partenaire." , $id_new_reco, $id_privileged_partner, $id_affiliate, "OUVERT", $details ,"Laissez NosRezo choisir un partenaire - ".$first_id_part_algo." pour ".$s_sub_category_code , "Service Admin", 2, "NEW"); 
						      $first_id_part_algo = 0;
							 }

						 }
                         ELSE  ////////////////////////////////////////////////////////////////// PARTENAIRE CHOISI - ON ENVOI LE MAIL AU PARTENAIRE                            
						 { 
						     insert_action_list("Étape 2", 12, " Recommandation envoyée directement au partenaire.", $id_new_reco, $id_privileged_partner, $id_affiliate, "FERME", $details ,"Partenaire choisi par l'affilié", "Service Admin", 0, "NEW"); 
						     $details  =  $details ." \n - Partenaire choisi par affilié : ".id_partner_to_p_contact_name($id_privileged_partner);
						     insert_action_list("Étape 3", 13, " Traitement de la recommandation par le partenaire", $id_new_reco, $id_privileged_partner, $id_affiliate, "OUVERT", $details ,"En attente retour partenaire avant relance", "Service Admin", 2, "NEW"); 
						
						     SEND_EMAIL_PARTENAIRE_RECO($connection_database2, $id_new_reco, 1); 
							 SEND_EMAIL_AFFILIE_STATUT($connection_database2, $id_reco_max['id_recommandation'], 0, "Envoi de votre recommandation au partenaire que vous avez choisi.");
						 }
						 
		                 INSERT_TIMELINE( 1, 3, $s_sub_category_code , $ville, "", 0, $id_affiliate,"", 0, "", ""  );
						 SEND_EMAIL_RECOMMANDATION($connection_database2, $id_reco_max['id_recommandation'], $id_affiliate, $s_category, $s_sub_category, $cp, $ville, $commentaires, $connection, $id_privileged_partner, $first_id_part_algo, $source_recommandation);
						 
                                      echo json_encode(                          
                                          array(                          
                                              "data" => 1,
								              "ERROR_MESSAGE" => $ERROR_MESSAGE
                                               )
                                      );
						
					}
					ELSE
					{
                                      echo json_encode(                          
                                          array(                          
                                              "data" => 2,
								              "ERROR_MESSAGE" => $ERROR_MESSAGE
                                               )
                                      );
					}
					
				
					
}
?> 
