<?php  

       // API API_INSCRIPTION.PHP - CALLED BY SIGNUP.PHP
       // RETURN <20 : ERROR FORMAT
               // 2 : PB FORMAT AU NIVEAU DU NOM
               // 3 : PB FORMAT AU NIVEAU DU PRENOM	
               // X : ...			   
       // RETURN 20  : ERROR PLUS DE PLACES DISPONIBLES  
       // RETURN 100 : OK    -  INSCRIPTION OK	
	   
             session_start ();                 // ON OUVRE LA SESSION EN COURS        
             require('functions.php');         // ON DÉFINI LES FUNCTIONS             
             include('config.php');            // ON SE CONNECTE A LA BASE DE DONNÉES 			 
			 include('config_PDO.php');
	         List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	
	
        	 IF (!isset($_POST['c_g_i']))                      { $_POST['c_g_i']                    = 0;}
        	 IF (!isset($_POST['plus_de_18_ans']))             { $_POST['plus_de_18_ans']           = 0;}
        	 IF (!isset($_POST['pas_de_parrain_nosrezo']))     { $_POST['pas_de_parrain_nosrezo']   = 0;}			 
        	 IF (!isset($_POST['ville_n']))                    { $_POST['ville_n']                  = "";}
        	 IF (!isset($_POST['adresse']))                    { $_POST['adresse']                  = "";}
        	 IF (!isset($_POST['nationalite']))                { $_POST['nationalite']              = "FR";}
        	 IF (!isset($_POST['lange_parlee']))               { $_POST['lange_parlee']             = "fr_FR";    $_POST['nationalite']  = "FR";      }
        	 IF (trim($_POST['lange_parlee']) == "pt_PT")      {                                                  $_POST['nationalite']  = "PORTUGAL";}

        	 $_POST['mobile'] = str_replace(" ", "", $_POST['mobile']); // ON SUPPRIME LES ESPACES
             $ERROR_FORMULAIRE  = 0;
        	 //$age_affilie       = CALCUL_AGE(trim($_POST['jour_n']));  
             $_POST['email']    = mysql_real_escape_string(stripslashes($_POST['email']));
        		  
                  IF (empty($_POST['nom']))                                                                        { $ERROR_FORMULAIRE = 2;   }
             ELSE IF (trim($_POST['nom']) =='')                                                                    { $ERROR_FORMULAIRE = 2;   }
             ELSE IF (empty($_POST['prenom']))                                                                     { $ERROR_FORMULAIRE = 3;   }
             ELSE IF (trim($_POST['prenom']) =='')                                                                 { $ERROR_FORMULAIRE = 3;   }
             ELSE IF (empty($_POST['mobile']))                                                                     { $ERROR_FORMULAIRE = 3;   }
             ELSE IF (is_num($_POST['mobile']) == 0)                                                               { $ERROR_FORMULAIRE = 4;   }
             ELSE IF (strlen($_POST['mobile']) < 6)                                                                { $ERROR_FORMULAIRE = 4;   }	 
             ELSE IF (substr($_POST['mobile'], 0, 2) == "08")                                                      { $ERROR_FORMULAIRE = 4;   }	 
             ELSE IF (trim($_POST['email']) <> trim($_POST['email2']))                                             { $ERROR_FORMULAIRE = 5;   }
             ELSE IF (empty($_POST['cp']))                                                                         { $ERROR_FORMULAIRE = 6;   }
             ELSE IF (strlen($_POST['cp']) < 4)                                                                    { $ERROR_FORMULAIRE = 6;   }	
             ELSE IF (empty($_POST['ville']))                                                                      { $ERROR_FORMULAIRE = 7;   }	
             ELSE IF (trim($_POST['ville']) =='')                                                                  { $ERROR_FORMULAIRE = 7;   }
             ELSE IF (trim($_POST['jour_n']) =='')                                                                 { $ERROR_FORMULAIRE = 8;   }
        	 ELSE IF ($_POST['c_g_i'] == 0)                                                                        { $ERROR_FORMULAIRE = 12;  }
					 
             ELSE IF (CHECK_IF_AFFILIATE_ALREADY_EXIST($connection_database2, $_POST['email'])  >= 1 )             { $ERROR_FORMULAIRE = 14;  }
             ELSE IF (CHECK_IF_AFFILIATE_ALREADY_EXIST_PHONE($connection_database2, $_POST['mobile'])  >= 1 )      { $ERROR_FORMULAIRE = 14;  }
			 //ELSE IF ($age_affilie == 0)                                                                           { $ERROR_FORMULAIRE = 9;   } //////  PB DE FORMAT
             //ELSE IF ($age_affilie < 18)                                                                           { $ERROR_FORMULAIRE = 10;  } //////  ANNIVERSAIRE
        	 //ELSE IF ($_POST['plus_de_18_ans'] == 0)                                                               { $ERROR_FORMULAIRE = 12;  }
             //ELSE IF (is_num($_POST['cp']) == 0)                                                                   { $ERROR_FORMULAIRE = 6;   }			 
			 
			 
			 IF ( $ERROR_FORMULAIRE == 0 AND $_POST['pas_de_parrain_nosrezo'] == 0 )                 // UN PARRAIN EST DÉCLARÉ CHEZ NOSREZO
			     { 
			         IF (is_num($_POST['id_parrain']) == 0)                                                                { $ERROR_FORMULAIRE = 11;  }
                     ELSE IF (CHECK_PARRAIN_EXIST($connection_database2, trim($_POST['id_parrain']), trim($_POST['name_parrain']) ) == 0 )        { $ERROR_FORMULAIRE = 13;  }					 
				 }
			 ELSE IF( trim($_POST['id_parrain']) == "" AND $_POST['pas_de_parrain_nosrezo'] == 1 )   // PAS DE PARRAIN DÉCLARÉ CHEZ NOSREZO
			     {
			         $_POST['id_parrain']   = 37286;
					 $_POST['name_parrain'] = "TEMPORAIRE";
				 
				 }
			 
			 
			 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
             //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 
                    IF ($ERROR_FORMULAIRE > 0 ) 
                       {
     		                  echo $ERROR_FORMULAIRE ; // PB FORMAT 
                       }	
                    ELSE     //LES DONNÉES NE SONT PAS VIDE 
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
                    		//List ($nb_filleul, $id_partenaire, $is_able_to_invit, $first_name_parrain, $email_parrain, $phone_parrain) = nb_filleul_affiliate($_POST['id_parrain']); 
                            List ($nb_filleul_L1, $nb_filleul_L2, $is_able_to_invit, $first_name_parrain, $email_parrain, $phone_parrain, $nb_place_disponible, $numero_de_pack, $grade_nosrezo, $is_protected  ) = IS_ABLE_TO_PARRAINER( $connection_database2, $_POST['id_parrain'] ); 							

                            IF ( $is_able_to_invit == 0) // PAS DE PLACE POUR DE NOUVEAUX FILLEULS
                    		{
                    				  include('email/max_filleul_atteint_parrain.php');
                    				  SEND_EMAIL_MAX_FILLEUL($connection_database2, $_POST['id_parrain'], $first_name." ".$last_name , $cp." ".$ville , $mobile , $serveur);
                    				  echo 20 ; 		  
                    		}
                    		ELSE
                    		{
                    		        $country           = "";
									List ($latitude, $longitude) = GEO_LOCALISATION_ADRESSE($cp, $ville , $adresse, "INSERT AFFILIE", $country);        				
                    		        IF (INSERT_INTO_AFFILIATE_DETAILS($connection_database2, $_POST['id_parrain'], $id_affiliate_max, 0, "En cours", $_POST['gender'], $first_name, $last_name, $adresse, $cp, $ville, $mobile, $email, "", "", $date_n, $ville_n, $nationalite, 0, 1, $latitude, $longitude) == 1)
                    		        {
										
										     UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $_POST['id_parrain'] , "is_protected" , "1" );
											 IF ( trim($_POST['lange_parlee']) == "fr_FR" )
											 {
                    		        			 ///////// SI INSERTION AFFILIATE ALORS ON ENVOI MAIL DE CONFIRMATION	//////////////////						 
                    		        		     include('email/Inscription_email_2.php');  
                    		        			 SEND_EMAIL_INSCRIPTION_NOUVEAU($connection_database2, $id_affiliate_max, $serveur, $lien_webinar, "PRODUCTION", "10 JOURS", "Activation de votre compte provisoire NosRezo");
												 IF ( $is_protected == 0 ) 
												 { 
												 SEND_EMAIL_VALIDATION_DU_COMPTE($id_affiliate_max, $serveur, $lien_webinar, "PRODUCTION", "", "Félicitations, votre compte gratuit est validé");
											     }
											 }
											 ELSE IF ( trim($_POST['lange_parlee']) == "pt_PT"  )
											 {
                    		        		     UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $id_affiliate_max , "is_protected" , "1" );
												 include('email/Inscription_email_3_portugal.php'); 
                    		        		     SEND_EMAIL_INSCRIPTION_NOUVEAU_PORTUGAL( $connection_database2, $id_affiliate_max, $serveur);
											 }										
										
                    		        			 echo 100 ;										
										
										
										

                    		        }
                    		        ELSE         ///////// SI ÇA NE FONCTIONNE PAS : LA CRÉATION DE L'AFFILIÉ A ECHOUÉ POUR UN PROBLÉME TECHNIQUE
                    		        {
                    	                    	 echo 0 ; 
                    		        }
                    		}		
                    				
                       }

?> 
