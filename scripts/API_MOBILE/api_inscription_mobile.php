<?php  
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

       // API API_INSCRIPTION.PHP - CALLED MOBILES APS
       // RETURN <20 : ERROR FORMAT
               // 2 : PB FORMAT AU NIVEAU DU NOM
               // 3 : PB FORMAT AU NIVEAU DU PRENOM	
               // X : ...			   
       // RETURN 20  : ERROR PLUS DE PLACES DISPONIBLES  
       // RETURN 100 : OK    -  INSCRIPTION OK	
	   
             session_start ();                    // ON OUVRE LA SESSION EN COURS        
             require('../functions.php');         // ON DÉFINI LES FUNCTIONS             
             include('../config.php');            // ON SE CONNECTE A LA BASE DE DONNÉES 
			 //include('../config_PDO.php');
	         List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");
			 
             $postdata                   = file_get_contents("php://input");    # Récupération du JSON
             $request                    = json_decode($postdata);              # Décodage du JSON en array
            // $_POST['jour_n']            = $request->jour_n; 
             $_POST['email']             = $request->email; 
             $_POST['nom']               = $request->nom; 
             $_POST['prenom']            = $request->prenom; 
             $_POST['mobile']            = $request->mobile; 
             $_POST['email2']            = $request->email2; 
             $_POST['cp']                = $request->cp; 
             $_POST['ville']             = $request->ville;
             $id_parrain_1               = $request->id_parrain;
             $_POST['gender']            = $request->gender;
			 
             $_POST['name_parrain']      = $request->name_parrain;
             $_POST['source_appel_appli']= $request->source_appel_appli;			 
             
			 $_POST['jour_n']	         = '06/09/1990';			 
			 

        	 IF ( !isset($_POST['c_g_i']))                     { $_POST['c_g_i']                  = 1;}
        	 IF ( !isset($_POST['plus_de_18_ans']))            { $_POST['plus_de_18_ans']         = 1;}
        	 IF ( !isset($_POST['ville_n']))                   { $_POST['ville_n']                = "";}
        	 IF ( !isset($_POST['adresse']))                   { $_POST['adresse']                = "";}
        	 IF ( !isset($_POST['nationalite']))               { $_POST['nationalite']            = "FR";}
        	 IF ( !isset($_POST['name_parrain']))              { $_POST['name_parrain']           = "";}
        	 IF ( !isset($_POST['source_appel_appli']))        { $_POST['source_appel_appli']     = 1;}
        	 
             $ERROR_FORMULAIRE  = 0;
			 $ERROR_MESSAGE     = '';  
             $_POST['email']    = mysql_real_escape_string(stripslashes($_POST['email']));
			 
       		   
                  IF (empty($_POST['nom']))                                                                        { $ERROR_FORMULAIRE = 2;  $ERROR_MESSAGE = ' INVALIDE  ';   }
             ELSE IF (trim($_POST['nom']) =='')                                                                    { $ERROR_FORMULAIRE = 2;  $ERROR_MESSAGE = ' INVALIDE  ';   }
             ELSE IF (empty($_POST['prenom']))                                                                     { $ERROR_FORMULAIRE = 3;  $ERROR_MESSAGE = ' Prénom vide  ';   }
             ELSE IF (trim($_POST['prenom']) =='')                                                                 { $ERROR_FORMULAIRE = 3;  $ERROR_MESSAGE = ' Prénom non valide  ';   }
             ELSE IF (empty($_POST['mobile']))                                                                     { $ERROR_FORMULAIRE = 3;  $ERROR_MESSAGE = ' mobile vide  ';   }
             ELSE IF (strlen($_POST['mobile']) < 4)                                                                { $ERROR_FORMULAIRE = 4;  $ERROR_MESSAGE = ' Numéro de mobile non valide  ';   }	  
             ELSE IF (trim($_POST['email']) <> trim($_POST['email2']))                                             { $ERROR_FORMULAIRE = 5;  $ERROR_MESSAGE = ' Les emails sont différents  ';   }
             ELSE IF (empty($_POST['cp']))                                                                         { $ERROR_FORMULAIRE = 6;  $ERROR_MESSAGE = ' INVALIDE  ';   }
//             ELSE IF (is_num($_POST['cp']) == 0)                                                                   { $ERROR_FORMULAIRE = 6;  $ERROR_MESSAGE = ' Code postal non valide  ';   }
             ELSE IF (strlen($_POST['cp']) < 3)                                                                    { $ERROR_FORMULAIRE = 6;  $ERROR_MESSAGE = ' Code postal non valide  ';   }	
             ELSE IF (empty($_POST['ville']))                                                                      { $ERROR_FORMULAIRE = 7;  $ERROR_MESSAGE = ' INVALIDE  ';   }	
             ELSE IF (trim($_POST['ville']) =='')                                                                  { $ERROR_FORMULAIRE = 7;  $ERROR_MESSAGE = ' INVALIDE  ';   }
        	 ELSE IF ($_POST['plus_de_18_ans'] == 0)                                                               { $ERROR_FORMULAIRE = 12; $ERROR_MESSAGE = ' INVALIDE  ';   }
             ELSE IF (CHECK_IF_AFFILIATE_ALREADY_EXIST($connection_database2, $_POST['email'])  >= 1 )             { $ERROR_FORMULAIRE = 14; $ERROR_MESSAGE = ' CET EMAIL EXISTE DEJA  ';   }
             ELSE IF (check_if_affiliate_already_exist_phone($connection_database2, $_POST['mobile'])  >= 1 )      { $ERROR_FORMULAIRE = 14; $ERROR_MESSAGE = ' CE MOBILE EXISTE DEJA  ';   }
             ELSE IF (   $_POST['source_appel_appli'] == 2 AND 
			             CHECK_PARRAIN_EXIST($connection_database2, trim($id_parrain_1), trim($_POST['name_parrain']) ) == 0 )            { $ERROR_FORMULAIRE = 13; $ERROR_MESSAGE = ' AUCUN AFFILIE NE CORRESPOND A VOTRE PARRAIN ';   }			 
			 
             //$ERROR_FORMULAIRE = 14; $ERROR_MESSAGE = ' $id_parrain_1 =  '.$id_parrain_1."-".$_POST['ville']." fini";  
			 
			 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
             /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 
                    IF ($ERROR_FORMULAIRE > 0 ) 
                       {
                          // PB FORMAT 
						  echo json_encode(                          
                              array(                          
                                  "data" => $ERROR_FORMULAIRE,
								  "ERROR_MESSAGE" => $ERROR_MESSAGE
                                   )
                              );
                       }	
                    ELSE     // LES DONNÉES NE SONT PAS VIDE 
                       {
                    		IF(get_magic_quotes_gpc())
                    		{
                    			    $_POST['nom']            = stripslashes($_POST['nom']);
                    			    $_POST['prenom']         = stripslashes($_POST['prenom']);
                    			    $_POST['name_parrain']   = stripslashes($_POST['name_parrain']);
                    			    $_POST['mobile']         = stripslashes($_POST['mobile']);
                    			    $_POST['email']          = stripslashes($_POST['email']);
                    			    $_POST['adresse']        = stripslashes($_POST['adresse']);			
                    			    $_POST['cp']             = stripslashes($_POST['cp']);
                    			    $_POST['ville']          = stripslashes($_POST['ville']);	
                    			    $_POST['ville_n']        = stripslashes($_POST['ville_n']);
                    			    $_POST['nationalite']    = stripslashes($_POST['nationalite']);
                    		}
                                    
									List($first_name_aff, $id_parrain, $id_partenaire_aff, $email_aff, $id_upline, $id_partenaire_is_iad, $source, $parrain_is_iad, $id_parrain_is_iad, $id_parrain_2_is_iad ) = RETURN_SESSION_FROM_ID_AFFILIATE($connection_database2, $id_parrain_1 );

									
									$date_n                 = $_POST['jour_n'];
                    				$first_name             = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['prenom']))));
                    				$last_name              = trim(strtoupper(mysql_real_escape_string($_POST['nom'])));
                    				$name_parrain           = trim(ucfirst(mysql_real_escape_string($_POST['name_parrain'])));	
                    				$mobile                 = mysql_real_escape_string($_POST['mobile']);	
                    				$email                  = trim(mysql_real_escape_string($_POST['email']));	
                    				$adresse                = trim(mysql_real_escape_string($_POST['adresse']));
                    				$cp                     = mysql_real_escape_string($_POST['cp']);	
                    				$ville                  = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['ville']))));
                    				$ville_n                = trim(ucfirst(mysql_real_escape_string($_POST['ville_n'])));	
                    				$nationalite            = trim(ucfirst(mysql_real_escape_string($_POST['nationalite'])));
                    				$nationalite            = 'FR';
                    				$id_affiliate_max       = ID_AFFILIATE_MAXIMUM($connection_database2, 0);
									
									
                    
                    		/////// CHECK IF AFFILIATE IS ABLE TO INVIT NEW NOSREZO MEMBERS
                    		//List ($nb_filleul, $id_partenaire, $is_able_to_invit, $first_name_parrain, $email_parrain, $phone_parrain) = nb_filleul_affiliate( $id_parrain );
                            List ($nb_filleul_L1, $nb_filleul_L2, $is_able_to_invit, $first_name_parrain, $email_parrain, $phone_parrain, $nb_place_disponible, $numero_de_pack, $grade_nosrezo ) = IS_ABLE_TO_PARRAINER( $connection_database2, $id_parrain  ); 							

                            IF ( $is_able_to_invit == 0) // PAS DE PLACE POUR DE NOUVEAUX FILLEULS
                    		{
                    				  $ERROR_MESSAGE = "Oups : Vous n'avez plus de places disponibles !";
									  include('../email/max_filleul_atteint_parrain.php');
                    				  SEND_EMAIL_MAX_FILLEUL( $connection_database2, $id_parrain , $first_name." ".$last_name , $cp." ".$ville , $mobile , $serveur);
                                      echo json_encode(                          
                                          array(                          
                                              "data" => 20,
								              "ERROR_MESSAGE" => $ERROR_MESSAGE
                                               )
                                      );		  
                    		}
                    		ELSE
                    		{
                    		        $country           = "France";
									List ($latitude, $longitude) = GEO_LOCALISATION_ADRESSE($cp, $ville , $adresse, "INSERT AFFILIE", $country);         				
                    		        IF (INSERT_INTO_AFFILIATE_DETAILS( $connection_database2, $id_parrain , $id_affiliate_max, 0, "En cours", $_POST['gender'], $first_name, $last_name, $adresse, $cp, $ville, $mobile, $email, "", "", $date_n, $ville_n, $nationalite, 0, 1, $latitude, $longitude) == 1)
                    		        {
                    		        			 
												 UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $id_parrain , "is_protected" , "1" );
												 
												 
												 
												 
												 ///////// SI INSERTION AFFILIATE ALORS ON ENVOI MAIL DE CONFIRMATION							 
                    		        		     include('../email/Inscription_email_2.php'); 
                    		        			 SEND_EMAIL_INSCRIPTION_NOUVEAU($connection_database2, $id_affiliate_max, $serveur, $lien_webinar, "PRODUCTION", "10 JOURS", "Activation de votre compte provisoire NosRezo");
                                                 echo json_encode(                          
                                                     array(                          
                                                         "data" => 100,
								                         "ERROR_MESSAGE" => $ERROR_MESSAGE

                                                          )
                                                 );
                    		        }
                    		        ELSE         ///////// SI ÇA NE FONCTIONNE PAS : LA CRÉATION DE L'AFFILIÉ A ECHOUÉ POUR UN PROBLÉME TECHNIQUE
                    		        {
                                                 echo json_encode(                          
                                                     array(                          
                                                         "data" => 0,
								                         "ERROR_MESSAGE" => $ERROR_MESSAGE
                                                          )
                                                 ); 
                    		        }
                    		}		
                    				
                       }

?> 
