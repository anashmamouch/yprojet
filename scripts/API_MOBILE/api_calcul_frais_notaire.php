<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');


     session_start();                                              // ON OUVRE LA SESSION EN COURS
     include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
     require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 
     require('../config_PDO.php');                                 // ON SE CONNECTE A LA BASE DE DONNÉE 	
     List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");

     $postdata           = file_get_contents("php://input");       // RÉCUPÉRATION DU JSON
     $request            = json_decode($postdata);
     $id_affiliate       = 0;
     
     // 1.DÉCODAGE DU JSON EN ARRAY //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         $montant_achat_bien    = $request->montant_achat_bien;
		 $taux_vote_departement = $request->taux_vote_departement;
         $type_bien             = $request->type_bien;
         $id_affiliate          = $request->id_affiliate;
         $date_simulation       = date("Y-m-d H:i:s");
     
         // $type_bien = 1 >> immobilier ancien 
	     // $type_bien = 2 >> immobilier neuf
		 
	 
     // 2. INITIALISATION DES VARIABLES /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         $emoluments_de_notaire                = 0;
         $droits_de_mutation                   = 0;
         $contribution_de_securite_immobiliere = 0;
         $emoluments_de_formalites             = 0;
         $frais_divers                         = 0;
		 $total                                = 0;
		 $pourcentage_total                    = 0;	 
	 
     
     // 2. FORMULE CALCUL DÉTAILS FRAIS DE NOTAIRE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
		 IF ( $montant_achat_bien >= 1000 ) 
		 {
		     // 1. EMOLUMENTS_DE_NOTAIRE  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			          IF ( $montant_achat_bien < 6501  )     { $emoluments_de_notaire = $montant_achat_bien * 4/100;                 } 
			     ELSE IF ( $montant_achat_bien < 17001 )     { $emoluments_de_notaire = $montant_achat_bien * 1.65/100  + 152.75;    } 			 
			     ELSE IF ( $montant_achat_bien < 60001 )     { $emoluments_de_notaire = $montant_achat_bien * 1.10/100  + 246.25;    } 			 
			     ELSE                                        { $emoluments_de_notaire = $montant_achat_bien * 0.825/100 + 411.25;    } 			 
				 
				 $emoluments_de_notaire = round( $emoluments_de_notaire *1.2 , 0, PHP_ROUND_HALF_DOWN); // AJOUT DE LA TVA POUR LES NOTAIRES
				 
				 
			 // 2. DROITS_DE_MUTATION //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                      IF ( $type_bien == 1 )   { $droits_de_mutation = round( $montant_achat_bien*5.80665/100, 0, PHP_ROUND_HALF_DOWN); }
                 ELSE IF ( $type_bien == 2 )   { $droits_de_mutation = round( $montant_achat_bien*0.71498/100, 0, PHP_ROUND_HALF_DOWN); }	

                 IF ( $taux_vote_departement <> '0.045' ) 	{ $droits_de_mutation = round( $droits_de_mutation*(1-0.7/100), 0, PHP_ROUND_HALF_DOWN); }		
                 // http://www.pap.fr/actualites/les-frais-de-mutation-dits-frais-de-notaire-augmentent-aussi-a-paris-et-en-mayenne/a15999				 
				 
			 // 3. CONTRIBUTION_DE_SECURITE_IMMOBILIERE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 $contribution_de_securite_immobiliere = round($montant_achat_bien * 0.10/100, 0, PHP_ROUND_HALF_DOWN);
				 IF ( $contribution_de_securite_immobiliere < 15 ) { $contribution_de_securite_immobiliere = 15; }
				 
				 
			 // 4. EMOLUMENTS_DE_FORMALITES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				 $emoluments_de_formalites = 500;

				 
			 // 5. FRAIS_DIVERS	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 $frais_divers  = 500;
				 
				 
				 
				 
				 
			 // 6. TOTAL //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		     $total               = round( $emoluments_de_notaire + $droits_de_mutation + $contribution_de_securite_immobiliere + $emoluments_de_formalites + $frais_divers, 0, PHP_ROUND_HALF_DOWN);
		     $pourcentage_total   = round( $total/$montant_achat_bien*100 , 2, PHP_ROUND_HALF_DOWN);

		 
		 }
		 

		 
     $json[] = array('emoluments_de_notaire' => $emoluments_de_notaire, 
	                 'droits_de_mutation' => $droits_de_mutation, 
					 'contribution_de_securite_immobiliere' => $contribution_de_securite_immobiliere,
					 'emoluments_de_formalites' => $emoluments_de_formalites,
					 'frais_divers' => $frais_divers,
					 'total' => $total,
					 'pourcentage_total' => $pourcentage_total,
					 'date_maj' => $date_simulation,
					 'type_bien' => $type_bien   
					 ); 
					 
     echo json_encode($json);
	 
	 
?>