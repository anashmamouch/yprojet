<?php   require('functions.php');                // ON DÉFINI LES FUNCTIONS ?>
<?php   require('function_12345678910.php');     // ON DÉFINI LES FUNCTIONS ?>
<?php   include('config.php');                   // ON SE CONNECTE A LA BASE DE DONNÉE 
        session_start ();                      

        include('config_PDO.php');  
List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");


//ON VÉRIFIE QUE LE FORMULAIRE A ÉTÉ ENVOYÉ ET QUE LES DONNÉES NE SONT PAS VIDE
     $ERROR_FORMULAIRE = 0;
	 
          IF (empty($_POST['Commentaires']))                    { $ERROR_FORMULAIRE = 1; }
     ELSE IF (trim($_POST['Commentaires']) == '')               { $ERROR_FORMULAIRE = 1; }
     ELSE IF (strlen(trim($_POST['Commentaires'])) < 110)       { $ERROR_FORMULAIRE = 2; }
	 

IF ($ERROR_FORMULAIRE > 0 ) 
   {		
		IF(get_magic_quotes_gpc())   { $_POST['Commentaires']      = stripslashes($_POST['Commentaires']); }
		
    	echo '<form name="p_action"  action="../Intranet_Noter_partenaire.php" method="post">  ';
	    echo '<input type="hidden" name="id_partner"                  value = "'.$_POST['id_partner'].'"     >';
	    echo '<input type="hidden" name="id_recommandation"           value = "'.$_POST['id_recommandation'].'"     >';
	    echo '<input type="hidden" name="error_code"                  value = '.$ERROR_FORMULAIRE.'     >';
	    echo '<input type="hidden" name="Commentaires"                value = "'.trim($_POST['Commentaires']).'"     >';
	    echo '<script language="JavaScript">document.p_action.submit();</script></form>';
   }	
ELSE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
IF( isset($_POST['id_recommandation'], $_SESSION['id_affiliate'] ) )
{
        //ON ENLÈVE L'ÉCHAPPEMENT SI GET_MAGIC_QUOTES_GPC EST ACTIVE
		IF(get_magic_quotes_gpc())
		        {
        		$_POST['reactivite']        = stripslashes($_POST['reactivite']);
         		$_POST['Professionnalisme'] = stripslashes($_POST['Professionnalisme']);
			    $_POST['Devis']             = stripslashes($_POST['Devis']);
        		$_POST['Commentaires']      = stripslashes($_POST['Commentaires']);
				}
				
				$id_afffiliate              = $_SESSION['id_affiliate'];
				$id_recommandation          = $_POST['id_recommandation'];
				$reactivite                 = mysql_real_escape_string($_POST['reactivite']);				
				$professionnalisme          = mysql_real_escape_string($_POST['Professionnalisme']);				
				$devis                      = mysql_real_escape_string($_POST['Devis']);
				$commentaires               = trim(mysql_real_escape_string($_POST['Commentaires']));
				$name_partner               = mysql_real_escape_string($_POST['name_partner']);
				$sum_note                   = convert_note_partenaire($reactivite) + convert_note_partenaire($professionnalisme) + convert_note_partenaire($devis);
				$id_note_max                = mysql_fetch_array(mysql_query("SELECT max(id_notation)+1 as id_notation FROM partner_notation_details")) or die("Requete pas comprise - #partner_notation_details! ");
				
				mysql_query('SET NAMES utf8');
				date_default_timezone_set('Europe/Paris');
				if(mysql_query('insert into partner_notation_details(id_notation, id_recommandation, id_partner, reactivite, professionnalisme, devis, sum_notation, commentaires, p_notation_date, is_activated ) 
				                             values (
											 "'.$id_note_max['id_notation'].'",
											 "'.$_POST['id_recommandation'].'", 
											 "'.$_POST['id_partner'].'",
											 "'.$reactivite.'",
											 "'.$professionnalisme.'",
											 "'.$devis.'",
											 "'.$sum_note.'",
											 "'.$commentaires.'",
											 CURRENT_TIMESTAMP,
											 "0")												 
											 ') )
					{
						//SI ÇA A FONCTIONNÉ :
						
						//1. ON MET À JOUR LE STATUT DE LA RECOMMANDATION 				
						UPDATE_STATUS_RECOMMANDATION_DETAILS($connection_database2, $id_recommandation , '9');
						
						//2. ON FERME LA NOTIFICATION 	
						UPDATE_ACTION_NOTIFICATION_STATUS($_SESSION['id_affiliate'], 2);

						//3. ON INSÉRE UN HISTORIQUE ET UNE ACTION À TRAITER
                        INSERT_ACTION_LIST("Notation reçue" , 18, "Notation reçue. En attente de confirmation par NosRezo." , $id_recommandation, $_POST['id_partner'], $_SESSION['id_affiliate'] , "FERME", " - Note :".$sum_note." sur 18. \n - Commentaires :".$commentaires ,"", "Service Admin", 2, "");					
                        INSERT_ACTION_LIST("9. Valider note" , 2, "Note du partenaire" , $id_recommandation , $_POST['id_partner'], $_SESSION['id_affiliate'] , "OUVERT", " - Note : ".$sum_note." sur 18. \n - Commentaire : ".$commentaires ,"", "Service Admin", 2, "");
						
						//4. TRAITEMENT DE L'ACTION SI LA NOTE EST CORRECTE [ MAX = 18 ]
						IF ( $sum_note > 13 )
						     {
				                        // 1. MISE A JOUR DE LA NOTE DU PARTENAIRE
				                        UPDATE_PARTNER_NOTATION_DETAILS(1, $id_recommandation);   
					                                         
					                    // 2. VÉRIFICATION SI AFFILIÉ EST APPORTEUR 
					                        IF ( is_apporteur($id_afffiliate ) <> 1 ) 
					                                {  // MAIL DE RELANCE POUR SIGNER LE CONTRAT
					  	                 		     $nom = nom_prenom_affiliate($id_afffiliate);
					  	                 		     $message = "La note du partenaire est prise en compte. Félicitations, votre recommandation est finalisée. Afin de recevoir votre commission, vous devez nous envoyer votre contrat signé que vous trouverez dans la F.A.Q. Pensez également à renseigner vos informations personnelles et demander le virement via votre intranet. Pour toute question, n'hésitez pas à solliciter votre parrain.";
					  	                 	         insert_action_list("9. Activer apporteur", 5, "En attente de signature électronique du contrat NR de ".$nom, $id_recommandation, 0,$id_afffiliate, "OUVERT", " Un mail de relance a été envoyé à l'affilié ".$nom." pour qu'il signe le contrat." ,"", "Service Admin",2, ""); 
					  	                 		 }
					  	                 ELSE
                                                   {
					  	                 		     $message = "La note du partenaire est prise en compte. Félicitations, votre recommandation est finalisée. Afin de recevoir votre commission, pensez à valider vos informations personnelles et demander le virement via votre intranet. Pour toute question, n'hésitez pas à solliciter votre parrain."; 
                                                   } 
                                        
					                    // 3. FERMETURE DE L'ACTION EN COURS SUR LES NOTES PARTENAIRES 
					                     UPDATE_ACTION_LIST_STATUT_RECO_CATEGORY($id_recommandation, 2, 'FERME', $message,'');
					                     SEND_EMAIL_AFFILIE_STATUT($connection_database2, $id_recommandation, 2, ""); 
					                     insert_action_notification($id_afffiliate, 3, 1, 0, "icon-info", "Demandez votre commission !", "Intranet_ma_remuneration.php"); 
								 
						     }
						ELSE
						{
							mail('contact@nosrezo.com','NOSREZO - Mauvaise note à traiter', "Note : ".$sum_note." / 18 - Julie, Faire un filtre sur table des actions avec : Note à valider, puis faire un retour à KARIM sur ce dossier. "  );
						}
						
						
						//5.  AFFICHE UNE CONFIRMATION 	
						echo '<body onLoad="alert(\'Prise en compte de la notation du partenaire. Cliquez sur : Mon Suivi / Equipe - Remuneration puis ENCAISSER, si vous souhaitez recevoir votre commission.  \')">'; 
                        echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}
					else
					{
	              		echo '<body onLoad="alert(\'Notation non prise en compte : merci de contacter le support contact@nosrezo.com. \')">'; 
                        echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}
}
?> 
