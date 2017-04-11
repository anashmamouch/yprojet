<?php  function UPDATE_PARTNER_LIST_SMART($connection_database2, $id_partner, $id_field, $c_value) 
{
				$c_value = stripslashes($c_value);
				$c_value = addslashes($c_value);
     IF ( $id_partner > 0 )
     {		 
				$sql = " UPDATE partner_list 
				         SET   $id_field    = \"$c_value\"							 
						 WHERE id_partner   = '$id_partner'          "; 
				mysql_query($sql) or die("Requete UPDATE_PARTNER_LIST_SMART pas comprise #AZ8JJ9");	
	 }		
	 return (1);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function CHECK_ACCESS_123($id_affiliate, $statut, $fake) 
{
      if ( empty($id_affiliate) or (trim($id_affiliate) == '') or ($id_affiliate > 10) or ($id_affiliate == -1) )
	     {return (0);}
	
	  if ($statut == "AFFILIE") 	     
	     {return (0);}
		 
      if (strtoupper(substr($id_affiliate,0,1)) == "P") 		
         {return (0);}	  

      if ( ($id_affiliate == 9) and ($statut = "COMPTABLE") ) 
	     {return (2);}	 
	 
      if ( ($id_affiliate < 11) and ($statut = "A.D.M.I.N") ) 
	     {return (1);}	
		 
}
?>

<?php  function COUNT_NB_ACTION_A_REALISER($connection_database2, $status, $type_action, $id_affiliate) 
{
              include('config.php');
              if ($type_action == 0)         { $sql = "SELECT * FROM action_list where action_statut = \"$status\"  ";}			  
	          else if ($type_action == 0)    { $sql = "SELECT * FROM action_list where action_statut = \"$status\" and owner_id =\"$id_affiliate\"       ";}
                   else 			         { $sql = "SELECT * FROM action_list where action_statut = \"$status\" and owner_id =\"$id_affiliate\" and action_id_category=\"$type_action\"      ";}
              $result = mysql_query($sql) or die("Site actuellement en Maintenance #A1");
              return (mysql_num_rows($result));
}
?>

<?php  function COUNT_NB_RECO_EN_RETARD_PARTENAIRE($connection_database2, $id_partner, $nb_days_a_ajouter) 
{
		 $date_jour       = date('Y-m-d ',time() + $nb_days_a_ajouter * 60*60*24 );
		 $reponse4        = mysql_fetch_array(mysql_query(" SELECT count(id_action) as nb_count 
		                                                    FROM   action_list 
															WHERE  id_partner = ".$id_partner." 
															AND    action_status_int  = 1
															AND    \"".$date_jour."\" >= action_max_date " )) or die("Requete pas comprise COUNT_NB_RECO_EN_RETARD_PARTENAIRE ");
		 $action_en_retard  = $reponse4['nb_count'];
		 return ( $action_en_retard );
		 
}
?>

<?php  function COUNT_NB_AFFILIES($connection_database2, $type_affiliés) 
{   // type_affiliés = ALL signifie que tous les affilies sont comptés / = ACTIF, que les actifs
              include('config.php'); 
	          if ($type_affiliés == "ALL") { $sql = "SELECT * FROM affiliate where id_affiliate > 10     ";}
              else 			               { $sql = "SELECT * FROM affiliate where where id_affiliate > 10 and is_activated = 1      ";}
              $result = mysql_query($sql) or die("Site actuellement en Maintenance #A267");
              return (mysql_num_rows($result));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_ACTION_LIST_MAX_DATE($connection_database, $id_action, $days) 
{
              include('config.php'); 
	          //date_default_timezone_set('Europe/Paris');
			  
			  $newdate = date('Y-m-d H:i:s',time()+$days*25*3600); // AVANCE de Xj

		      mysql_query(" UPDATE action_list 
						    SET action_max_date = '$newdate'
						    WHERE id_action     = '$id_action'    "); 						   
   			  return ("OK");
}
?>

<?php  function ACTION_LIST_RETURN_DETAILS($id_recommandation) 
{		  
		      $reponse4     = mysql_fetch_array(mysql_query("SELECT description FROM action_list where id_recommandation = ".$id_recommandation." order by id_action desc limit 0,1 ")) ;
		      if (!$reponse4['description'])
			     {  $description  = "Pas de sauvegarde de l'historique dans cette cellule afin d'optimiser les ressources."; }
			  else	 
			     {  $description  = $reponse4['description']; }						   
   			  return ( addslashes($description) );
}
?>



<?php  function UPDATE_AFFILIATE_ACTIVATED($id_affiliate, $id_statut) 
{

		      mysql_query(" UPDATE affiliate 
						    SET last_connection_date = CURRENT_TIMESTAMP,
							is_activated             = '$id_statut'
						    WHERE id_affiliate       = '$id_affiliate'    "); 						   
   			  return ("OK");
}
?>

<?php  function UPDATE_PARTNER_ACTIVATED($id_partner, $is_activated) 
{
	          //date_default_timezone_set('Europe/Paris');			  
		      mysql_query(" UPDATE partner_list 
						    SET last_connection_date = CURRENT_TIMESTAMP,
							is_activated         = '$is_activated',
							is_access_intranet   = '$is_activated'
						    WHERE id_partner     = '$id_partner'    "); 						   
   			  return ("OK");
}
?>

<?php  function UPDATE_PARTNER_IS_QUALIF_RGE($id_partner, $is_qualif_rge) 
{
	          //date_default_timezone_set('Europe/Paris');			  
		      mysql_query(" UPDATE partner_list 
						    SET is_qualif_rge         = '$is_qualif_rge'
						    WHERE id_partner     = '$id_partner'    "); 						   
   			  return ("OK");
}
?>

<?php  function UPDATE_PARTNER_LIST_ACTIVATED_ACCESS($connection_database2, $id_partner, $is_activated, $is_access_intranet) 
{		  
		      mysql_query(" UPDATE partner_list 
						    SET last_connection_date = CURRENT_TIMESTAMP,
							is_activated         = '$is_activated',
							is_access_intranet   = '$is_access_intranet'
						    WHERE id_partner     = '$id_partner'    "); 						   
   			  return ("OK");
}
?>


<?php  function UPDATE_PARTNER_SERVICE($id_partner, $id_services) 
{
		      $reponse4             = mysql_fetch_array(mysql_query("SELECT type, s_category, s_sub_category FROM services WHERE id_services = ".$id_services."    ")) or die("Requete pas comprise - #3AQA33rtwi! ");
		      $s_category           = $reponse4['s_category'];
		      $s_sub_category       = $reponse4['s_sub_category'];
			  
	          //date_default_timezone_set('Europe/Paris');			  
		      mysql_query(" UPDATE partner_list 
						    SET p_category       = \"$s_category\",
							p_sub_category       = \"$s_sub_category\",
							id_services          = '$id_services'
						    WHERE id_partner     = '$id_partner'    "); 						   

             $sql = "DELETE FROM partner_list_services  
			         WHERE id_partner    = '$id_partner'				 "; 
  	         mysql_query($sql); 
			 
		     INSERT_INTO_PARTNER_LIST_SERVICES($id_partner, $id_services);			 
			
}
?>


<?php  function update_apporteur_activated($id_affiliate, $id_statut) 
{
		      mysql_query(" UPDATE affiliate_details 
						    SET contract_signed  = '$id_statut'
						    WHERE id_affiliate   = '$id_affiliate'    "); 						   
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function retour_etapes_recom($id_action) 
{    
              include('config.php'); 
			  if (isset($id_action) and $id_action <>0)
                  {
				   $sql = "SELECT action_id_category FROM action_list where id_action=\"$id_action\"      ";
                   $result = mysql_query($sql) or die("Site actuellement en Maintenance #AAS1");
				   $reponse = mysql_fetch_array($result);
                   $action_id_category = $reponse["action_id_category"];				   
				  }	
			   
			       if ($id_action == 0)  {$action_id_category = 0;} 
			       if ($id_action == 1)  {$action_id_category = 12;} 
			       if ($id_action == 2)  {$action_id_category = 12;} 
			       if ($id_action == 3)  {$action_id_category = 13;} 
			       if ($id_action == 4)  {$action_id_category = 14;} 
			       if ($id_action == 5)  {$action_id_category = 15;} 
			       if ($id_action == 6)  {$action_id_category = 16;} 
				   if ($id_action == 7)  {$action_id_category = 20;}
			       if ($id_action == 8)  {$action_id_category = 17;} 
			       if ($id_action == 9)  {$action_id_category = 18;} 
			       if ($id_action == 10) {$action_id_category = 19;} 				 

                   if ($action_id_category == 11) { $lien_fichier = "fichiers/Etapes_prescription_long_etape2.PNG";  }
              else if ($action_id_category == 12) { $lien_fichier = "fichiers/Etapes_prescription_long_etape2.PNG";  }
              else if ($action_id_category == 13) { $lien_fichier = "fichiers/Etapes_prescription_long_etape3.PNG";  }
              else if ($action_id_category == 14) { $lien_fichier = "fichiers/Etapes_prescription_long_etape4.PNG";  }
              else if ($action_id_category == 15) { $lien_fichier = "fichiers/Etapes_prescription_long_etape5.PNG";  }
              else if ($action_id_category == 16) { $lien_fichier = "fichiers/Etapes_prescription_long_etape6.PNG";  } 
              else if ($action_id_category == 20) { $lien_fichier = "fichiers/Etapes_prescription_long_etape7.PNG";  }
              else if ($action_id_category == 17) { $lien_fichier = "fichiers/Etapes_prescription_long_etape8.PNG";  }
              else if ($action_id_category == 18) { $lien_fichier = "fichiers/Etapes_prescription_long_etape9.PNG";  }
              else if ($action_id_category == 19) { $lien_fichier = "fichiers/Etapes_prescription_long_etape10.PNG"; }			  
              else 			                      { $lien_fichier = "fichiers/Etapes_prescription_long_etape0.PNG";  }
             //echo $lien_fichier;  			 
			 return ($lien_fichier);
}
?>



<?php  function UPDATE_ACTION_LIST_STATUT($id_action, $action_statut, $action_details, $description_2) 
{ 
	          //date_default_timezone_set('Europe/Paris');
			  $action_status_int = RETURN_ACTION_STATUS_INT($action_statut);
			  mysql_query('SET NAMES utf8');			  

		      mysql_query(" UPDATE action_list 
						    SET managed_date     = CURRENT_TIMESTAMP,
							action_details       =  \"$action_details\",
							description_2        =  \"$description_2\", 
							action_statut        = '$action_statut',
                            action_status_int    = '$action_status_int'								
						    WHERE id_action      = '$id_action'    "); 						   
   			  
			  return ("OK");
}
?>

<?php  function UPDATE_ACTION_LIST_CLOSE_COMPTABLE($id_affiliate, $action_id_category, $action_statut) 
{ 
	          //date_default_timezone_set('Europe/Paris');
			  $action_status_int = RETURN_ACTION_STATUS_INT($action_statut);
			  mysql_query('SET NAMES utf8');			  

		      mysql_query(" UPDATE action_list 
						    SET	action_statut        = '$action_statut',
                            action_status_int        = '$action_status_int'								
						    WHERE id_affiliate       = '$id_affiliate'
                            AND action_status_int    = 1	
                            AND action_id_category   = '$action_id_category'							"); 						   
   			  
			  return ("OK");
}
?>


<?php  function UPDATE_ACTION_LIST_STATUT_RECO_CATEGORY($id_recommandation, $action_id_category, $action_statut, $action_details, $description_2) 
{ 
	          //date_default_timezone_set('Europe/Paris');
			  $action_status_int = RETURN_ACTION_STATUS_INT($action_statut);
			  mysql_query('SET NAMES utf8');			  

		      mysql_query(" UPDATE action_list 
						    SET managed_date         = CURRENT_TIMESTAMP,
							action_details           =  \"$action_details\",
							description_2            =  \"$description_2\", 
							action_statut            = '$action_statut',
                            action_status_int        = '$action_status_int'								
						    WHERE id_recommandation  = '$id_recommandation'
                            AND action_status_int    = 1	
                            AND action_id_category   = '$action_id_category'							"); 						   
   			  
			  return ("OK");
}
?>



<?php  function UPDATE_RECOMMANDATION_DETAILS_COMPLEMENT($id_recommandation, $complement) 
{
		 $complement = stripslashes($complement);
	     $complement = date("Y-m-d H:i:s")." - ".addslashes($complement);	
	 
			  mysql_query('SET NAMES utf8');			  
		      mysql_query(" UPDATE recommandation_details 
						    SET r_complement         =  \"$complement\"						
						    WHERE id_recommandation  = '$id_recommandation'    "); 						   
   			  
			  return ("OK");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function UPDATE_ACTION_LIST_QUE_STATUT($connection_database, $id_action, $action_statut) 
{
	
	          //date_default_timezone_set('Europe/Paris');
			  $action_status_int = RETURN_ACTION_STATUS_INT($action_statut);			   
	
		      mysql_query(" UPDATE action_list 
						    SET managed_date = CURRENT_TIMESTAMP,
							action_statut        = '$action_statut',
                            action_status_int    = '$action_status_int'							
						    WHERE id_action      = '$id_action'    "); 						   
   			  
			  return ("OK");
}
?>



<?php  function REOPEN_RECOMMANDATION_CLOSE($connection_database2, $id_recommandation, $prochaine_echeance) 
{            // REOUVERTURE DE LA RECOMMANDATION ALORS QUE FERME
	         
			 $r_status              = 0;
			 $mise_a_jour_realise   = 0;
			 $action_statut         = "OUVERT";
			 $action_status_int     = RETURN_ACTION_STATUS_INT($action_statut);			   
	         $action_max_date       =  date('Y-m-d H:i:s',time()+$prochaine_echeance*24*3600); 
             $action_creation_date	=  date('Y-m-d H:i:s',time()+0*24*3600); 		 
			 
			 
			 
			 // 1 IL FAUT TROUVER LA DERNIERE ACTION OUVERTE POUR CETTE RECOMMANDATION
		     $reponse4   = mysql_fetch_array(mysql_query(" SELECT count(action_details) as nb_count, max(id_action) as id_action, max(action_id_category) as  action_id_category
		                                                    FROM action_list 
		  	  												where id_recommandation    = ".$id_recommandation." 
		  	  												AND   action_status_int    = 0
                                                            AND   action_id_category   <> 50
                                                            AND   action_id_category   <> 23 ")) or die("Requete pas comprise du statut action_list - #31J3-453   ");
		     $id_action            = $reponse4['id_action'];
             $action_id_category   = $reponse4['action_id_category'];
			 
			 IF ( $action_id_category == 11 ) { $r_status = 2;}	 
			 IF ( $action_id_category == 12 ) { $r_status = 2;}	
			 IF ( $action_id_category == 13 ) { $r_status = 3;}	
			 IF ( $action_id_category == 14 ) { $r_status = 4;}	
			 IF ( $action_id_category == 15 ) { $r_status = 5;}	
			 IF ( $action_id_category == 16 ) { $r_status = 6;}	
			 IF ( $action_id_category == 20 ) { $r_status = 7;}	
			 IF ( $action_id_category == 21 ) { $r_status = 7;}	
			 IF ( $action_id_category == 21 ) { $r_status = 7;}	


			 
			  
			 //2. ON RÉOUVRE LA RECOMMANDATION QUI ETAIT FERME
			  IF ( $id_action > 0 AND $r_status > 0)
			  {
                      mysql_query(" UPDATE action_list 
			                    		      SET action_creation_date  = '$action_creation_date',
											  action_max_date      = '$action_max_date',
			                    			  managed_date         = CURRENT_TIMESTAMP,
			                    			  action_statut        = '$action_statut',
                                              action_status_int    = '$action_status_int'							
			                    		      WHERE id_action      = '$id_action'    "); 
											  
					 update_status_recommandation_details($connection_database2, $id_recommandation, $r_status);
                     $mise_a_jour_realise = 1;					 
   			  }
			  return ($mise_a_jour_realise);
}
?>

<?php  function REOPEN_RECOMMANDATION_EN_ETAPE_6($connection_database2, $id_recommandation, $prochaine_echeance, $id_action_a_fermer) 
{            // REOUVERTURE DE LA RECOMMANDATION EN ETAPE 6
	         
			 $r_status              = 0;
			 $mise_a_jour_realise   = 0;
			 $action_statut         = "OUVERT";
			 $action_status_int     = RETURN_ACTION_STATUS_INT($action_statut);			   
	         $action_max_date       =  date('Y-m-d H:i:s',time()+$prochaine_echeance*24*3600); 
             $action_creation_date	=  date('Y-m-d H:i:s',time()+0*24*3600); 		 
			 
			 
			 
			 // 1 IL FAUT TROUVER LA DERNIERE ACTION OUVERTE POUR CETTE RECOMMANDATION
		     $reponse4   = mysql_fetch_array(mysql_query("  SELECT count(action_details) as nb_count, max(id_action) as id_action, max(action_id_category) as  action_id_category
		                                                    FROM  action_list 
		  	  												where id_recommandation    = ".$id_recommandation." 
		  	  												AND   action_status_int    = 0
                                                            AND   action_id_category   = 16  limit 0,1 ")) or die("Requete pas comprise du statut action_list - #31J3-453   ");
		     $id_action            = $reponse4['id_action'];
             $action_id_category   = $reponse4['action_id_category'];
             $r_status = 6;	



			 
			  
			 //2. ON RÉOUVRE LA RECOMMANDATION QUI ETAIT FERME
			  IF ( $id_action > 0 AND $r_status > 0)
			  {
				      // 1. ON FERME L'ACTION EN ETAPE 7 /////////////////////////////////////////////////////////////////////////////////////////////////////////////
                      mysql_query(" UPDATE action_list 
			                    		      SET action_creation_date  = '$action_creation_date',
											  action_max_date           = '$action_max_date',
			                    			  managed_date              = CURRENT_TIMESTAMP,
			                    			  action_statut             = 'FERME',
                                              action_status_int         =  0							
			                    		      WHERE id_action           = '$id_action_a_fermer'    "); 
					
                      // 2. ON OUVRE L'ACTION EN ETAPE 6 /////////////////////////////////////////////////////////////////////////////////////////////////////////////				
                      mysql_query(" UPDATE action_list 
			                    		      SET action_creation_date  = '$action_creation_date',
											  action_max_date           = '$action_max_date',
			                    			  managed_date              = CURRENT_TIMESTAMP,
			                    			  action_statut             = '$action_statut',
                                              action_status_int         = '$action_status_int'							
			                    		      WHERE id_action           = '$id_action'    "); 
											  
					 update_status_recommandation_details($connection_database2, $id_recommandation, $r_status);
                     $mise_a_jour_realise = 1;					 
   			  }
			  return ($mise_a_jour_realise);
}
?>






<?php  function UPDATE_ACTION_LIST_QUE_ACTION_ID_CATEGORY($id_action, $action_id_category, $action_category) 
{
		      mysql_query(" UPDATE action_list 
						    SET managed_date      = CURRENT_TIMESTAMP,
							action_id_category    = '$action_id_category',
                            action_category       = '$action_category'							
						    WHERE id_action       = '$id_action'    "); 						   
   			  
			  return ("OK");
}
?>

<?php  function UPDATE_PRENOM_AFFILIATE($id_affiliate, $first_name, $id_partner) 
{
		 $first_name = stripslashes($first_name);
	     $first_name = addslashes($first_name);
         mysql_query('SET NAMES utf8');		 
	 
		      mysql_query(" UPDATE affiliate_details 
						    SET   first_name        = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 						   

		      mysql_query(" UPDATE affiliate 
						    SET   first_name        = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 
							
		      mysql_query(" UPDATE partner_list 
						    SET   p_first_name      = '$first_name'							
						    WHERE id_partner        = '$id_partner'    "); 							
		
		return (1);
}
?>

<?php  function UPDATE_NAME_AFFILIATE($id_affiliate, $first_name, $id_partner) 
{
		 $first_name = stripslashes($first_name);
	     $first_name = addslashes($first_name);
         mysql_query('SET NAMES utf8');		 
	 
		      mysql_query(" UPDATE affiliate_details 
						    SET   last_name         = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 						   

		      mysql_query(" UPDATE affiliate 
						    SET   last_name        = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 
							
		      mysql_query(" UPDATE partner_list 
						    SET   p_last_name      = '$first_name'							
						    WHERE id_partner        = '$id_partner'    "); 							
		
		return (1);
}
?>

<?php  function UPDATE_PHONE_AFFILIATE($id_affiliate, $first_name, $id_partner) 
{
		 $first_name = stripslashes($first_name);
	     $first_name = addslashes($first_name);
         mysql_query('SET NAMES utf8');		 
	 
		      mysql_query(" UPDATE affiliate_details 
						    SET   phone_number      = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 						   
							
		      mysql_query(" UPDATE partner_list 
						    SET   p_contact_phone      = '$first_name'							
						    WHERE id_partner           = '$id_partner'    "); 							
		
		return (1);
}
?>


<?php  function UPDATE_CONTACT_ASSOCIATION($id_affiliate, $first_name) 
{
		 $first_name = stripslashes($first_name);
	     $first_name = addslashes($first_name);
         mysql_query('SET NAMES utf8');		 
	 
		      mysql_query(" UPDATE affiliate_details 
						    SET   contact_association        = '$first_name'							
						    WHERE id_affiliate      = '$id_affiliate'    "); 						   														
		
		return (1);
}
?>

<?php  function UPDATE_ACTION_LIST_STATUT_RECOMMANDATION($id_recommandation, $action_statut, $action_details, $description_2) 
{
	          //date_default_timezone_set('Europe/Paris');
			  $description_2 = addslashes($description_2);
			  $action_status_int = RETURN_ACTION_STATUS_INT($action_statut);
			  
			  mysql_query('SET NAMES utf8');			  
		      mysql_query(" UPDATE action_list 
						    SET managed_date         = CURRENT_TIMESTAMP,
							action_details           =  \"$action_details\",
							description_2            =  \"$description_2\", 
							action_statut            = '$action_statut',
                            action_status_int        = '$action_status_int'							
						    WHERE id_recommandation  = '$id_recommandation'   
                            and action_statut        = \"OUVERT\"    				"); 						   
}
?>




<?php  function BANDEAU_ACTIONS($connection_database2, $id_affiliate, $partenaire_a_filtrer, $affiliate_a_filtrer, $action_a_filtrer) 
{
                 $count_action = COUNT_NB_ACTION_A_REALISER($connection_database2, 'OUVERT',0, $id_affiliate);
			     $countpage = 50;
		         echo '<input type="hidden" name="count_action_a_realiser"     value = '.$count_action.' />'; 			
		         echo '<input type="hidden" name="first_page"                  value = 1 />'; 
				 echo '<input type="hidden" name="range_min_query"             value = 0 />';
				 echo '<input type="hidden" name="row_max_page"                value = 6 />';
		         echo '<input type="hidden" name="count_page"                  value = '.$countpage.' />'; 	
				 echo '<input type="hidden" name="id_action"                   value = 0 />';
				 echo '<input type="hidden" name="action_id_category"          value = 0 />';
				 echo '<input type="hidden" name="id_sub_action"               value = 0 />';
				 echo '<input type="hidden" name="id_key"                      value = 0 />'; 
				 echo '<input type="hidden" name="type_action"                 value = '.$action_a_filtrer.' />'; 
				 echo '<input type="hidden" name="partenaire_a_filtrer"        value = '.$partenaire_a_filtrer.' />';  
                 echo '<input type="hidden" name="sauf_category"               value = 0 />'; 	
                 echo '<input type="hidden" name="affiliate_a_filtrer"         value = '.$affiliate_a_filtrer.' />'; 				 
}
?>

<?php  function bandeau_partenaire($id_partenaire, $nb_rows) 
{
                 if ($id_partenaire <> 0)  {$countpartenaires = 1;} 
				 else      			       {$countpartenaires = count_partenaires(0);} 
			     
				 $countpage1 = nb_page_tableau($nb_rows,$countpartenaires);		
		         echo '<input type="hidden" name="count_partenaires"         value = '.$countpartenaires.' />'; 			
		         echo '<input type="hidden" name="first_page"                value = 1 />'; 
				 echo '<input type="hidden" name="range_min_query"           value = 0 />';
				 echo '<input type="hidden" name="row_max_page"              value = '.$nb_rows.' />';
		         echo '<input type="hidden" name="count_page"                value = '.$countpage1.' />'; 
				 echo '<input type="hidden" name="service_immobilier"        value = 0 />';
				 echo '<input type="hidden" name="id_partenaire"             value = 0 />';			 
}
?>

<?php  function NosRezo12345678911_actions_B1($connection_database2, $lien_action, $id_recommandation, $id_action, $type_action, $id_privileged_partner, $prochaine_etape, $action_id_category, $description_2, $action_category, $description_action_list, $partenaire_a_filtrer, $affiliate_a_filtrer ) 
{
         echo '<form id="Action_'.$lien_action.'" action="NosRezo12345678911_2.php" method="post">';
		 echo '<input type="hidden" name="id_recommandation"                      value = "'.$id_recommandation.'" />'; 
		 echo '<input type="hidden" name="id_action"                              value = "'.$id_action.'" />';
		 echo '<input type="hidden" name="action_filtre_back"                     value = "'.$type_action.'" />';
		 echo '<input type="hidden" name="id_privileged_partner"                  value = "'.$id_privileged_partner.'" />';
		 echo '<input type="hidden" name="prochaine_etape"                        value = "'.$prochaine_etape.'" />';
		 echo '<input type="hidden" name="action_id_category"                     value = "'.$action_id_category.'" />';
		 echo '<input type="hidden" name="description_2"                          value = "'.$description_2.'" />';   // COMMENTAIRE MIS PAR L'ADMINISTRATEUR
		 echo '<input type="hidden" name="action_category"                        value = "'.$action_category.'" />'; // TITRE DU BOUTTON QUI RESTE LE MEME SI PAS DE NOUVEAU SUR LE DOSSIER	
		 echo '<input type="hidden" name="afficher_commentaire_part"              value = "NOSREZO" />';	
         echo '<input type="hidden" name="description_action_list"                value = "'.$description_action_list.'" />';
		 echo '<input type="hidden" name="partenaire_a_filtrer"                   value = "'.$partenaire_a_filtrer.'" />';					 
		 echo '<input type="hidden" name="affiliate_a_filtrer"                    value = "'.$affiliate_a_filtrer.'" />';

}
?>

<?php  function NosRezo12345678911_actions_B2($connection_database2, $lien_action, $nb_action, $premiere_page, $range_min_page, $row_maxx_page, $compte_page, $id_action, $action_id_category, $id_sub_action, $id_key, $type_action, $partenaire_a_filtrer, $description_2) 
{
		 echo '<form id="Action_affilie_'.$lien_action.'"         action="NosRezo12345678911.php" method="post">'; 
		 echo '<input type="hidden" name="count_action_a_realiser"     value = "'.$nb_action.'"  /> ';			
		 echo '<input type="hidden" name="first_page"                  value = "'.$premiere_page.'" /> ';
		 echo '<input type="hidden" name="range_min_query"             value = "'.$range_min_page.'" /> ';
		 echo '<input type="hidden" name="row_max_page"                value = "'.$row_maxx_page.'" /> ';
		 echo '<input type="hidden" name="count_page"                  value = "'.$compte_page.'"  /> ';
		 echo '<input type="hidden" name="id_action"                   value = "'.$id_action.'"  />';
		 echo '<input type="hidden" name="action_id_category"          value = "'.$action_id_category.'" />';
		 echo '<input type="hidden" name="id_sub_action"               value = "'.$id_sub_action.'" />';
		 echo '<input type="hidden" name="id_key"                      value = "'.$id_key.'" />'; 
		 echo '<input type="hidden" name="type_action"                 value = "'.$type_action.'" />';
		 echo '<input type="hidden" name="partenaire_a_filtrer"        value = "'.$partenaire_a_filtrer.'" />';					 
		 echo '<input type="hidden" name="client_interresse"           value = "OK" />';	
		 echo '<input type="hidden" name="afficher_commentaire_part"   value = "NOSREZO" />';
		 echo '<input type="hidden" name="sauf_category"               value = 0 />';
		 echo '<input type="hidden" name="affiliate_a_filtrer"         value = 0 />';
		 echo '<input type="hidden" name="description_2"               value = "'.$description_2.'" />';
}
?>



<?php  function UPDATE_EMAIL_PARTNER_LIST($connection_database2, $id_partner, $p_contact_mail) 
{
    IF ($id_partner > 0) 
	     {
				$sql = "UPDATE partner_list 
				        SET  p_contact_mail =   \"$p_contact_mail\"									 
						WHERE id_partner    =   '$id_partner' "; 
				mysql_query($sql) or die("Requete UPDATE_EMAIL_PARTNER_LIST pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_PARTENAIRE_LIST_DESACTIVATION($connection_database2, $id_partner, $is_activated) 
{
	IF ($is_activated == 1) {$is_access_intranet = 1; } else { $is_access_intranet = 0;}
    IF ($id_partner > 0) 
	     {
				$sql = "UPDATE partner_list 
				        SET  is_activated   =   '$is_activated',
                        is_access_intranet  =   '$is_access_intranet' 						
						WHERE id_partner    =   '$id_partner' "; 
				mysql_query($sql) or die("Requete update_partenaire_list_desactivation pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_partenaire_list_access_intranet($id_partner, $is_activated) 
{
    IF ($id_partner > 0) 
	     {
				$sql = "UPDATE partner_list 
				        SET  is_access_intranet   =   '$is_activated' 									 
						WHERE id_partner          =   '$id_partner' "; 
				mysql_query($sql) or die("Requete update_partenaire_list_desactivation pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_PACK_AFFILIATE($id_affiliate, $numero_pack) 
{
    IF ($id_affiliate > 0) 
	     {
				$sql = "UPDATE affiliate_details 
				        SET  numero_de_pack     =   '$numero_pack'									 
						WHERE id_affiliate      =   '$id_affiliate'          "; 
				mysql_query($sql) or die("Requete UPDATE_PACK_AFFILIATE pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_partenaire_telephone2($id_partner, $p_contact_phone2) 
{
    IF ($id_partner > 0) 
	     {
				$sql = "UPDATE partner_list 
				        SET  p_contact_phone2     =   \"$p_contact_phone2\"									 
						WHERE id_partner          =   '$id_partner'          "; 
				mysql_query($sql) or die("Requete update_partenaire_telephone2 pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_note_interne_partenaire_nr($id_partner, $p_note_partenaire) 
{
    IF ($id_partner > 0) 
	     {
				$sql = "UPDATE partner_list 
				        SET  p_note_partenaire     =   '$p_note_partenaire'									 
						WHERE id_partner          =   '$id_partner'          "; 
				mysql_query($sql) or die("Requete update_partenaire_telephone2 pas comprise #AA23");
        }				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function UPDATE_EMAIL_AFFILIATE_DETAILS($id_affiliate, $email) 
{
    IF ($id_affiliate > 10) 
	     {
				$sql = "UPDATE affiliate_details 
				        SET  email            =   \"$email\"									 
						WHERE id_affiliate    =   '$id_affiliate' "; 
				mysql_query($sql) or die("Requete UPDATE_EMAIL_AFFILIATE_DETAILS pas comprise #AA23");	
		 }
				return ("OK");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_partner_notation($id_partner, $nb_reco, $percent_satisfaction, $id_image, $points_nosrezo)
{
              include('config.php'); 
	          //date_default_timezone_set('Europe/Paris');	  

		      mysql_query(" UPDATE partner_notation 
						    SET update_time = CURRENT_TIMESTAMP,
							nb_interventions     = '$nb_reco',
							percent_satisfaction = '$percent_satisfaction',
							id_image             = '$id_image',
							points_nosrezo       = '$points_nosrezo'
						    WHERE id_partner_notation = '$id_partner'    "); 						   
   			  return ("OK");
}
?>

<?php function update_notation_partner($id_recommandation)
{           
                include('config.php'); 
				//date_default_timezone_set('Europe/Paris');
                // 1. QUEL PARTENAIRE DOIT ETRE MIS A JOUR               
		        $reponse4       = mysql_fetch_array(mysql_query(" SELECT id_privileged_partner FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1  ")) or die("Requete pas comprise - #R3AA23RFT: TEST !");
		        $id_partner     = $reponse4['id_privileged_partner'];

				// 2. CALCUL DE L'ENSEMBLE DE SES NOTES POUR MOYENNE			   
                $result_partner  = mysql_query("SELECT count(id_recommandation) as reco, sum(sum_notation) as note FROM partner_notation_details where id_partner= ".$id_partner." and is_activated = 1 ") or die("Requete update_partner_notation : 4 pas comprise. ");
				$reponse_partner = mysql_fetch_array($result_partner);
				
			    // 3. Règles de calcul à appliquer pour la satisfaction : Min = 1; Max = 6
						  // On somme les critères : min = 3, max = 18 par ligne
                          IF ($reponse_partner["reco"] == 0)
						     {$percent_satisfaction = 100;
							 } 
						  ELSE 
							 {$percent_satisfaction = ($reponse_partner["note"] / $reponse_partner["reco"]) / 18 * 100;}
						   
						  IF      ($percent_satisfaction < 20) { $points_nosrezo = 0;     $id_image = 0;} 
						  ELSE IF ($percent_satisfaction < 50) { $points_nosrezo = 0;     $id_image = 1;} 
						  ELSE IF ($percent_satisfaction < 60) { $points_nosrezo = 0;     $id_image = 2;} 
						  ELSE IF ($percent_satisfaction < 70) { $points_nosrezo = 25;    $id_image = 3;} 
						  ELSE IF ($percent_satisfaction < 85) { $points_nosrezo = 28;    $id_image = 4;} 
						                                       { $points_nosrezo = 30;    $id_image = 5;} 
				
  				           /////// UPDATE DES NOTES DANS LA TABLE DES NOTATIONS DES PARTENAIRES
						   update_partner_notation($id_partner, $reponse_partner["reco"], $percent_satisfaction, $id_image, $points_nosrezo);
						   
                return ("OK");			
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function CALCUL_PRODUCTION_JOUR($connection_database2, $date_reporting)
{   // FORMAT DE $date = date("Y-m-d H:i:s) 2015-05-28    
      
						 //date_default_timezone_set('Europe/Paris');
						  List ($jour, $mois, $annee, $jour_de_la_semaine, $timestamp, $heure, $minute, $seconde ) = RETURN_INFO_SUR_LA_DATE($date_reporting);		 
						  
                          // CALCUL NB AFFILIATE DU JOUR ///////////////////////////////////////////////////////////////////////////////////////////////
						  $result_affiliate  = mysql_query(" SELECT count( id_affiliate ) as nb_affiliate 
						                                     FROM affiliate_details 
															 where substring(creation_date,1,4) = ".$annee." 
															 AND   substring(creation_date,6,2) = ".$mois."
                                                             AND   substring(creation_date,9,2) = ".$jour."															 
															 ") or die("Requete update_reporting_niveau_1 : 3AZS pas comprise. ");
						  $reponse_affiliate     = mysql_fetch_array($result_affiliate);
                          $nb_affiliate_total	 = $reponse_affiliate['nb_affiliate'];					  


						  // CALCUL NB AFFILIATE DONT PARRAIN EST CHEZ IAD ///////////////////////////////////////////////////////////////////////////////////////////////
                          $result_aff_is_iad  = mysql_query('SELECT count( ad.id_affiliate ) as nb_affiliate_is_iad 
						                                     FROM affiliate_details ad, affiliate aa
															 where substring(creation_date,1,4) = '.$annee.' 
															 AND   substring(creation_date,6,2) = '.$mois.'
                                                             AND   substring(creation_date,9,2) = '.$jour.'
															 AND   ad.id_affiliate = aa.id_affiliate
															 AND   aa.id_upline in 
															 ( SELECT  aa.id_affiliate
															 FROM affiliate aa, partner_list pl, affiliate_details ad
															 WHERE aa.id_affiliate = ad.id_affiliate
															 AND aa.id_partenaire  = pl.id_partner 
															 AND pl.id_services  = 1 
															 AND pl.is_activated = 1 
															 AND aa.is_activated = 1 
															 AND pl.p_contact_mail like "%@iadfrance%" )     ') or die("Requete update_reporting_niveau_1 : 3GVA pas comprise. ");
						  $reponse_a_is_iad             = mysql_fetch_array($result_aff_is_iad);	
						  $nb_affiliate_parrain_is_iad	= $reponse_a_is_iad['nb_affiliate_is_iad'];
						 
						  // CALCUL NB AFFILIATE DONT PARRAIN EST CHEZ IAD PORTUGAL ///////////////////////////////////////////////////////////////////////////////////////////////
                          $result_aff_is_iad_p  = mysql_query('SELECT count( ad.id_affiliate ) as nb_affiliate_is_iad_p
						                                     FROM affiliate_details ad, affiliate aa
															 where substring(creation_date,1,4) = '.$annee.' 
															 AND   substring(creation_date,6,2) = '.$mois.'
                                                             AND   substring(creation_date,9,2) = '.$jour.'
															 AND   ad.id_affiliate = aa.id_affiliate
															 AND   aa.id_upline in 
															 ( SELECT  aa.id_affiliate
															 FROM affiliate aa, partner_list pl, affiliate_details ad
															 WHERE aa.id_affiliate = ad.id_affiliate
															 AND aa.id_partenaire  = pl.id_partner 
															 AND pl.id_services  = 1 
															 AND pl.is_activated = 1 
															 AND aa.is_activated = 1 
															 AND pl.p_contact_mail like "%@iadportug%" )     ') or die("Requete update_reporting_niveau_1 : 3GVA pas comprise. ");
						  $reponse_a_is_iad_p            = mysql_fetch_array($result_aff_is_iad_p);	
						  $nb_affiliate_parrain_is_iad_portugal	= $reponse_a_is_iad_p['nb_affiliate_is_iad_p'];
						 
						  // CALCUL NB RECOMMANDATION DU JOUR  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_recommandations  = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE substring(r_creation_date,1,4) =  ".$annee." 
																   AND   substring(r_creation_date,6,2) = ".$mois."
																   AND   substring(r_creation_date,9,2) = ".$jour."
																   AND   duplicate_id_recommandation = 0     ") or die("Requete update_reporting_niveau_1 : 4TASA pas comprise. ");
						  $reponse_recommandations  = mysql_fetch_array($result_recommandations);
                          $nb_recommandation_totale = $reponse_recommandations['nb_recommandations'];						  
						  
						  // CALCUL NB RECOMMANDATION DU JOUR ONLY IMMO ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_reco_immo     = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE substring(r_creation_date,1,4) =  ".$annee." 
																   AND   substring(r_creation_date,6,2) = ".$mois."
																   AND   substring(r_creation_date,9,2) = ".$jour."
																   AND   duplicate_id_recommandation = 0 
                                                                   AND   r_sub_category_code = 1	 ") or die("Requete update_reporting_niveau_1 : 4TASA pas comprise. ");
						  $reponse_reco_immo      = mysql_fetch_array($result_reco_immo);
                          $nb_recommandation_immo = $reponse_reco_immo['nb_recommandations'];

						  // CALCUL NB RECOMMANDATION DU JOUR ONLY COMPTA ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_reco_compta     = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE substring(r_creation_date,1,4) =  ".$annee." 
																   AND   substring(r_creation_date,6,2) = ".$mois."
																   AND   substring(r_creation_date,9,2) = ".$jour."
																   AND   duplicate_id_recommandation = 0 
                                                                   AND   r_sub_category_code in (51, 52, 53, 54)	 ") or die("Requete update_reporting_niveau_1 : 4TASA pas comprise. ");
						  $reponse_reco_compta      = mysql_fetch_array($result_reco_compta);
                          $nb_recommandation_compta   = $reponse_reco_compta['nb_recommandations'];

						  // CALCUL NB RECOMMANDATION DU JOUR ONLY DEFISC ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_reco_compta     = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE substring(r_creation_date,1,4) =  ".$annee." 
																   AND   substring(r_creation_date,6,2) = ".$mois."
																   AND   substring(r_creation_date,9,2) = ".$jour."
																   AND   duplicate_id_recommandation = 0 
                                                                   AND   r_sub_category_code in (55)	 ") or die("Requete update_reporting_niveau_1 : 1TASA pas comprise. ");
						  $reponse_reco_defisc        = mysql_fetch_array($result_reco_compta);
                          $nb_recommandation_defisc   = $reponse_reco_defisc['nb_recommandations'];						  
						  
						  // CALCUL NB RECOMMANDATION DU JOUR ONLY RECRUTEMENT ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_reco_recrutement     = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE substring(r_creation_date,1,4) =  ".$annee." 
																   AND   substring(r_creation_date,6,2) = ".$mois."
																   AND   substring(r_creation_date,9,2) = ".$jour."
																   AND   duplicate_id_recommandation = 0 
                                                                   AND   r_sub_category_code in (8, 56)	 ") or die("Requete update_reporting_niveau_1 : 2TASA pas comprise. ");
						  $reponse_reco_recrutement   = mysql_fetch_array($result_reco_recrutement);
                          $nb_recommandation_recrute   = $reponse_reco_recrutement['nb_recommandations'];

						  // CALCUL NB RECOMMANDATION DU JOUR ONLY DEFISC ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_reco_compta     = mysql_query(" SELECT count( id_recommandation ) as nb_recommandations 
						                                           FROM recommandation_details 
																   WHERE   duplicate_id_recommandation = 0 
                                                                   AND   r_sub_category_code in (55)	 ") or die("Requete update_reporting_niveau_1 : 5TASA pas comprise. ");
						  $reponse_reco_defisc_full        = mysql_fetch_array($result_reco_compta);
                          $nb_recommandation_defisc_full   = $reponse_reco_defisc_full['nb_recommandations'];							  
						  
						  
                return array($nb_affiliate_total, $nb_affiliate_parrain_is_iad, $nb_affiliate_parrain_is_iad_portugal, $nb_recommandation_totale, $nb_recommandation_immo, $nb_recommandation_compta, $nb_recommandation_defisc, $nb_recommandation_recrute, $nb_recommandation_defisc_full );			
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php function UPDATE_REPORTING_NIVEAU_1($connection_database2, $id_action)
{            
				
				/// 1. ON EFFACE TOUT
				mysql_query("DELETE FROM reporting_niveau_1") or die("Requete update_reporting_niveau_1 pas comprise. #ZRTM5 "); 
				$rapport_activite = "&nbsp &nbsp &nbsp &nbsp >> Table reporting_niveau_1 effacee  <br/>";
				
	            /// 2. REMPLISSAGE             
                 $result = mysql_query("SELECT DISTINCT substring(creation_date,1,4) as year, substring(creation_date,6,2) as month 
				                        FROM affiliate_details ") or die("Requete update_reporting_niveau_1 : 2E pas comprise. ");				
   			     WHILE ($reponse = mysql_fetch_array($result))
                        {  
                          $result_affiliate  = mysql_query("SELECT count( id_affiliate ) as nb_affiliate 
						                                    FROM   affiliate_details 
															WHERE  substring(creation_date,1,4) = ".$reponse["year"]." 
															AND    substring(creation_date,6,2) = ".$reponse["month"]."   ") or die("Requete update_reporting_niveau_1 : 3A pas comprise. ");
						  $reponse_affiliate = mysql_fetch_array($result_affiliate);						

						 IF ( $reponse["year"] > 2014)
						 {
						    // // CALCUL NB AFFILIATE QUI SONT CHEZ IAD /////////////////////////////////////////////////////////////////
                            // $result_aff_is_iad  = mysql_query(' SELECT count( aa.id_affiliate ) as nb_affiliate_is_iad
						  	// 								 FROM affiliate aa, partner_list pl, affiliate_details ad
						  	// 								 WHERE aa.id_affiliate = ad.id_affiliate
						  	// 								 AND aa.id_partenaire  = pl.id_partner 
						  	// 								 AND pl.id_services  = 1 
						  	// 								 AND pl.is_activated = 1 
						  	// 								 AND aa.is_activated = 1 
						  	// 								 AND pl.p_contact_mail like "%@iad%" 
                            //                                    AND substring(creation_date,1,4) = '.$reponse["year"].' 
                            //                                    AND substring(creation_date,6,2) = '.$reponse["month"].'      ') or die("Requete update_reporting_niveau_1 : 3A pas comprise. ");
						    // $reponse_a_is_iad    = mysql_fetch_array($result_aff_is_iad);	
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						    // 
						    // // CALCUL NB PARRAIN AFFILIATE QUI SONT CHEZ IAD /////////////////////////////////////////////////////////////////
                            // $result_parr_is_iad  = mysql_query('SELECT count(*)as PARRAIN_IS_IAD
						  	// 					             FROM affiliate aa, partner_list pl 
						  	// 					     		 WHERE aa.id_partenaire = pl.id_partner 
						  	// 					     		 AND pl.id_services = 1 
						  	// 					     		 AND pl.is_activated = 1 
						  	// 					     		 AND aa.is_activated = 1 
						  	// 					     		 AND pl.p_contact_mail like "%@iad%"
						  	// 					     		 AND aa.id_affiliate in (
						    //                                        SELECT aa.id_upline 
						  	// 								     FROM affiliate aa, affiliate_details ad
						  	// 								     WHERE aa.id_affiliate = ad.id_affiliate
						  	// 								     AND   aa.is_activated = 1 
                            //                                        AND substring(creation_date,1,4) = '.$reponse["year"].' 
                            //                                        AND substring(creation_date,6,2) = '.$reponse["month"].'           )   ') or die("Requete update_reporting_niveau_1 : 3AMWQA pas comprise. ");
						    // $reponse_parr_is_iad    = mysql_fetch_array($result_parr_is_iad);	
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          
						  $reponse_a_is_iad["nb_affiliate_is_iad"] =0;
						  $reponse_parr_is_iad["PARRAIN_IS_IAD"] = 0;                        

						}
						 ELSE 
						 {
						  $reponse_a_is_iad["nb_affiliate_is_iad"] =0;
						  $reponse_parr_is_iad["PARRAIN_IS_IAD"] = 0;
						 }
						  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          $result_recommandations  = mysql_query("SELECT count( id_recommandation ) as nb_recommandations 
						                                          FROM recommandation_details 
																  WHERE substring(r_creation_date,1,4) = ".$reponse["year"]." 
																  AND substring(r_creation_date,6,2)   = ".$reponse["month"]."  
																  AND duplicate_id_recommandation      = 0     ") or die("Requete update_reporting_niveau_1 : 4TA pas comprise. ");
						  $reponse_recommandations = mysql_fetch_array($result_recommandations);						  
						  if   ($reponse_recommandations["nb_recommandations"] == 0) {$percent_aff_actif_brut = 0;}
						  else {$percent_aff_actif_brut =  $reponse_recommandations["nb_recommandations"] / $reponse_affiliate["nb_affiliate"] *100;}	
                          
						  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            // $result_recommandations_distinct  = mysql_query("SELECT count( distinct id_affiliate ) as nb_recommandations 
						    //                                                  FROM recommandation_details 
							//   											   where substring(r_creation_date,1,4) = ".$reponse["year"]." 
							//   											   and substring(r_creation_date,6,2) = ".$reponse["month"]."   
							//   											   and duplicate_id_recommandation = 0     ") or die("Requete update_reporting_niveau_1 : 4TGTYB pas comprise. ");
						    // $reponse_recommandations_distinct = mysql_fetch_array($result_recommandations_distinct);
						    // if   ($reponse_recommandations_distinct["nb_recommandations"] == 0) {$percent_aff_actif_reel = 0;}
						    // else {$percent_aff_actif_reel = $reponse_recommandations_distinct["nb_recommandations"] / $reponse_affiliate["nb_affiliate"] *100;}	
                          $percent_aff_actif_reel = 0;
						  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_partenaire         = mysql_query("SELECT count( id_partner ) as id_partner 
						                                            FROM partner_list 
																	WHERE substring(p_creation_date,1,4) = ".$reponse["year"]." 
																	AND substring(p_creation_date,6,2) = ".$reponse["month"]." 
																	AND is_activated = 1  ") or die("Requete update_reporting_niveau_1 : 1 pas comprise. ");
						  $reponse_partenaire        = mysql_fetch_array($result_partenaire);


                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_annulee       = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	WHERE substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	AND substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status = 0    
																	AND duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 3 pas comprise. ");
						  $reponse_reco_annulee      = mysql_fetch_array($result_reco_annulee);						  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_en_cours      = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	WHERE substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	AND substring(r_creation_date,6,2) = ".$reponse["month"]." 
																	AND r_status < 3 and r_status <> 0  
																	and duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 2 pas comprise. ");
						  $reponse_reco_en_cours     = mysql_fetch_array($result_reco_en_cours);						  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_etape_3       = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	AND substring(r_creation_date,6,2) = ".$reponse["month"]." 
																	AND r_status = 3   
																	and duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 3 pas comprise. ");
						  $reponse_reco_etape_3      = mysql_fetch_array($result_reco_etape_3);
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_rdv_part      = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	and substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status = 4   
																	and duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 4 pas comprise. ");
						  $reponse_reco_rdv_part     = mysql_fetch_array($result_reco_rdv_part);
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_devis_envoye  = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	and substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status = 5   
																	and duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 45 pas comprise. ");
						  $reponse_reco_devis_envoye = mysql_fetch_array($result_reco_devis_envoye);
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_validee       = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	and substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status = 6   
																	and duplicate_id_recommandation = 0  ") or die("Requete update_reporting_niveau_1 : 6 pas comprise. ");
						  $reponse_reco_validee      = mysql_fetch_array($result_reco_validee);
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_signee        = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	and substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status = 7   
																	and duplicate_id_recommandation = 0   ") or die("Requete update_reporting_niveau_1 : 7 pas comprise. ");
						  $reponse_reco_signee       = mysql_fetch_array($result_reco_signee);						  
                          //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						  $result_reco_payee         = mysql_query("SELECT count( id_recommandation ) as id_recommandation 
						                                            FROM recommandation_details 
																	where substring(r_creation_date,1,4) = ".$reponse["year"]." 
																	and substring(r_creation_date,6,2) = ".$reponse["month"]." 
						                                            AND r_status > 7   
																	and duplicate_id_recommandation = 0   ") or die("Requete update_reporting_niveau_1 : 8+ pas comprise. ");
						  $reponse_reco_payee        = mysql_fetch_array($result_reco_payee);
                          
						  
						  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                          
						  
						  // INSERTION DANS LA TABLE DE REPORTING
						  mysql_query('insert into reporting_niveau_1(year, month, date_calcul, nb_affiliate,nb_affiliate_is_iad,  nb_affiliate_parrain_is_iad,  nb_affiliate_actif, nb_recommandations, percent_aff_actif_brut, percent_aff_actif_reel, nb_partenaires, reco_en_cours, reco_annulee, reco_etape_3, reco_rdv_partenaire, reco_devis_envoye, reco_validee, reco_signee, reco_payee) 
                                                               values("'.$reponse["year"].'","'.$reponse["month"].'",CURRENT_TIMESTAMP, "'.$reponse_affiliate["nb_affiliate"].'",  "'.$reponse_a_is_iad["nb_affiliate_is_iad"].'",  "'.$reponse_parr_is_iad["PARRAIN_IS_IAD"].'",  0, "'.$reponse_recommandations["nb_recommandations"].'", "'.$percent_aff_actif_brut.'", "'.$percent_aff_actif_reel.'", "'.$reponse_partenaire["id_partner"].'", "'.$reponse_reco_en_cours["id_recommandation"].'", "'.$reponse_reco_annulee["id_recommandation"].'" , "'.$reponse_reco_etape_3["id_recommandation"].'" , "'.$reponse_reco_rdv_part["id_recommandation"].'" , "'.$reponse_reco_devis_envoye["id_recommandation"].'" , "'.$reponse_reco_validee["id_recommandation"].'","'.$reponse_reco_signee["id_recommandation"].'" ,"'.$reponse_reco_payee["id_recommandation"].'")
						             ') or die("Requete update_reporting_niveau_1 : ZS pas comprise. ");

						  
						}
				$rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp >> Table reporting_niveau_1 chargee  <br/>";

                return ($rapport_activite);			
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function update_reporting_affiliate_1($id_action)
{           
				$rapport_activite = "&nbsp &nbsp &nbsp &nbsp >> ";
				
				// 1. ON ÉFFACE TOUT /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				mysql_query(" DELETE FROM reporting_affiliate_1 ") or die("Requete reporting_affiliés_1 pas comprise. #ZTM5 "); 

	            // 2. REMPLISSAGE DES AFFILIATE L1 ET RECO   /////////////////////////////////////////////////////////////////////////////////////////////////////////        
                 $result      = mysql_query(" SELECT id_affiliate FROM affiliate WHERE is_activated = 1  AND id_affiliate > 12  ") or die("Requete reporting_affiliés_1 : 2E pas comprise. ");				
                 $sql_base    = '  insert into reporting_affiliate_1(id_affiliate, date_calcul, affiliate_L1, affiliate_L2, affiliate_L3, affiliate_L4, affiliate_L5, affiliate_L6, affiliate_total, reco_affiliate_L0) VALUES ';
   			     $sql_requete = "";
				 $compteur = 0;
				 WHILE ($reponse = mysql_fetch_array($result))
                        { 
                         $compteur = $compteur + 1;						
						 /////////   CALCUL DU NOMBRE DE RECOMMANDATIONS TOTALES POUR CHAQUE AFFILIES  
	                    $result_R0     = mysql_fetch_array(mysql_query(" SELECT count(id_recommandation) as nb_reco FROM recommandation_details WHERE id_affiliate=".$reponse["id_affiliate"]."     ")) or die("Requete reporting_affiliés_1 : TFTA pas comprise ");
		                $recomm_R0     = $result_R0['nb_reco'];						 
				 								
						 /////////   CALCUL DU NOMBRE D'AFFILIES LEVEL 1
	                    $result_L1     = mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as nb_aff_L1 FROM affiliate WHERE is_activated=1 AND id_upline = ".$reponse["id_affiliate"]."       ")) or die("Requete reporting_affiliés_1 : TFTA pas comprise ");
		                $affiliate_L1  = $result_L1['nb_aff_L1'];
							 
						 $sql_requete = $sql_base."(".$reponse["id_affiliate"].",CURRENT_TIMESTAMP,".$affiliate_L1.",0,0,0,0,0,0,".$recomm_R0.");  ";
 						  mysql_query($sql_requete) or die("Requete reporting_affiliés_1 : ZCS pas comprise. ");
						}
				$rapport_activite = $rapport_activite." ".$compteur." Affilies L1 - reporting_affiliate_1 > A12 <br/>";	  

	            // 3. REMPLISSAGE DES AFFILIATE L2 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
                 $result2         = mysql_query(" SELECT id_affiliate, affiliate_L1 FROM reporting_affiliate_1   ") or die("Requete reporting_affiliés_1 : 2E pas comprise. ");				
				 WHILE ($reponse2 = mysql_fetch_array($result2))
                        { 
					 				 								
						 /////////   CALCUL DU NOMBRE D'AFFILIÉS LEVEL 2
	                    $result_L1     = mysql_fetch_array(mysql_query(" SELECT sum(affiliate_L1) as nb_aff_L2 
						                                                 FROM affiliate aa, reporting_affiliate_1 ra 
																		 WHERE aa.id_affiliate = ra.id_affiliate
																		 AND   aa.is_activated=1 
																		 AND  id_upline = ".$reponse2["id_affiliate"]."        ")) or die("Requete reporting_affiliés_1 : TFAAQMTA pas comprise ");
						
	                     mysql_query("UPDATE reporting_affiliate_1 
	                                         SET  affiliate_L2       = ".$result_L1['nb_aff_L2']."
	                    				     WHERE id_affiliate      = ".$reponse2["id_affiliate"]."          ");  
							 
						}
				$rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp >>  Affilies L2";					
				

                return ($rapport_activite);			
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function lien_service($s_sub_category, $mode_affichage, $nom_service) 
{          
			     echo '<p><form id="description_service_'.$nom_service.'" action="Intranet_pourquoi_recommander_1.php" method="post"> '; 			
                 echo '     <input type="hidden" name="s_sub_category"                   value = '.$s_sub_category.'  /> '; 
                 echo '     <input type="hidden" name="mode_affichage"                   value = '.$mode_affichage.'  /> '; 				 
                 echo '     <input type="hidden" name="nom_service"                      value = '.($nom_service).'     /> '; 
	    	     echo '<a class="link_label" style="line-height:4px; margin-left:4px; margin-top:10px;"  href="#" onclick="document.getElementById(\'description_service_'.$nom_service.'\').submit();" >  >> '.($nom_service).'  </a> </form> </p>'; 				 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_RECOMMANDATION_FACTURE($id_recommandation, $facture_ttc, $com_nosrezo_total, $r_tva_percent, $filename_facture, $facture_sent) 
{    
	 //date_default_timezone_set('Europe/Paris');
     include('config.php');
     $facture_num_chronos = RETURN_MAX_FACTURE_TO_TAKE("");	 
	 // 1. ON EFFACE LES LIGNES DE FACTURES QUE NOUS N'AVONS PAS ENVOYEES
	 mysql_query(" DELETE FROM recommandation_facture WHERE id_recommandation = '$id_recommandation' AND facture_sent = 0     ") or die("Requete update_partner_notation : 1 pas comprise. "); 
	 
     // 2. ON INSERE LA LIGNE DE LA RECOMMANDATION A TRAITER	 
     mysql_query('SET NAMES utf8');
	 $sql ='insert into recommandation_facture( id_recommandation, action_date, facture_ttc, com_nosrezo_total, montant_tva_percent, filename_facture, facture_sent, facture_num_chronos) 
				                             values (
											 "'.$id_recommandation.'",
											 "'.date("Y-m-d H:i:s").'",
											 "'.$facture_ttc.'",
											 "'.$com_nosrezo_total.'",
											 "'.$r_tva_percent.'",
											 "'.$filename_facture.'",
											 "'.$facture_sent.'",
											 "'.$facture_num_chronos.'" ) 
											 ';
     $result = mysql_query($sql) or die("Requete insert_recommandation_facture pas comprise : #WX80");            
     return ("OK");
}
?>


<?php  function FILENAME_RECOMMANDATION_FACTURE($connection_database2, $id_recommandation, $filename_facture_reco) 
{
		  IF ( $filename_facture_reco <> "" ) { $filename_facture = $filename_facture_reco; }
		  ELSE
		      {
		      $reponse4             = mysql_fetch_array(mysql_query(" SELECT id_recommandation, filename_facture, facture_sent 
			                                                          FROM recommandation_facture 
																	  where id_recommandation =".$id_recommandation." 
																	  and com_nosrezo_total<>0 
																	  order by action_date desc limit 0,1   ")) or die("Requete pas comprise - #3344rQKtwi! ");
		      $filename_facture     = $reponse4['filename_facture'];
			  }
         
		 return ($filename_facture);
}
?>

<?php  function UPDATE_RECOMMANDATION_FACTURE_SENT($id_recommandation, $filename_facture, $facture_sent) 
{
				mysql_query('SET NAMES utf8');
				mysql_query("UPDATE recommandation_facture 
				             SET facture_sent         ='$facture_sent' 
				             WHERE id_recommandation  ='$id_recommandation'  "); 
				//and filename_facture = \"$filename_facture\"    ");            
   			    return ("OK");
}
?>

<?php  function tva_nosrezo_services($id_recommandation) 
{
              include('config.php'); 		  
		      $reponse4             = mysql_fetch_array(mysql_query("SELECT tva_percent_to_pay FROM services where id_services in (select r_sub_category_code from recommandation_details where id_recommandation =".$id_recommandation.")    ")) or die("Requete pas comprise - #333rtwi! ");
		      $tva_percent_to_pay   = $reponse4['tva_percent_to_pay'];
              return ($tva_percent_to_pay);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function EMAILING_RELANCE_AFFILIATE_AVANT_DESACTIVATION( $connection_database2, $path_envoi, $serveur, $id_affiliate, $lien_webinar )
{        
				$rapport_activite = " DÉSACTIVÉS : <br/>";
				$nb_affiliate_qui_sont_desactives = 0;
				include($path_envoi.'/scripts/email/Inscription_email_2.php');
				
	            // 1. ON COMPTE TOUS LES COMPTES DÉSACTIVÉS ////////////////////////////////////////////////////////////////////////////////////////////////////////           
                 $result2 = mysql_query(" SELECT count(aa.id_affiliate) as affiliate_desactives
                                          FROM   affiliate aa
                                          WHERE  aa.is_activated  = 0 
                                          AND    aa.id_affiliate >	$id_affiliate  ") or die("Requete EMAILING RELANCE AFFILIATE_AVANT_DESACTIVATION #ZDMP ");	
										  
   			     $reponse2 = mysql_fetch_array( $result2 );
				 $affiliate_desactives = $reponse2["affiliate_desactives"];

	            // 2. NOUVEAU AFFILIATE TOTAL ////////////////////////////////////////////////////////////////////////////////////////////////////////           
                 $result2 = mysql_query("  SELECT count(aa.id_affiliate) as affiliate_encore_en_vie
                                          FROM   affiliate aa
                                          WHERE  aa.is_activated  = 1 
                                          AND    aa.id_affiliate >	$id_affiliate  ") or die("Requete EMAILING RELANCE AFFILIATE_AVANT_DESACTIVATION #ZDMP ");	
										  
   			     $reponse2 = mysql_fetch_array( $result2 );
				 $affiliate_encore_en_vie = $reponse2["affiliate_encore_en_vie"];
				 $nouveau_affiliate_total = $affiliate_desactives + $affiliate_encore_en_vie;

				 
	            // 3. REQUÊTE D'ENVOI AUX DIFFÉRENTS PARTENAIRES ////////////////////////////////////////////////////////////////////////////////////////////////////////           
                 $result = mysql_query("  SELECT creation_date, aa.id_affiliate, aa.first_name, aa.last_name, aa.last_connection_date, ad.email, 
				                                 ad.phone_number,
                                                 DATEDIFF( now() , creation_date) as nb_days
                                          FROM   affiliate aa, affiliate_details ad
                                          WHERE  aa.is_activated  = 1 
                                          AND    aa.id_affiliate  = ad.id_affiliate 
                                          AND    is_protected     = 0 
                                          AND    aa.id_affiliate >	$id_affiliate  ") or die("Requete EMAILING RELANCE AFFILIATE_AVANT_DESACTIVATION #ZDMP ");	
										  
   			     WHILE ( $reponse = mysql_fetch_array( $result ) )
                        {  
						     // CALCUL DE LA DURÉE D'INSCRIPTION /////////// /////////////////////////////////////////////////////////////////////////////////////////////   
							 $duree_inscription = $reponse["nb_days"] - 1; 

							 IF      ( $duree_inscription == 5 ) // IL RESTE 5 JOURS AVANT LA DÉSACTIVATION  ////////////////////////////////////////////////////////////////////
							 {
							           //$rapport_activite = $rapport_activite." >> 5 jours - A".$reponse["id_affiliate"]."   <br/>";
									   SEND_EMAIL_RELANCE_PARRAIN_AVANT_DESACTIVATION( $reponse["id_affiliate"], $serveur, $lien_webinar, "PRODUCTION", "5 JOURS", "Votre filleul risque d’être désactivé dans 5 jours");
							 }
							 ELSE IF ( $duree_inscription == 7 ) // IL RESTE 3 JOURS AVANT LA DÉSACTIVATION  ////////////////////////////////////////////////////////////////////
							 {
							           //$rapport_activite = $rapport_activite." >> 7 jours - A".$reponse["id_affiliate"]."   <br/>";
									   SEND_EMAIL_RELANCE_PARRAIN_AVANT_DESACTIVATION( $reponse["id_affiliate"], $serveur, $lien_webinar, "PRODUCTION", "3 JOURS", "Votre filleul risque d’être désactivé dans 3 jours");
							 }
							 ELSE IF ( $duree_inscription == 8 ) // IL RESTE 2 JOURS AVANT LA DÉSACTIVATION  ////////////////////////////////////////////////////////////////////
							 {
							           //$rapport_activite = $rapport_activite." >> 8 jours - A".$reponse["id_affiliate"]."  <br/>";
									   SEND_EMAIL_INSCRIPTION_NOUVEAU($connection_database2, $reponse["id_affiliate"], $serveur, $lien_webinar, "PRODUCTION", "48 HEURES", "Désactivation de votre compte gratuit NosRezo dans 48h");
									   
							 }
							 ELSE IF ( $duree_inscription == 9 ) // IL RESTE 1 JOUR AVANT LA DÉSACTIVATION   ////////////////////////////////////////////////////////////////////
							 {
							           //$rapport_activite = $rapport_activite." >> 9 jours - A".$reponse["id_affiliate"]."  <br/>";
									   SEND_EMAIL_RELANCE_PARRAIN_AVANT_DESACTIVATION( $reponse["id_affiliate"], $serveur, $lien_webinar, "PRODUCTION", "24 heures", "Votre filleul risque d’être désactivé dans 24 heures");
							 }
							 ELSE IF ( $duree_inscription > 11 ) // DÉSACTIVATION  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							 {
							           $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp >> A".$reponse["id_affiliate"]." - ".$reponse["email"]." <br/>";
									   $nb_affiliate_qui_sont_desactives = $nb_affiliate_qui_sont_desactives + 1;
									   SEND_EMAIL_DESACTIVATION_DU_COMPTE( $reponse["id_affiliate"], $serveur, $lien_webinar, "PRODUCTION", "", "Votre compte NosRezo est désactivé");							      
									   UPDATE_AFFILIATE_ACTIVATED( $reponse["id_affiliate"], 0);
							 }							 
							 
						}
						
				$rapport_activite = $rapport_activite."   <br/>  [ TODAY : ".$nb_affiliate_qui_sont_desactives." AFFILIÉS DÉSACTIVÉS ] <br/><br/> ";
				
				$pourcentage_desinscrits = round( $affiliate_desactives / $nouveau_affiliate_total * 100 , 3, PHP_ROUND_HALF_DOWN);
				$rapport_activite = $rapport_activite."   <br/>  [ TOTAL : ".$affiliate_desactives." DÉSACTIVÉS / ".$nouveau_affiliate_total." INSCRITS ]";
				$rapport_activite = $rapport_activite."   <br/>  [ TOTAL : <b>".$pourcentage_desinscrits." %</b> DE DÉSACTIVATION ] <br/> ";
				
                return ($rapport_activite);			
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>




<?php  function COM_NOSREZO_SERVICES($id_service) 
{
              include('config.php'); 		  
		      $reponse4             = mysql_fetch_array(mysql_query("SELECT id_services, com_nosrezo_percent, com_nosrezo_forfait FROM services where id_services =".$id_service."    ")) or die("Requete pas comprise - #33rtwi! ");
		      $com_nosrezo_percent  = $reponse4['com_nosrezo_percent'];
			  $com_nosrezo_forfait  = $reponse4['com_nosrezo_forfait'];
			  
			  IF      ($com_nosrezo_percent <> 0)  { return ($com_nosrezo_percent/100); }
			  ELSE IF ($com_nosrezo_forfait <> 0)  { return ($com_nosrezo_forfait); }
			  ELSE                                 { return (0);}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function SEND_FACTURE_QUI_SONT_PRETES($connection_database2, $id_action, $path_envoi, $serveur , $host_mail, $user_mail, $password )
{           
                //include('config.php'); 
				$rapport_activite = "&nbsp &nbsp &nbsp &nbsp >> Aucune facture en attente d'envoi <br/>";
						 
	            // 1. REQUÊTE D'ENVOI AUX DIFFERENTS PARTENAIRES             
                 $result = mysql_query(" SELECT distinct id_recommandation, filename_facture 
				                         FROM recommandation_facture 
										 WHERE facture_sent = 0  ") or die("Requete SENT BILL : PODJ pas comprise. ");				
   			     while ($reponse = mysql_fetch_array($result))
                        {  
						 $rapport_activite = SEND_FACTURE_PARTENAIRE($connection_database2, $reponse["id_recommandation"], "PREMIER ENVOI", $path_envoi, $serveur, $host_mail, $user_mail, $password ); 						   
						}
                return ($rapport_activite);			
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function LAST_ID_ACTION_FROM_ACTION_LIST($connection_database2, $id_recommandation) 
{  
             $sql        =  "SELECT id_action 
			                 FROM action_list 
							 WHERE id_recommandation = ".$id_recommandation." 
							 AND action_statut = \"OUVERT\"  limit 0,1   ";               
		     $result     =  mysql_query($sql) or die("Requete pas comprise #LAST_ID_ACTION_FROM_ACTION LIST");
		     $reponse    =  mysql_fetch_array($result);
             $id_action  =  $reponse['id_action'];
			  						   
   			 return ($id_action);
}
?>

<?php  function LAST_ID_INFO_ACTION_FROM_ACTION_LIST($id_recommandation) 
{  
             $sql           =  "SELECT id_action, id_partner, id_affiliate, description FROM action_list WHERE id_recommandation = ".$id_recommandation." AND action_statut = \"OUVERT\"  limit 0,1   ";               
		     $result        =  mysql_query($sql) or die("Requete pas comprise #LAST_ID_ACTION_FROM_ACTION LIST");
		     $reponse       =  mysql_fetch_array($result);
             $id_action     =  $reponse['id_action'];
			 $id_partner    =  $reponse['id_partner'];
			 $id_affiliate  =  $reponse['id_affiliate'];
			 $description   =  $reponse['description'];
			  						   
   			 return array ($id_action, $id_partner, $id_affiliate, $description);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_ACTION_LIST_DUPLICATE($id_action, $days, $relance, $statut, $texte_partenaire) 
{ 
			//date_default_timezone_set('Europe/Paris');
			 mysql_query('SET NAMES utf8');	
             $sql_1            =  " SELECT id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, relance_automatique, compteur_relance
   			                        FROM action_list 
								    WHERE id_action = ".$id_action ."  ";               
		     $result_1         =  mysql_query($sql_1) or die("Requete pas comprise #1J1AAX749");
		     $reponse_1        =  mysql_fetch_array($result_1);
			 
			      IF ($reponse_1['action_id_category'] == 11 OR $reponse_1['action_id_category'] == 12)  { $compteur_relance = $reponse_1['compteur_relance'] + 1;  }          // POUR ETAPE 2
	         ELSE                                                                                        { $compteur_relance = $reponse_1['compteur_relance'];  } 
			 
			 $action_max_date  =  date('Y-m-d H:i:s',time()+$days*24*3600);     // AVANCE de Xj
			 $reponse_1['description'] = stripslashes( $reponse_1['description'] );
	         $reponse_1['description'] = addslashes( $reponse_1['description'] );
			 
			 $reponse_1['description_2'] = stripslashes( $reponse_1['description_2'] );
	         $reponse_1['description_2'] = addslashes( $reponse_1['description_2'] );
			 
	         $sql ='insert into action_list(id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, relance_automatique, compteur_relance) 
				                             values (
											 "",
											 "'.date("Y-m-d H:i:s").'",
											 "'.$action_max_date.'",
											 "'.$reponse_1['action_category'].'", 
											 "'.$reponse_1['action_priority'].'", 
											 "'.$reponse_1['action_id_category'].'", 
											 "'.$reponse_1['action_details'].'", 
											 "'.$reponse_1['id_recommandation'].'", 
											 "'.$reponse_1['id_partner'].'", 
											 "'.$reponse_1['id_affiliate'].'", 
											 "'.$reponse_1['action_statut'].'",
                                             "'.$reponse_1['action_status_int'].'",											 
											 "'.$reponse_1['description'].'", 
											 "'.$reponse_1['description_2'].'", 
											 "'.$reponse_1['owner_id'].'", 
											 "'.$statut.'",										 
											 "'.$relance.'",
											 "'.$compteur_relance.'"
											 )
											 ';		
				//If ($_SESSION['id_affiliate'] == 841 ) { echo	$sql; }			 
                
				$result = mysql_query($sql) or die("Requete insert_action_list pas comprise #INSERT_ACTION_LIST_DUPLICATE");            
   			    return ("OK");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function INSERT_ACTION_LIST_DUPLICATE_REFUSE_PARTENAIRE($connection_database2, $id_action, $days, $relance, $information_text) 
{ 
             include('config.php'); 
			 mysql_query('SET NAMES utf8');	
             $sql_1        =  " SELECT id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, description, description_2, owner_id, owner_action, relance_automatique 
			                    FROM action_list where id_action = ".$id_action ."  "; 
//echo "<br/>".$sql_1;								

			 $result_1     =  mysql_query($sql_1) or die("Requete pas comprise #1J1PPP49");
		     $reponse_1    =  mysql_fetch_array($result_1);
			 $description  = $reponse_1['description']." \n ".$information_text;
			 $description  = stripslashes($description);
			 $description  = addslashes($description);
			 
	         //date_default_timezone_set('Europe/Paris');
	         $action_max_date    = date('Y-m-d H:i:s',time()+$days*24*3600);     // AVANCE de Xj

	         $sql ='insert into action_list(id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, relance_automatique) 
				                             values (
											 "",
											 "'.date("Y-m-d H:i:s").'",
											 "'.$action_max_date.'",
											 "Étape 2", 
											 "'.$reponse_1['action_priority'].'", 
											 "11", 
											 "Affecter un nouveau partenaire. Le dernier à refusé la recommandation.", 
											 "'.$reponse_1['id_recommandation'].'", 
											 "'.$reponse_1['id_partner'].'", 
											 "'.$reponse_1['id_affiliate'].'", 
											 "'.$reponse_1['action_statut'].'",
                                             "'.RETURN_ACTION_STATUS_INT( $reponse_1['action_statut'] ).'",											 
											 "'.$description.'", 
											 "'.$reponse_1['description_2'].'", 
											 "'.$reponse_1['owner_id'].'", 
											 "Refusée par le partenaire. Recommandation à réaffecter", 
											 "'.$relance.'"
											 )
											 ';	
											 
                $result = mysql_query($sql) or die("Requete insert_action_list pas comprise #RDSGY0N.php");            
   			    return ("OK");
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function GESTION_DES_RELANCES_PARTENAIRES($connection_database2, $etapes, $param2, $path_nosrezo_racine, $serveur, $host_mail, $user_mail, $password ) 
{  
             // 1. DEFINIR LA LISTE DE TOUTES LES ACTIONS A RELANCER 
			 $rapport_activite = "&nbsp &nbsp &nbsp &nbsp >> Etape ";
			 
			  $result_relance      = mysql_query(" SELECT id_action, action_id_category, id_recommandation  
					                               FROM action_list  
												   WHERE action_status_int = 1 
						                           AND   action_id_category in (21)  ") or die("Requete pas comprise : NosRezo12345678919.php - TRRDSHSH4 - Oups"); 


             // 2. POUR CHAQUE ACTION ET EN FONCTION DE L'ÉTAPE EN COURS : RELANCE
   			     WHILE ($reponse_relance = mysql_fetch_array($result_relance))
                        {  
			                 $id_action           = $reponse_relance['id_action'];	
			                 $action_id_category  = $reponse_relance['action_id_category'];	
							 $id_recommandation   = $reponse_relance['id_recommandation'];									 
							
								
	                                          $result_facture      = mysql_query(" SELECT count(id_recommandation) as is_exist  
											                                       FROM recommandation_facture 
																				   WHERE id_recommandation =  ".$id_recommandation." 
																				   order by action_date desc limit 0,1   ") or die("Requete pas comprise : NosRezo12345678919.php - TdlSZZHSH4 - Oups");              
                                              $reponse_facture     = mysql_fetch_array($result_facture); 
                                              IF ($reponse_facture['is_exist'] > 0) ////// LA FACTURE A ETE ENVOYÉE : NOUS RELANCONS LE PARTENAIRE CAR TOUJOURS PAS PAYÉ
									          {
									             SEND_FACTURE_PARTENAIRE($connection_database2, $id_recommandation, "RELANCE", $path_nosrezo_racine , $serveur, $host_mail, $user_mail, $password ); 
									          }

						}
						return ($rapport_activite);						
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function GESTION_DES_RELANCES_PARTENAIRES_ETAPE_2($connection_database2, $etapes, $param2, $NosRezo_racine, $serveur) 
{  //11. ÉTAPE 2    - AFFECTER PARTENAIRE
   //12. ÉTAPE 2    - VALIDER/MODÉRER LA RECOMMANDATION

             // 1. DEFINIR LA LISTE DE TOUTES LES ACTIONS A RELANCER 
			 $rapport_activite = " >> ÉTAPE 2 ";
			 
             IF ($etapes == 2) // SI PAS DE RETOUR DANS LES 48 H ALORS RELANCE AUTOMATIQUE
			   {  $result_relance      = mysql_query(" SELECT id_action, id_affiliate, action_id_category, id_recommandation , compteur_relance
						                                          FROM action_list 
																  WHERE DATEDIFF( NOW( ), action_creation_date ) *24 > 90 
																  AND action_status_int = 1 
																  AND action_id_category in (11, 12)   ") or die("Requete pas comprise : NosRezo12345678919.php - QSQSQSMMP - Oups"); 
						    $rapport_activite = $rapport_activite."2 non traitees > 96h : <br/>";
			   }
				 include($NosRezo_racine.'/scripts/email/Communication_affilie_manque_partenaire.php');  
				 
             // 2. POUR CHAQUE ACTION ETAPE 2 ON RELANCE
   			     WHILE ($reponse_relance = mysql_fetch_array($result_relance))
                        {  
			                 $id_action           = $reponse_relance['id_action'];	
			                 $action_id_category  = $reponse_relance['action_id_category'];	
							 $id_recommandation   = $reponse_relance['id_recommandation'];	
                             $compteur_relance    = $reponse_relance['compteur_relance'];
                             $id_affiliate        = $reponse_relance['id_affiliate'];							 
							 	 
                            IF ($compteur_relance < 5) ////////////// RELANCE 4 FOIS AVANT DE FERMER LA RECOMMANDATION
                            { 
						     // 1. ON DUPLIQUE L'ACTION OUVERTE ET ON LAISSE 1 JOUR DE DÉLAI DE TRAITEMENT PUIS ON FERME L'ANCIENNE ACTION : COMPTEUR ACTION + 1;
							     insert_action_list_duplicate($id_action, 0, 1, "RELANCE PARTENAIRE", "");
                                 update_action_list_que_statut($connection_database2, $id_action, "FERME"); 
								 
							 // 2. ON ENVOI MAIL D'INFORMATION A AFFILIÉ POUR COMMUNICATION
					             SEND_EMAIL_COMMUNICATION_AFFILIATE_PART($connection_database2, $id_recommandation, $serveur, 1);	
                                 $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - Envoi mail Affilié : ".$id_affiliate." <br/>";								 
					
                            }
							ELSE // CLOTURE DU DOSSIER 
							{
                                 update_action_list_que_statut($connection_database2, $id_action, "FERME"); 
								 insert_into_recommandation_annulee($id_recommandation, 20, "Fermeture automatique par GESTION DES_RELANCES_PARTENAIRES_ETAPE_2" );
					             SEND_EMAIL_COMMUNICATION_AFFILIATE_PART($connection_database2, $id_recommandation, $serveur, 2);
                                 update_status_recommandation_details($connection_database2, $id_recommandation, 0);								 
                                 $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - Fermeture recommandation : ".$id_recommandation." <br/>";									
							}

						}
						return ($rapport_activite);						
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function GESTION_DES_RELANCES_PARTENAIRES_ETAPE_3($connection_database2, $etapes, $param2, $NosRezo_racine, $serveur) 
{   //13. ETAPE 3    - TRAITEMENT PARTENAIRE

             // 1. DEFINIR LA LISTE DE TOUTES LES ACTIONS A RELANCER 
			 $rapport_activite = "&nbsp - ETAPE 3<br/>";			 
             $result_relance      = mysql_query(" SELECT id_action, id_affiliate, action_id_category, id_recommandation , id_partner, description, compteur_relance, now(), date_a_relancer_automatique, compteur_sms , source_action
						                                          FROM action_list 
																  WHERE date_a_relancer_automatique > 0
																  AND NOW( ) > date_a_relancer_automatique 
																  AND action_statut = \"OUVERT\" 
																  AND compteur_relance < 6
																  AND action_id_category in (13)  
                                                                  AND id_recommandation >= 2400		  ") or die("Requete pas comprise : NosRezo12345678919.php - QSQSQSMMP - Oups");  
															  																  
             // 2. POUR CHAQUE ACTION ETAPE 3 ON RELANCE
   			     WHILE ($reponse_relance = mysql_fetch_array($result_relance))
                        {  
			                 
							 $id_action              = $reponse_relance['id_action'];	
			                 $action_id_category     = $reponse_relance['action_id_category'];	
							 $id_recommandation      = $reponse_relance['id_recommandation'];	
                             $compteur_relance       = $reponse_relance['compteur_relance'];
							 $compteur_sms           = $reponse_relance['compteur_sms'];
                             $id_partner             = $reponse_relance['id_partner'];
							 
	                        //date_default_timezone_set('Europe/Paris');
							 List($action_max_date, $date_a_relancer_automatique, $message) =  GESTION_DE_ACTION_MAX_DATE(date('Y-m-d H:i:s'), $action_id_category, $id_recommandation, 0, $compteur_relance, $reponse_relance['source_action'] , "NON URGENT"); 
			                 $description            = $reponse_relance['description']." ".$message;


                             $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - BOUCLE 1: P".$id_partner." - R".$id_recommandation." - RELANCE ".$compteur_relance." <br/>";

                             
						    IF ($compteur_relance == 4)              ///////////////////////////// ENVOI D'UN SMS 4
							{
                                 // 1. MISE A JOUR DE LA TABLE ACTION_LIST POUR LE SUIVI DE L'ACTION EN COURS
                                $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - ESSAI SMS P".$id_partner." - R".$id_recommandation."<br/>";	
                                mysql_query("UPDATE action_list 
                                                    SET managed_date                    =  CURRENT_TIMESTAMP, 
                                                        description                     = \"$description\", 
                                                        compteur_relance                = '$compteur_relance' + 1,
														compteur_sms                    = '$compteur_sms' + 1
                                				     WHERE id_action                    = '$id_action'        ");  
							
							     // 2. ENVOI SMS DE RELANCE AU PARTENAIRE
								 
	                              $reponse_part   = mysql_fetch_array(mysql_query(" 
	                                                SELECT  rd.id_privileged_partner, p_contact_phone, pl.p_contact_phone2, p_first_name, p_last_name
						                            FROM recommandation_details rd, partner_list pl
						                            WHERE rd.id_privileged_partner  =  pl.id_partner 
						                            AND   rd.id_recommandation      =  ".$id_recommandation."       ")) or die("Requete pas comprise - #3QW0912! ");								 
								 
								 $num_tel         = trim($reponse_part['p_contact_phone']); 
								 $text_a_envoyer  = trim($reponse_part['p_first_name'])." ".trim($reponse_part['p_last_name']).", vous avez reçu une recommandation NosRezo il y a plus de 48H sans aucune évolution dans votre intranet. \n Merci de mettre à jour immédiatement ce dossier si vous souhaitez en recevoir à nouveau. \n www.nosrezo.com  ";

				                 include($NosRezo_racine.'/scripts/theCallR/envoi_sms.php'); 								 
								// echo $num_tel.'<br/><br/>'.$text_a_envoyer.'<br/><br/>';
								 
								 IF ($num_tel <> "") {
                                 SEND_SMS_RELANCE_PARTENAIRE_1($num_tel, $text_a_envoyer);	
								 }							 
							
                                 $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - Envoi SMS : P".$id_partner." <br/>";									
							}
							ELSE    /////////////////////// RELANCE PAR MAIL
                            { 
						     // ON UPDATE L'ACTION OUVERTE ET ON PRÉCISE LA DATE DE LA PROCHAINE RELANCE;	
                                 mysql_query("UPDATE action_list 
                                                    SET managed_date                    =  CURRENT_TIMESTAMP, 
                                                        description                     = \"$description\", 
                                                        compteur_relance                = '$compteur_relance' + 1,
                                                        date_a_relancer_automatique     = '$date_a_relancer_automatique'
                                				     WHERE id_action                    = '$id_action'        ");            						 

								 
							 // 2. ON ENVOI MAIL D'INFORMATION A AFFILIÉ POUR COMMUNICATION
							     SEND_EMAIL_PARTENAIRE_RECO($connection_database2, $id_recommandation, $compteur_relance + 2);
                                 $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - Envoi mail P".$id_partner." - R".$id_recommandation."<br/>";								 
					
                            }

						}
						
						return ($rapport_activite);						
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function RELANCES_PARTENAIRES_MAX_DATE($connection_database2, $param2, $NosRezo_racine, $serveur) 
{   //13. ETAPE 3    - TRAITEMENT PARTENAIRE
    // CE MODUEL RELANCE 1 SEULE FOIS LES PARTENAIRES AU MOMENT DE LA MAX DATE
    // LE BACK OFFICE NR INTERVIENT 24H APRES

             // 1. DEFINIR LA LISTE DE TOUTES LES ACTIONS A RELANCER 
			     $rapport_activite    = "";			 
			     $result_relance      = mysql_query(" SELECT id_action, id_affiliate, action_id_category, id_recommandation , id_partner, description, compteur_relance, now(), date_a_relancer_automatique, compteur_sms , source_action
						                                          FROM action_list 
																  WHERE NOW( ) > date_a_relancer_automatique 
																  AND date_a_relancer_automatique > 0
																  AND action_statut = \"OUVERT\" 
																  AND action_id_category in (13, 14, 15, 16)  		 ") or die("Requete pas comprise : NosRezo12345678919.php - QSQSQSMMP - Oups");  
				 
             // 2. POUR CHAQUE ACTION ETAPE 3 ON RELANCE
			//date_default_timezone_set('Europe/Paris');
   			     WHILE ( $reponse_relance = mysql_fetch_array($result_relance) )
                        {  
			                 $id_action              = $reponse_relance['id_action'];	
			                 $action_id_category     = $reponse_relance['action_id_category'];	
							 $id_recommandation      = $reponse_relance['id_recommandation'];	
                             $compteur_relance       = $reponse_relance['compteur_relance'];
							 $compteur_sms           = $reponse_relance['compteur_sms'];
                             $id_partner             = $reponse_relance['id_partner'];
						     $message                = " \n - Relance mail : ". date('Y-m-d H:i') ."  ";
			                 $description            = $reponse_relance['description']." ".$message;
                             
 						     // 1. ON UPDATE L'ACTION OUVERTE ET ON PRECISE LA DATE DE LA PROCHAINE RELANCE;
                                mysql_query("UPDATE action_list 
                                                    SET managed_date                    =  CURRENT_TIMESTAMP, 
                                                        description                     = \"$description\", 
                                                        compteur_relance                = '$compteur_relance' + 1,
                                                        date_a_relancer_automatique     = '0000-00-00 00:00:00'
                                				     WHERE id_action                    = '$id_action'        ");            						 

								 
							 // 2. ON ENVOI MAIL D'INFORMATION A AFFILIÉ POUR COMMUNICATION
							     send_email_partenaire_reco($connection_database2, $id_recommandation, 2);
                                 $rapport_activite = $rapport_activite."&nbsp &nbsp &nbsp &nbsp - Envoi mail P".$id_partner." - R".$id_recommandation."<br/>";								 

						}
			   
						return ($rapport_activite);						
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php  function UPDATE_AFFILIATE_DETAILS_PROFIL($connection_database2, $id_affiliate, $phone_number, $zip_code, $address, $city, $birth_place, $nationality, $id_securite_sociale, $logement_affiliate, $statut_logement ) 
{
		IF (get_magic_quotes_gpc())
		{
			    $phone_number                    = stripslashes($phone_number);
			    $address                         = stripslashes($address);			
			    $zip_code                        = stripslashes($zip_code);
			    $city                            = stripslashes($city);	
			    $birth_place                     = stripslashes($birth_place);
			    $nationality                     = stripslashes($nationality);
			    $id_securite_sociale             = stripslashes($id_securite_sociale);
		}
		
				include('config.php'); 
				//date_default_timezone_set('Europe/Paris');      		
				$sql = "UPDATE affiliate_details
				                     SET phone_number         = '$phone_number',	
                                     address                  = '$address',								 
									 zip_code                 = '$zip_code',
									 city                     = '$city', 
									 birth_place              = '$birth_place',
									 nationality              = '$nationality',
									 id_securite_sociale      = '$id_securite_sociale',
									 logement_affiliate       = '$logement_affiliate',
									 statut_logement          = '$statut_logement'
									 WHERE id_affiliate       = '$id_affiliate'    "; //echo $sql;
				mysql_query($sql) or die("Requete affiliate_details pas comprise #AJJJJJ9");	
				return ("OK");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function lien_etapes_recommandations($id_action, $r_sub_category_code) 
{   
             // 1. GESTION DES action_id_category ET MAPPING VERS LES ETAPES 			   
			       if ($id_action == 0)   {$id_action = 10;} 
			       if ($id_action == 11)  {$id_action = 2;} 
			       if ($id_action == 12)  {$id_action = 2;} 
			       if ($id_action == 13)  {$id_action = 3;} 
			       if ($id_action == 14)  {$id_action = 4;} 
			       if ($id_action == 15)  {$id_action = 5;} 
			       if ($id_action == 16)  {$id_action = 6;} 
				   if ($id_action == 17)  {$id_action = 8;}
			       if ($id_action == 18)  {$id_action = 9;} 
			       if ($id_action == 19)  {$id_action = 10;} 
			       if ($id_action == 20)  {$id_action = 7;} 
			       if ($id_action == 21)  {$id_action = 7;} 
			       if ($id_action == 22)  {$id_action = 7;} 
				   
             // 2. GESTION DU SERVICE A AFFICHER
			       if ($r_sub_category_code == 0) 
				   { // IL FAUT DETERMINER LE BON r_sub_category_code
				    
					}
					//echo " r_sub_category_code : ".$r_sub_category_code;
			 
			 // 3. AFFICHAGE DES ETAPES DE 1 A 10 
				   
                    if ($r_sub_category_code == 1 or $r_sub_category_code == 2)  
			                                   { $lien_fichier = "fichiers/Etape_immobilier_vente_".$id_action.".PNG";  }
               else if ($r_sub_category_code == 4)  
			                                   { $lien_fichier = "fichiers/Etape_immobilier_financement_".$id_action.".PNG";  }
               else if ($r_sub_category_code == 8 or $r_sub_category_code == 9)  
			                                   { $lien_fichier = "fichiers/Etape_recrutement_".$id_action.".PNG";  }
               else                            { $lien_fichier = "fichiers/Etape_travaux_".$id_action.".PNG";  }			   
			  
                    if ($r_sub_category_code == 100)  
			                                   { $lien_fichier = "fichiers/Etapes_prescription_Admin.PNG";  }
										   
                    ELSE if ($r_sub_category_code == 51 OR $r_sub_category_code == 52 OR $r_sub_category_code == 53 OR $r_sub_category_code == 54)  
			                                   { $lien_fichier = "fichiers/Etape_comptabilite_vente_10.PNG";  }
										   
			   return ($lien_fichier);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<?php  function VUE_AFFILIE_FULL_ADMIN($connection_database, $id_affiliate, $param1, $param2) 
{
                	$result = $connection_database->query( "SELECT af.password, ad.first_name, ad.last_name, ad.address, ad.zip_code, ad.city, ad.phone_number, ad.email, ad.creation_date, ad.birth_place, ad.nationality, ad.birth_date, af.last_connection_date, af.is_activated, ad.contract_signed, af.id_partenaire , numero_de_pack, contact_association, id_securite_sociale, is_protected
					               FROM   affiliate_details ad, affiliate af   
					               WHERE  ad.id_affiliate=af.id_affiliate 
								   AND    ad.id_affiliate = ".$id_affiliate."   " );
                	
                    $reponse10 = $result->fetch(PDO::FETCH_ASSOC);


					 $mdp       = $reponse10['password'];
					  
					                     $creation_depuis    = round((strtotime(date('Y-m-d H:i:s',time())) - strtotime($reponse10["creation_date"]))/(60*60*24)); 
					                     $connection_depuis  = round((strtotime(date('Y-m-d H:i:s',time())) - strtotime($reponse10["last_connection_date"]))/(60*60*24)); 
 
					 
					 mysql_query('SET NAMES utf8');
					 $sql50     = "SELECT code_banque, code_guichet, numero_compte, cle_rib, IBAN, iban_creation_date, nom_banque  
					               FROM affiliate_iban 
								   where id_affiliate=".$id_affiliate."   ";               
                     $result50  = mysql_query($sql50) or die("Requete pas comprise #ASXMP0W!");					 
					 $reponse50 = mysql_fetch_array($result50);
 
					 IF ($reponse10["id_partenaire"] > 0) 
					 { 
	                     $sql20          = " SELECT is_activated, recommanded_by, id_partner, p_category, p_sub_category, id_services, p_company, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_secteur, p_fonction, p_contact_phone, p_contact_phone2, commentaire_interne, p_contact_mail, p_company, is_activated , p_adresse, is_access_intranet, p_creation_date, p_zip_code, p_city, p_rayon, p_contrat_recu, p_kbis_recu, p_assurance_recu, p_lat, p_long, date_debut_conges, date_fin_conges , date_reception_contrat, date_relance_kbis, date_relance_assurance , p_note_partenaire 
						                     FROM partner_list pl 
						                     WHERE pl.id_partner = ".$reponse10["id_partenaire"]."    limit 0,1     ";            
					     $result20       = mysql_query($sql20) or die(" A - Requete pas comprise #122");
					     $reponse20      = mysql_fetch_array($result20);	
						 $recommanded_by = $reponse20["recommanded_by"];
						 $_POST['p_note_partenaire'] = $reponse20["p_note_partenaire"];
						 
                         IF ($recommanded_by == "") { $recommanded_by = 0; }
						 
                         $sql33     = " SELECT ad.id_affiliate, ad.first_name, ad.last_name, ad.address, ad.zip_code, ad.city, ad.phone_number, ad.email, ad.creation_date, ad.birth_place, ad.nationality, ad.birth_date, af.last_connection_date, af.is_activated, ad.contract_signed, af.id_partenaire 
						                FROM affiliate_details ad, affiliate af   
										WHERE ad.id_affiliate = af.id_affiliate  
										AND ad.id_affiliate = ".$recommanded_by."   ";               
						 $result33  = mysql_query($sql33) or die(" Requete pas comprise #3A3122");
					     $reponse33 = mysql_fetch_array($result33);

					 }
					 ELSE
					 {
                         $reponse20["p_contact_mail"] ="";	
		  	             $reponse20["id_services"] = "";
                         $reponse20["p_sub_category"] ="";	
                         $reponse20["id_partner"]     = 0;							 
					 }
										 				 

 		echo '<div class="col-md-12 portlet-title tabbable-line">';
									
				echo '<ul class="nav nav-tabs">';
					 
					 
					 ?>	

				 
				 
				 
				                  <li class="active"><a href="#tab_2_1" data-toggle="tab">  <i class="fa fa-user"></i>  AFFILIÉ </a></li>
				           <?php IF ($reponse10["id_partenaire"] > 0) 
						   {  ?>  <li><a href="#tab_2_4" data-toggle="tab"> <i class="fa fa-briefcase"></i>  PARTENAIRE   </a></li>              <?php }  ?>
				                  <li><a href="#tab_2_2" data-toggle="tab"> <i class="fa fa-bookmark-o"></i>  RECOMMANDATION   </a></li>
				                  <li><a href="#tab_2_3" data-toggle="tab"><i class="fa fa-sitemap"></i>  NOSREZO </a></li>
				           <?php IF ($reponse10["id_partenaire"] > 0) 
						   {  IF ($reponse20["id_services"] == 1 OR $reponse20["id_services"] == 50)
							   {
						   ?>  <li><a href="#tab_2_5" data-toggle="tab"> <i class="fa fa-sitemap"></i>  IAD  </a></li>              <?php }}  ?>
						       <li><a href="#tab_2_6" data-toggle="tab"> <i class="fa fa-sitemap"></i>  TRANSFERT FILLEUL </a></li>
				 </ul>
				 <div class="tab-content">
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------>	 
			 <div id="tab_2_1" class="tab-pane fade active in col-md-12 margin-top-20" >
			 <div class="portlet-body " >
			 <div class="table-responsive" >

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group ">
                 <div class="col-md-3 input-sm">
                     <label class="control-label" for="nom">AFFILIÉ NOSREZO</label>
                 </div>
                 <div class="col-md-5 input-icon">	
                     <i class="fa fa-user"></i>			 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo 'A'.$id_affiliate ?>" readonly /> 
                 </div>
                 <div class="col-md-4 input-icon">
                     <i class="fa fa-phone"></i>			 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo DISPLAY_IBAN( $reponse10["phone_number"], 2) ?>" readonly /> 
                 </div>
             </div>

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group ">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">NOM / PRÉNOM</label>
             </div>
             <div class="col-md-5 input-icon">	
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_name"] ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["first_name"] ?>" readonly /> 
             </div>
             </div>
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group ">
                 <div class="col-md-3 input-sm">
                     <label class="control-label" for="nom">ADRESSE</label>
                 </div>
                 <div class="col-md-5 input-icon">
			         <i class="fa fa-location-arrow"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse10["address"]) ?>" readonly /> 
                 </div>
                 <div class="col-md-4 input-icon">
			         <i class="fa fa-globe"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse10["zip_code"]).' '.($reponse10["city"])  ?>" readonly /> 
                 </div>
             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group ">
                 <div class="col-md-3 input-sm">
                     <label class="control-label" for="nom">NAISSANCE</label>
                 </div>
				 
                 <div class="col-md-5 input-icon">
			         <i class="fa fa-heart"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo "Le ".$reponse10["birth_date"]  ?>" readonly /> 
                 </div>
				 
                 <div class="col-md-4 input-icon">
			         <i class="fa fa-globe"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo " À ".$reponse10["birth_place"].' Nationalité : '.$reponse10["nationality"].'  '  ?>" readonly /> 
                 </div>

             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group ">
                 <div class="col-md-3 input-sm">
                     <label class="control-label" for="nom">SÉCURITÉ SOCIALE </label>
                 </div>
				 
                 <div class="col-md-5 input-icon">
			         <i class="fa fa-heart"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["id_securite_sociale"]  ?>" readonly /> 
                 </div>
				 
                 <div class="col-md-4 input-icon">
			         <i class="fa fa-globe"></i>
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ' Nationalité '.$reponse10["nationality"].'  '  ?>" readonly /> 
                 </div>

             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                 <div class="col-md-3 input-sm margin-top-10">
                     <label class="control-label" for="nom">MAIL</label>
                 </div>
             
			     <div class="col-md-5 input-icon margin-top-10">
			         <i class="fa fa-envelope"></i>
                         <input class="form-control input-sm" type="text" name="mail_affilie"  value="<?php echo ($reponse10["email"]) ?>"  /> 
                 </div>
			 
             <div class="col-md-4 input-icon">


                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_mail_affilie"        value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"]?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                             
	                                <button type="submit" class="btn btn-sm  small btn-circle blue margin-top-10">METTRE À JOUR MAIL AFFILIÉ &nbsp &nbsp &nbsp <i class="fa fa-plus"></i></button>
                             
                                 </div>
			
			 </form>
             </div>
             </div>	

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                 <div class="col-md-3 input-sm margin-top-10">
                     <label class="control-label" for="nom">PACK ACTUEL</label>
                 </div>
                 <div class="col-md-5 input-icon margin-top-10">
			         <i class="fa fa-location-arrow"></i>
                         <input class="form-control input-sm" type="text" name="mail_affilie"  value="<?php echo $reponse10["numero_de_pack"] ?>"  /> 
                 </div>
             <div class="col-md-4 input-icon ">
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_mail_affilie"        value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"]?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="numero_de_pack"          value = 1 />  
									
	                                <button type="submit" class="btn btn-sm  small btn-circle blue margin-top-10">PASSER AU PACK ASSOCIATION  &nbsp <i class="fa fa-plus"></i></button>
                             
                                 </div>
			
			 </form>
             </div>
             </div>	
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <?php IF ($reponse10["numero_de_pack"] > 0 ) { ?>
			 <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom">CONTACT ASSOCIATION</label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="nouveau_contact_association"  value="<?php echo $reponse10["contact_association"] ?>"  /> 
                         </div>
			 
             <div class="col-md-4 input-icon">

                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="contact_association"     value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">CHANGEMENT DE CONTACT &nbsp &nbsp &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	
			 <?php } ?>

	
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <?php IF ( $_SESSION['id_affiliate'] < 10 ) { ?>
			 
			 <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom"> CHANGER DE NOM </label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="nouveau_nom_affiliate"  value="<?php echo $reponse10["last_name"] ?>"  /> 
                         </div>
			 
             <div class="col-md-4 input-icon">

                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="changer_de_nom"          value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">CHANGEMENT DE NOM &nbsp &nbsp &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>		
			         			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

								 
			 <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom"> IS PROTECTED </label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="devient_proteger"  value="<?php echo $reponse10["is_protected"] ?>"  /> 
                         </div>
			 
             <div class="col-md-4 input-icon">

                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_proteger_aff"        value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">PROTÉGER AFFILIÉ &nbsp &nbsp &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>		
			         			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
								 
								 

			 <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom"> CHANGER DE TÉLÉPHONE </label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-phone"></i>			 
                         <input class="form-control input-sm" type="text" name="nouveau_phone_affiliate"  value="<?php echo $reponse10["phone_number"] ?>"  /> 
                         </div>
			 
             <div class="col-md-4 input-icon">

                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="changer_de_phone"        value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">CHANGEMENT DE PHONE &nbsp &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	

			 <?php } ?>			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

			 <div class="form-group">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom">CHANGER DE PRÉNOM</label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="nouveau_prenom_affiliate"  value="<?php echo $reponse10["first_name"] ?>"  /> 
                         </div>
			 
             <div class="col-md-4 input-icon">

                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="changer_de_prenom"       value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">CHANGEMENT DE PRÉNOM &nbsp &nbsp &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

			 <div class="form-group">

                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom">RENVOYER LE MAIL</label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_name"].' '.$reponse10["first_name"] ?>" readonly /> 
                         </div>
			 
             <div class="col-md-4 input-icon">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="envoyer_code_partenaire" value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse10["id_partenaire"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="p_contact_mail"          value = "<?php echo $reponse20["p_contact_mail"] ?>" />	
		  	              	        <input type="hidden" name="s_sub_category_code"     value = "<?php echo $reponse20["id_services"] ?>" />	
									<input type="hidden" name="s_sub_category"          value = "<?php echo $reponse20["p_sub_category"] ?>" />	
	                                <button type="submit" class="btn btn-sm small btn-circle blue margin-top-10 ">RENVOYER MAIL INSCRIPTION &nbsp &nbsp  <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
			 <?php IF ( $reponse10["is_activated"] == 1 ) {?>
             <div class="form-group">
			 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom">FERMER LE COMPTE</label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_name"].' '.$reponse10["first_name"] ?>" readonly /> 
                         </div>
			 
             <div class="col-md-4 input-icon">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="desinscription_affilie"  value = 1 />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
	                                <button type="submit" class="btn btn-sm small btn-circle red margin-top-10 ">DÉSACTIVER COMPTE AFFILIÉ &nbsp &nbsp &nbsp <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
			 <?php } ELSE {?>
             <div class="form-group">
			 
                         <div class="col-md-3 input-sm margin-top-10">
                         <label class="control-label" for="nom">ACTIVER LE COMPTE</label>   
                         </div>
                         <div class="col-md-5 input-icon margin-top-10">	
                         <i class="fa fa-user"></i>			 
                         <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_name"].' '.$reponse10["first_name"] ?>" readonly /> 
                         </div>
			 
             <div class="col-md-4 input-icon">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="activation_affilie"  value = 1 />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
	                                <button type="submit" class="btn btn-sm small btn-circle red margin-top-10 ">ACTIVER COMPTE AFFILIÉ &nbsp &nbsp &nbsp <i class="fa fa-plus"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>	
			 <?php } ?>

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="form-group">
                            <div class="col-md-3 input-sm margin-top-10">
                                  <label class="control-label" for="nom">SE CONNECTER AU COMPTE</label>   
                            </div>
                        
						    <div class="col-md-5 input-icon margin-top-10">	
                                <i class="fa fa-user"></i>			 
                                <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_name"].' '.$reponse10["first_name"] ?>" readonly /> 
                            </div>
            			
                        <div class="col-md-4 input-icon margin-top-10">
                                 <div class="form-actions right">
                                         <label class="control-label" for="nom"> 				 
			                                 <a class="btn small btn-sm  btn-circle blue  " href='http://www.nosrezo.com/login.php?id_affiliate=<?php echo $id_affiliate ?>&amp;token=<?php echo $mdp ?>' target="_blank" > CONNECTION COMPTE AFFILIÉ &nbsp  <i class="fa fa-refresh"></i> </a>
			                             </label>

                                 </div>	
            			</div>
            			 
            </div>	

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="col-md-12 form-group">
             <hr/>
             </div>					
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">AFFILIÉ DEPUIS LE</label>
                 </div>
                 <div class="col-md-5 input-icon ">
			     <i class="fa fa-calendar"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["creation_date"] ?>" readonly />
                 </div>
                 <div class="col-md-4 input-icon "> 
			     <i class="fa fa-calendar"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php if ($creation_depuis <= 1) {echo 'Moins d\'un jour';} else {echo $creation_depuis.' jours';}  ?>" readonly /> 
                 </div>
             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">LAST CONNECTION</label>
             </div>
             <div class="col-md-5 input-icon">
			 <i class="fa fa-calendar"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["last_connection_date"] ?>" readonly />
             </div>
             <div class="col-md-4 input-icon">
			 <i class="fa fa-calendar"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php if ($connection_depuis <= 1) {echo 'Moins d\'un jour';} else {echo $connection_depuis.' jours';}  ?>" readonly /> 				 					 
             </div>
             </div>
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">JUSTIFICATIFS</label>
             </div>
             <div class="col-md-5 input-icon">
			 <i class="fa fa-file"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php if ($reponse10["is_activated"] == 1)    { echo 'Justificatifs Affilié reçus';} else { echo 'Justificatifs Affilié non reçu';} ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
			 <i class="fa fa-file"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php if ($reponse10["contract_signed"] == 1) { echo 'Contrat Apporteur signé';} else { echo 'Contrat Apporteur non reçu';}   ?>" readonly /> 
			 </div>
             </div>
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="col-md-12 form-group">
             <hr/>
             </div>					
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

                 <div class="form-group">
                     <div class="col-md-3 input-sm">
                     <label class="control-label" for="nom">CODE BANQUE</label>
                     </div>
                     <div class="col-md-9 input-icon ">
			         <i class="fa fa-lock"></i>
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse50["code_banque"] ?>" readonly />
                     </div>
                 </div>
                 <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">NOM BANQUE</label>
                 </div>
                 <div class="col-md-9 input-icon">
			     <i class="fa fa-lock"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse50["nom_banque"] ?>" readonly />
                 </div>
                 </div>
                 <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">CODE GUICHET</label>
                 </div>
                 <div class="col-md-9 input-icon">
			     <i class="fa fa-lock"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php  echo $reponse50["code_guichet"]; ?>" readonly /> 
                 </div>
                 </div>			 
                 <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">NUMÉRO DE COMPTE</label>
                 </div>
                 <div class="col-md-9 input-icon">
			     <i class="fa fa-lock"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php  echo $reponse50["numero_compte"]; ?>" readonly /> 
                 </div>
                 </div>			 
                 <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">CLÉ RIB</label>
                 </div>
                 <div class="col-md-9 input-icon">
			     <i class="fa fa-lock"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php  echo $reponse50["cle_rib"]; ?>" readonly /> 
                 </div>
                 </div>	
			     
                 <div class="form-group">
                     <div class="col-md-3 input-sm">
                         <label class="control-label" for="nom">IBAN</label>
                     </div>
                     <div class="col-md-3 input-icon">
			             <i class="fa fa-lock"></i>
                         <input class="form-control input-sm" type="text" name="IBAN"  value="<?php  echo $reponse50["IBAN"]; ?>" readonly /> 
                     </div>
                     <div class="col-md-6 input-icon">
			             <i class="fa fa-lock"></i>
                         <input class="form-control input-sm" type="text" name="IBAN"  value="<?php  echo DISPLAY_IBAN($reponse50["IBAN"], 4)." avec espace" ?>" readonly /> 
                     </div>
                 </div>

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="col-md-12 form-group">
             <hr/>
             </div>					 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

			 
			 </div> 
			 </div> 
			 </div> 


			 
             <?php 
			 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////////////////////////   PARTENAIRE    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 
			 IF ($reponse10["id_partenaire"] > 0) {  ?> 
			 <div id="tab_2_4" class="tab-pane fade in margin-top-20" >
			 <div class="portlet-body" >
			 <div class="table-responsive" >

            
			<?php 
		     echo '<div class="" >';
				 echo '<ul class="nav nav-tabs">';
				          echo '<li  class="active"> <a href="#tab_partenaire_1" data-toggle="tab"> <i class="fa fa-briefcase"> </i> PARTENAIRE </a></li>';
				          echo '<li ><a href="#tab_partenaire_2" data-toggle="tab"> <i class="fa fa-user"></i> RECOMMANDÉ PAR   </a></li>';						  
				          echo '<li ><a href="#tab_partenaire_3" data-toggle="tab"> <i class="fa fa-bar-chart-o"></i> NOTATION </a></li>';
				 echo '</ul>';
				 echo '<div class="tab-content">';
				 
				 
             ///////////////////////////// tab_partenaire_1 /////////////////////////////////////////////////////////////////////////////////////	 
			 echo '<div id="tab_partenaire_1" class="tab-pane fade in col-md-12 active" >';
			 echo '<div class="portlet-body" >';
			 echo '<div class="table-responsive" >';
            ?> 
			 
			 <div class="margin-right-10" >
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">PARTENAIRE</label>   
             </div>
             <div class="col-md-5 input-icon">
			 <i class="fa fa-file"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_contact"]  ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
			 <i class="fa fa-file"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo "P".$reponse20["id_partner"]  ?>" readonly /> 
			 </div>
             </div>			 
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">CATÉGORIE</label>
                 </div>
                 <div class="col-md-5 input-icon ">
			     <i class="fa fa-globe"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ucfirst($reponse20["p_category"])." - ".$reponse20["p_sub_category"]  ?>" readonly />
                 </div>
                 <div class="col-md-4 input-icon "> 
			     <i class="fa fa-briefcase"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_company"]." - ".$reponse20["p_fonction"]  ?>" readonly /> 
                 </div>
             </div>
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">CONTACT</label>
                 </div>
                 <div class="col-md-5 input-icon">
			     <i class="fa fa-comment-o"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_contact_mail"] ?>" readonly />
                 </div>
                 <div class="col-md-4 input-icon">
			     <i class="fa fa-comment-o"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo DISPLAY_IBAN( $reponse20["p_contact_phone"], 2).' / '.DISPLAY_IBAN( $reponse20["p_contact_phone2"], 2)  ?>" readonly /> 				 					 
                 </div>
             </div>			 

			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">VILLE</label>
                 </div>
                 <div class="col-md-5 input-icon">
			     <i class="fa fa-comment-o"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_zip_code"]." ".$reponse20["p_city"]  ?>" readonly />
                 </div>
                 <div class="col-md-4 input-icon">
			     <i class="fa fa-comment-o"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_rayon"].' Km autour'  ?>" readonly /> 				 					 
                 </div>
             </div>
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm">
                 <label class="control-label" for="nom">ADRESSE</label>
                 </div>
                 <div class="col-md-5 input-icon">
			     <i class="fa fa-file"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_adresse"] ?>" readonly />
                 </div>
                 
                 <div class="col-md-4 input-icon">
			     <i class="fa fa-file"></i>
                 <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["p_lat"].' lat / '.$reponse20["p_long"].' long'  ?>" readonly /> 				 					 
                 </div>
             </div>	

             <div class="form-group">
                  <div class="col-md-3 input-sm">
                  <label class="control-label" for="nom">CONGÉS</label>
                  </div>
                  <div class="col-md-5 input-icon">
			      <i class="fa fa-comment-o"></i>
                  <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo 'DÉBUT : '.$reponse20["date_debut_conges"].' ' ?>" readonly />
                  </div>
                  <div class="col-md-4 input-icon">
			      <i class="fa fa-comment-o"></i>
                  <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo 'FIN : '.$reponse20["date_fin_conges"].' '  ?>" readonly /> 				 					 
                  </div>
             </div>

			 
			 <?php 
			         IF      ($reponse20["is_activated"] == 0) { $statut_partenaitre = "NON ACTIVÉ POUR L'INSTANT"; } 
                     ELSE IF ($reponse20["is_activated"] == 1) { $statut_partenaitre = "ACTIVÉ ET OPÉRATIONNEL"; } 
                     ELSE IF ($reponse20["is_activated"] == 2) { $statut_partenaitre = "DÉSACTIVÉ CAR VA QUITTER IAD"; } 
                     ELSE IF ($reponse20["is_activated"] == 3) { $statut_partenaitre = "PAS ENCORE REPONDU AU QCM"; } 
                     ELSE IF ($reponse20["is_activated"] == 7) { $statut_partenaitre = "LE PARTENAIRE SOUHAITE ÊTRE DÉSACTIVÉ"; } 
                     ELSE IF ($reponse20["is_activated"] == 8) { $statut_partenaitre = "EN VACANCES"; } 
                     ELSE IF ($reponse20["is_activated"] == 9) { $statut_partenaitre = "DÉSACTIVÉ SUR SA PERFORMANCE PAR NOSREZO"; } 
					 
					 IF ( $reponse20["date_debut_conges"] > 0) 
					 { 
	                     $email_partenaire = $reponse20["p_contact_mail"];
						 $sql30          = " SELECT count(iad_nom) as is_exist, iad_prenom, iad_id_parrain, iad_phone, iad_email, iad_id, iad_cp, iad_ville, iad_date_debut_iad , email_remplacant, id_part_nr_replacant
				                             FROM partner_iad 
										     WHERE  trim(iad_email)    = trim(\"$email_partenaire\")   limit 0,1     ";            
					     $result30       = mysql_query($sql30) or die(" A - Requete pas comprise #122");
					     $reponse30      = mysql_fetch_array($result30);
						 
			 ?>	
						 
             <div class="form-group">
                  <div class="col-md-3 input-sm">
                  <label class="control-label" for="nom">REMPLACANT</label>
                  </div>
                  <div class="col-md-5 input-icon">
			      <i class="fa fa-comment-o"></i>
                  <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse30["email_remplacant"] ?>" readonly />
                  </div>
                  <div class="col-md-4 input-icon">
			      <i class="fa fa-comment-o"></i>
                  <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo 'ID NR PARTENAIRE P'.$reponse30["id_part_nr_replacant"]  ?>" readonly /> 				 					 
                  </div>
             </div>							 

			 <?php 						 
					 }					 
			 ?>	

			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom"> MODIFIER VILLE </label>   
             </div>	
             
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
             <div class="col-md-1 margin-top-10">
                  <input class="form-control input-sm" type="text" name="p_zip_code"  value= "<?php echo $reponse20["p_zip_code"] ?>" /> 
             </div>
			 
             <div class="col-md-2 margin-top-10">
                  <input class="form-control input-sm" type="text" name="p_city"  value= "<?php echo $reponse20["p_city"] ?>" /> 
             </div>	

             <div class="col-md-2 margin-top-10">
                  <input class="form-control input-sm" type="text" name="pays_du_partenaire"  value="France" placeholder="Portugal" /> 
             </div>	


			 
			 <div class="col-md-3 input-icon margin-top-10 input-sm">
			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"          value = 1 />
                                    <input type="hidden" name="maj_ville_du_partenaire"    value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle blue  ">METTRE À JOUR VILLE PARTENAIRE &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>
			 
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom">RAYON D'ACTION</label>   
             </div>	
             
			 <form action="NosRezo12345678912.php" id="form_sample_33"  method="post"> 
			 
             <div class="col-md-1 margin-top-10">
                  <input class="form-control input-sm" type="text" name="p_zip_code"  readonly value= "<?php echo $reponse20["p_rayon"].' km' ?>" /> 
             </div>
			 
             <div class="col-md-4  margin-top-10">
                                                     <select class='form-control input-sm' name='p_rayon_secteur' >
                                                           <option value = 0 ;      <?php IF ( $reponse20["p_rayon"]  == 0)    {echo" selected='selected' ";}  ?> > 0 km </option>
                                                           <option value = 5;       <?php IF ( $reponse20["p_rayon"]  == 5)   {echo" selected='selected' ";}  ?> > 5 km </option>	
                                                           <option value = 10 ;     <?php IF ( $reponse20["p_rayon"]  == 10)    {echo" selected='selected' ";}  ?> > 10 km </option>	
                                                           <option value = 15 ;     <?php IF ( $reponse20["p_rayon"]  == 15)    {echo" selected='selected' ";}  ?> > 15 km </option>	
                                                           <option value = 20 ;     <?php IF ( $reponse20["p_rayon"]  == 20)    {echo" selected='selected' ";}  ?> > 20 km </option>	
                                                           <option value = 25 ;     <?php IF ( $reponse20["p_rayon"]  == 25)    {echo" selected='selected' ";}  ?> > 25 km </option>	
                                                           <option value = 30 ;     <?php IF ( $reponse20["p_rayon"]  == 30)    {echo" selected='selected' ";}  ?> > 30 km </option>	
                                                           <option value = 50 ;     <?php IF ( $reponse20["p_rayon"]  == 50)    {echo" selected='selected' ";}  ?> > 50 km </option>	
                                                           <option value = 150 ;    <?php IF ( $reponse20["p_rayon"]  == 150)    {echo" selected='selected' ";}  ?> > 150 km </option>	
                                                           <option value = 300 ;    <?php IF ( $reponse20["p_rayon"]  == 300)    {echo" selected='selected' ";}  ?> > 300 km </option>	
                                                           <option value = 1000 ;   <?php IF ( $reponse20["p_rayon"]  == 1000)    {echo" selected='selected' ";}  ?> > 1000 km </option>								   
	
													</select>
             </div>
			 <div class="col-md-4 input-icon margin-top-10 input-sm">
			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_rayon_partenaire"     value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle blue  ">MODIFIER RAYON D'ACTION &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </div>
			 </form>
			 
             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

			 
			 
             <div class="form-group">
                     <div class="col-md-3 input-sm margin-top-10">
                     <label class="control-label" for="nom">STATUT PARTENAIRE </label>   
                     </div>
                     <div class="col-md-5 input-icon margin-top-10">
			         <i class="fa fa-file"></i>
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse20["is_activated"].' - '.$statut_partenaitre ?>"  readonly /> 
                     </div>
			         

			         <div class="col-md-4 input-icon input-sm margin-top-10">
			         <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 			         
                                            <div class="form-actions right">
											<input type="hidden" name="action_a_realiser"       value = 1 />
                                            <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                            <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			          	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                            <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                        <?php IF ( $reponse20["is_activated"] <> 1 )
											{	?>
											<input type="hidden" name="activer_partenaire"      value = 1 />
											<button type="submit" class="btn small btn-sm  btn-circle green  ">ACTIVER DANS ALGORITHME &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
 	                                        <?php }
											ELSE
											{	?>
                                            <input type="hidden" name="desactiver_partenaire"   value = 1 />
	                                        <button type="submit" class="btn small btn-sm  btn-circle red  ">DÉSACTIVER DE L'ALGORITHME &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>

  	                                        <?php } ?>
											</div>
			         </form>
			         </div>
             </div>

<?php IF ( $reponse20["is_access_intranet"] == 1 )
		{	?>		 
             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom">ACCÈS INTRANET </label>   
             </div>
             <div class="col-md-5 input-icon margin-top-10">
			 <i class="fa fa-file"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php if ($reponse20["is_access_intranet"] == 1) {echo 'OK - pour mise à jour recommandations';}   else {echo ' Accès BLOQUÉ au Partenaire';}  ?>" readonly /> 
             </div>
			 
			 <div class="col-md-4 input-icon input-sm margin-top-10">
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="access_intranet"         value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle red  ">BLOQUER ACCÉS PARTENAIRE &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </form>
			 </div>
             </div>
		<?php } ?>				 

		
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom">MAIL PARTENAIRE</label>   
             </div>	
             
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 
             <div class="col-md-5 input-icon margin-top-10">
			 <i class="fa fa-envelope"></i>
             <input class="form-control input-sm" type="text" name="p_contact_mail"  value= "<?php echo $reponse20["p_contact_mail"] ?>" /> 
             </div>
			 <div class="col-md-4 input-icon margin-top-10 input-sm">
			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_mails"               value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle blue  ">METTRE À JOUR MAIL &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </form>
			 </div>
			 
             </div>
			 
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 
             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom">NOM ENTREPRISE</label>   
             </div>	
             
			 <form action="NosRezo12345678912.php" id="form_sample_33"  method="post"> 
             <div class="col-md-5 input-icon margin-top-10">
			 <i class="fa fa-globe"></i>
             <input class="form-control input-sm" type="text" name="p_company_new"  value= "<?php echo $reponse20["p_company"] ?>" /> 
             </div>
			 <div class="col-md-4 input-icon margin-top-10 input-sm">
			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_nom_entreprise"      value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle blue  ">CHANGER NOM ENTREPRISE &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </div>
			 </form>
			 
             </div>
			 
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 
             <div class="form-group">
                 <div class="col-md-3 input-sm margin-top-10">
                 <label class="control-label" for="nom">TÉLÉPHONE 2</label>   
                 </div>	
             
			     <form action="NosRezo12345678912.php" id="form_sample_33"  method="post"> 
                 <div class="col-md-5 input-icon margin-top-10">
			     <i class="fa fa-phone"></i>
                 <input class="form-control input-sm" type="text" name="p_contact_phone2"  value= "<?php echo $reponse20["p_contact_phone2"] ?>" /> 
                 </div>
			     <div class="col-md-4 input-icon margin-top-10 input-sm">
			     
                                     <div class="form-actions right">
                                        <input type="hidden" name="action_a_realiser"       value = 1 />
                                        <input type="hidden" name="maj_tel_2"               value = 1 />
                                        <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                        <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			      	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                        <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                    <button type="submit" class="btn small btn-sm  btn-circle blue  ">AJOUTER TÉLÉPHONE 2 &nbsp &nbsp &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                     </div>
			     </div>
			     </form>
			 
             </div>
			 
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 
<?php
								 
						 echo '<div class="form-group">';
                         echo '<div class="col-md-3 input-sm margin-top-10"><label class="control-label" for="nom">CHANGEMENT SERVICE </label>';	   
						 echo '</div>';
						 echo '<form action="NosRezo12345678912.php" id="form_sample_33"  method="post">';						 
						 echo "<div class='col-md-5 margin-top-10'>";
						 echo "<select class='form-control input-sm' name='id_services' >";
						 echo "<option value='1'>-- Toutes catégories -- </option>"; 
		
                         $sql_services    = " SELECT s_category, s_sub_category, id_services FROM services WHERE is_activated =1 ORDER BY master_order_affichage, order_affichage";
                         $result_services = mysql_query($sql_services) or die("Requete pas comprise #azercf2");
						     $master_category_1 = "";
						     $master_category_2 = "";
		
                                WHILE ($row=mysql_fetch_array($result_services)) { 
						               $master_category_1 = $row[0];
						  	         IF ($master_category_1 <> $master_category_2) 
						  	         {
						  	          echo" <option value=".$row[2]." style='background:#4b8df8; color:#FFFFFF;' >".strtoupper($row[0])."</option>"; 
						  	         }						 
						                echo" <option value=".$row[2]." ; ";
					                    IF ($reponse20["id_services"] == $row[2]) {echo" selected='selected' ";}
					                    echo" > &nbsp ".$row[1]."</option>"; 
						  	            $master_category_2 = $row[0];
						  	     }
                                echo" </select>";	
						        
						        echo" </div>";	
?>							 
			                     <div class="col-md-4 input-icon input-sm margin-top-10 ">
                                                     <div class="form-actions right">
                                                        <input type="hidden" name="action_a_realiser"       value = 1 />
                                                        <input type="hidden" name="maj_service"             value = 1 />
                                                        <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                                        <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			                      	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                                        <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                                    <button type="submit" class="btn small btn-sm  btn-circle blue ">MODIFIER LE SERVICE &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                                     </div>
			                     </div>
			                     </form>						 

						  </div>	



			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="form-group">
             <div class="col-md-3 input-sm margin-top-10">
             <label class="control-label" for="nom">NOTE INTERNE PARTENAIRE</label>   
             </div>	
             
			 <form action="NosRezo12345678912.php" id="form_sample_33"  method="post"> 
             <div class="col-md-5  margin-top-10">
                                                     <select class='form-control input-sm' name='p_note_partenaire' >
                                                           <option value = 10;     <?php IF ($_POST['p_note_partenaire'] == 10)   {echo" selected='selected' ";}  ?> > 10/10 - Note interne NR </option>	
                                                           <option value = 9 ;     <?php IF ($_POST['p_note_partenaire'] == 9)    {echo" selected='selected' ";}  ?> > 9/10 - Note interne NR </option>	
                                                           <option value = 8 ;     <?php IF ($_POST['p_note_partenaire'] == 8)    {echo" selected='selected' ";}  ?> > 8/10 - Note interne NR </option>	
                                                           <option value = 7 ;     <?php IF ($_POST['p_note_partenaire'] == 7)    {echo" selected='selected' ";}  ?> > 7/10 - Note interne NR </option>	
                                                           <option value = 6 ;     <?php IF ($_POST['p_note_partenaire'] == 6)    {echo" selected='selected' ";}  ?> > 6/10 - Note interne NR </option>	
                                                           <option value = 5 ;     <?php IF ($_POST['p_note_partenaire'] == 5)    {echo" selected='selected' ";}  ?> > 5/10 - Note interne NR </option>	
                                                           <option value = 4 ;     <?php IF ($_POST['p_note_partenaire'] == 4)    {echo" selected='selected' ";}  ?> > 4/10 - Note interne NR </option>	
                                                           <option value = 3 ;     <?php IF ($_POST['p_note_partenaire'] == 3)    {echo" selected='selected' ";}  ?> > 3/10 - Note interne NR </option>	
                                                           <option value = 2 ;     <?php IF ($_POST['p_note_partenaire'] == 2)    {echo" selected='selected' ";}  ?> > 2/10 - Note interne NR </option>	
                                                           <option value = 1 ;     <?php IF ($_POST['p_note_partenaire'] == 1)    {echo" selected='selected' ";}  ?> > 1/10 - Note interne NR </option>								   
                                                           <option value = 0 ;     <?php IF ($_POST['p_note_partenaire'] == 0)    {echo" selected='selected' ";}  ?> > Pas de Note interne NR </option>	
													</select>
             </div>
			 <div class="col-md-4 input-icon margin-top-10 input-sm">
			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="maj_note_partenaire"     value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                <button type="submit" class="btn small btn-sm  btn-circle blue  ">MODIFIER NOTE INTERNE &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                 </div>
			 </div>
			 </form>
			 
             </div>
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="form-group">
                 <div class="col-md-3 input-sm margin-top-10">
                 <label class="control-label" for="nom">COMMENTAIRE INTERNE</label>   
                 </div>	
             
			     <form action="NosRezo12345678912.php" id="form_sample_33"  method="post"> 
                 <div class="col-md-5 margin-top-10">
				 
				                    <textarea class="form-control input-sm" rows="6" maxlength="1500" data-parsley-required="true"  name="commentaire_interne" placeholder="<?php echo $reponse20["commentaire_interne"]; ?>"><?php echo $reponse20['commentaire_interne'] ?></textarea>

                 </div>
			     <div class="col-md-4 input-icon margin-top-10 input-sm">
			     
                                     <div class="form-actions right">
                                        <input type="hidden" name="action_a_realiser"       value = 1 />
                                        <input type="hidden" name="maj_commentaire_interne" value = 1 />
                                        <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                        <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			      	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                        <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
	                                    <button type="submit" class="btn small btn-sm  btn-circle blue  ">AJOUTER COMMENTAIRE &nbsp &nbsp &nbsp &nbsp &nbsp <i class="fa fa-refresh"></i></button>
                                     </div>
			     </div>
			     </form>
			 
             </div>

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
						  
		
			 		 
			 </div>  
			 
			 
			 

			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="col-md-12 form-group margin-top-10">
             <hr/>
             </div>					
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
			 

             

<?php  IF ( $reponse20["id_services"] <> 1 )
{/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
         <div class=" col-md-12" >
		 
			 
		<form action="NosRezo12345678912.php" id="form_sample_3" class="form-horizontal" method="post"> 
 
         <div class=" col-md-12 note note" > 
			 <div class="form-group">
			     <div class="col-md-12">
				         <div class="col-md-2 input-sm margin-top-10">  <label class="control-label" for="nom">CONTRAT </label>   </div>
				         <div class="col-md-5 radio-list margin-top-10" data-error-container="#form_2_membership_error" name="p_contrat_recu" >
				             <label> <input type="radio" name="p_contrat_recu" value="1" <?php if ($reponse20["p_contrat_recu"] == "1") echo 'checked'; ?> /> Oui - Contrat NR reçu</label>
				             <label> <input type="radio" name="p_contrat_recu" value="0" <?php if ($reponse20["p_contrat_recu"]  == "0") echo 'checked'; ?> /> Non - Contrat NR non reçu </label>
				         </div>

				</div>
             </div>	
		 </div>	

         <div class=" col-md-12 note note" > 			 
             <div class="form-group">
			     <div class="col-md-12 ">
				         <div class="col-md-2 input-sm margin-top-10">  <label class="control-label" for="nom">KBIS SOCIÉTÉ </label>   </div>
				         <div class="col-md-5 radio-list margin-top-10" data-error-container="#form_2_membership_error" name="p_Kbis_recu" >
				              <label> <input type="radio" name="p_Kbis_recu" value="1" <?php if ($reponse20["p_kbis_recu"] == "1") echo 'checked'; ?> /> Oui - Kbis reçu</label>
				              <label> <input type="radio" name="p_Kbis_recu" value="0" <?php if ($reponse20["p_kbis_recu"]  == "0") echo 'checked'; ?> /> Non - Kbis non reçu </label>
				         </div>
						 <div class="col-md-5">
						 	<div class="col-md-12 input-sm">  <label class="control-label" for="nom"> <i>Date de relance KBIS avant désactivation </i> </label>   </div>
							<div class="col-md-12 input-group input-medium date date-picker margin-top-10" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
						 		<input class="form-control margin-top-10" readonly type="text" name="date_relance_kbis" value="<?php echo $reponse20["date_relance_assurance"] ?>" > 
						 		<span class="input-group-btn margin-top-10"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button> </span>
						 	</div>											
						 </div>
				</div>
             </div>	
		 </div>	

		 
         <div class=" col-md-12 note note" > 	
             <div class="form-group">
			     <div class="col-md-12 ">
				         <div class="col-md-2 input-sm margin-top-10">  <label class="control-label" for="nom">ASSURANCE </label>   </div>
 						 <div class="col-md-5 radio-list margin-top-10" data-error-container="#form_2_membership_error" name="p_assurance_recu" >
				             <label> <input type="radio" name="p_assurance_recu" value="1" <?php if ($reponse20["p_assurance_recu"] == "1") echo 'checked'; ?> /> Oui - Assurance reçu</label>
				             <label> <input type="radio" name="p_assurance_recu" value="0" <?php if ($reponse20["p_assurance_recu"]  == "0") echo 'checked'; ?> /> Non - Assurance non reçu </label>
				         </div>
						 <div class="col-md-5">
						 	<div class="col-md-12 input-sm">  <label class="control-label" for="nom"> <i>Date de relance assurance avant désactivation </i> </label>   </div>
							<div class="col-md-12 input-group input-medium date date-picker margin-top-10" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
						 		<input class="form-control margin-top-10" readonly type="text" name="date_relance_assurance" value="<?php echo $reponse20["date_relance_kbis"] ?>" > 
						 		<span class="input-group-btn margin-top-10"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button> </span>
						 	</div>											
						 </div>

				</div>
             </div>
		 </div>	

         <div class=" col-md-12 note note" > 	
			 
             <div class="form-group">
			     <div class="col-md-12 ">
                    <input type="hidden" name="action_a_realiser"       value = 1 />
                    <input type="hidden" name="maj_documents"           value = 1 />
                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
					<input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
					

	                        <button type="submit" class="btn small btn-sm  btn-circle blue">METTRE À JOUR RÉCEPTION DOCUMENTS &nbsp <i class="fa fa-plus"></i></button>
				</div>
             </div>
		 </div>
				
	    </form>
			
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 

             <div class="col-md-12 form-group">
             <hr/>
             </div>					
			 
			 <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
			 

			 
		</div> 	 
<?php } /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

			 echo '</div>'; 
			 echo '</div>'; 
			 echo '</div>';	
			 
             ///////////////////////////// TAB 2_3  /////////////////////////////////////////////////////////////////////////////////////	 
			 echo '<div id="tab_partenaire_2" class="tab-pane fade in col-md-12" >';
			 echo '<div class="portlet-body" >';
			 echo '<div class="table-responsive" >';	
?>	
			 
             <div class="col-md-12 note note-info margin-right-10" >

             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Part. Recommandé par</label>
             </div>
             <div class="col-md-5 input-icon">	
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse33["first_name"].' '.($reponse33["last_name"]) ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo 'ID Affilié : A'.$reponse33["id_affiliate"]?>" readonly /> 
             </div>
             </div>
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Adresse</label>
             </div>
             <div class="col-md-5 input-icon">
			 <i class="fa fa-location-arrow"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse33["address"]) ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
			 <i class="fa fa-globe"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse33["zip_code"]).' '.($reponse33["city"])  ?>" readonly /> 
             </div>
             </div>
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Contact</label>
             </div>
             <div class="col-md-5 input-icon">
			 <i class="fa fa-envelope"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse33["email"]) ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
			 <i class="fa fa-phone"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo ($reponse33["phone_number"])  ?>" readonly /> 
             </div>
             </div>
			 
			 </div>
			 
			 <?php 
			 echo '</div>'; 
			 echo '</div>'; 
			 echo '</div>';	
			 
             ///////////////////////////// tab_partenaire_3  /////////////////////////////////////////////////////////////////////////////////////	 
			 echo '<div id="tab_partenaire_3" class="tab-pane fade in col-md-12" >';
			 echo '<div class="portlet-body" >';
			 echo '<div class="table-responsive" >';


	                     $sql222          = "SELECT nb_interventions, percent_satisfaction, Total_points_algo, points_nosrezo, points_last_compromis, points_affiliate_niveau1, points_last_compromis_12, update_time, Explication 
						                     FROM partner_notation pn 
						                     WHERE pn.id_partner_notation = ".$reponse10["id_partenaire"]."    limit 0,1     ";            
					     $result222       = mysql_query($sql222) or die(" A - Requete pas comprise #122");
					     $reponse222      = mysql_fetch_array($result222);	
						 $recommanded_by = $reponse20["recommanded_by"];


                         $reponse222["Explication"]  = str_replace("<br/>", "\n", $reponse222["Explication"]);	
			 
			 ?>

			 
			 
             <div class="col-md-12 note note-info margin-right-10" >

             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Points total </label>
             </div>
             <div class="col-md-5 input-icon">	
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["Total_points_algo"]." points au total" ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["update_time"]?>" readonly /> 
             </div>
             </div>
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Points note NosRezo </label>
             </div>
             <div class="col-md-5 input-icon">	
             <i class="fa fa-location-arrow"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["points_nosrezo"]." points" ?>" readonly /> 
             </div>
             <div class="col-md-4 input-icon">
             <i class="fa fa-user"></i>			 
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["percent_satisfaction"]." % satisfaction" ?>" readonly /> 
             </div>
             </div>
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Points Date Last compromis</label>
             </div>
             <div class="col-md-9 input-icon">
			 <i class="fa fa-location-arrow"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["points_last_compromis"]." points" ?>" readonly /> 
             </div>
             </div>
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Points Last Compromis 12</label>
             </div>
             <div class="col-md-9 input-icon">
			 <i class="fa fa-location-arrow"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["points_last_compromis_12"]." points" ?>" readonly /> 
             </div>
             </div>
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Points Affiliate L1</label>
             </div>
             <div class="col-md-9 input-icon">
			 <i class="fa fa-location-arrow"></i>
             <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse222["points_affiliate_niveau1"]." points" ?>" readonly /> 
             </div>
             </div>			 
			 
             <div class="form-group">
             <div class="col-md-3 input-sm">
             <label class="control-label" for="nom">Explication</label>
             </div>
             <div class="col-md-9 input-icon">
			 <i class="fa fa-location-arrow"></i>
			 <textarea class="form-control input-sm" rows="6" readonly name="commentaires"><?php echo $reponse222["Explication"]  ?></textarea>
            
			 </div>
             </div>			 			 
			 
			 </div>			 
			 

			 
            <?php
			 echo '</div>'; 
			 echo '</div>'; 
			 echo '</div>';	

			 echo '</div>'; 
			 echo '</div>'; 
			 
			
			?>			
			 </div>
			 </div>			
			 </div>
             <?php } 
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////// RECOMMANDATIONS ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

	                 ////////////////////////////////////// REQUÊTE DE REMPLISSAGE DES RECOMMANDATIONS               
		             $result11     = mysql_query("SELECT * FROM recommandation_details where id_affiliate = ".$id_affiliate."  and r_status <> 0 and r_status <> 9 ") or die("Requete pas comprise #19A2789");
		             $reco_active  = mysql_num_rows($result11);
					 
		             $result12     = mysql_query("SELECT * FROM recommandation_details where id_affiliate = ".$id_affiliate."  and r_status = 0 ") or die("Requete pas comprise #19B2789");
					 $reco_annule  = mysql_num_rows($result12);
					 
		             $result13     = mysql_query("SELECT * FROM recommandation_details where id_affiliate = ".$id_affiliate."  and r_status = 9 ") or die("Requete pas comprise #19A2789");
		             $reco_payee   = mysql_num_rows($result13);				 
			 
			 
	$sql_reco_aff    = " SELECT r_status, r_creation_date, id_recommandation, r_sub_category, r_first_name, r_last_name, r_status, r_gain, r_managed_date, id_privileged_partner, r_zip_code, r_city 
	                     FROM recommandation_details 
			             where id_affiliate=".$id_affiliate." 
			             order by id_recommandation desc   ";               
    $result_reco_aff = mysql_query($sql_reco_aff) or die("Requete pas comprise !");			 
			 
			 
			 
			 ?>


			 <div id="tab_2_2" class="tab-pane fade in col-md-12 margin-top-20" >
			 <div class="portlet-body" >
			 <div class="table-responsive" >	


                     <div class="col-md-12 form-group">
                         <div class="col-md-4 input-icon">
			             <i class="fa fa-bookmark-o"></i>
                         <input class="form-control input-sm" type="text" name="affilie" value="<?php echo $reco_active.' '.SING_PLUR("ACTIVE", $reco_active, 1) ?>" readonly /> 
                         </div>
                     <div class="col-md-4 input-icon">
			             <i class="fa fa-bookmark-o"></i>
                         <input class="form-control input-sm" type="text" name="affilie" value="<?php echo $reco_payee.' '.SING_PLUR("PAYÉE", $reco_payee, 1) ?>" readonly /> 
			         </div>
                     <div class="col-md-4 input-icon">
			             <i class="fa fa-bookmark-o"></i>
                         <input class="form-control input-sm" type="text" name="affilie" value="<?php echo $reco_annule.' '.SING_PLUR("ANNULÉE", $reco_annule, 1) ?>" readonly /> 		 
			             </div>
                     </div>
<?php 
				  echo '<div class="col-md-12 portlet-body margin-top-10 " >';
				  echo '<div class="col-md-12 table-responsive" >';
				  echo '<table class="table table-striped  table-advance table-hover">'."\n";
				  
                    // PREMIÈRE LIGNE ON AFFICHE UN EN-TÊTE DIFFÉRENT
					 echo '<thead>';
				     $background_color = '#4b8df8';
				     $font_color = '#FFFFFF';
                     echo '<tr>';
					 echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-tag"></i> ID  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-tag"></i> '.T_("CATÉGORIE").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-user"></i> '.T_("NOM").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-globe"></i> '.T_("VILLE").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-star"></i> '.T_("ÉTAPE").'   </th>'; 					 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-money"></i> '.T_("GAINS POTENTIEL ").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-money"></i> '.T_("GAINS BRUT").'   </th>'; 
					 echo '</thead>';      
                     echo '</tr>'."\n";
				   			   
				   $lien_notation       = 0;
                   $lien_recommandation = 0;				   
                   WHILE ($reponse = mysql_fetch_array($result_reco_aff))
                        {                                
                             echo '<tr>'; 					    
							 $lien_notation = $lien_notation + 1;
                             $lien_recommandation = $lien_recommandation + 1;
                         								
                             echo '<td style="text-align:center;" >R'.$reponse["id_recommandation"].'</td>'; 
							 echo '<td style="text-align:center;" >'.$reponse["r_sub_category"].'</td>';                                                                                                                                                               
						 	 echo '<td style="text-align:center;" >'.$reponse["r_last_name"].' '.$reponse["r_first_name"].'</td>'; 
                             echo '<td style="text-align:center;" >'.$reponse["r_zip_code"].' '.$reponse["r_city"].'</td>';  							 
						     echo '<td style="text-align:center;" >'.$reponse["r_status"].'</td>';
                             echo '<td style="text-align:center;" >'.round($reponse["r_gain"]*60 /100 , 1, PHP_ROUND_HALF_DOWN).' €</td>';
							 
							 IF ($reponse["r_status"] > 7 )
							 {
							     echo '<td style="text-align:center;" >'.round($reponse["r_gain"]*60 /100 , 1, PHP_ROUND_HALF_DOWN).' €</td>';
                             }
							 ELSE
							 {
							     echo '<td style="text-align:center;" >0 €</td>';                    
                             }							 


							 
						     echo '</tr>'."\n";
           				}
                   echo"</table>";
				   
				   
      	         echo ' </div> ';
		         echo ' </div> ';




?>					
			 </div>
			 </div>			
			 </div>
			 
             <?php  
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 /////////////////////////////     ARBORESCENCE NR  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
			 
			 
			 
			 <div id="tab_2_3" class="tab-pane fade in col-md-12 margin-top-20" >
			 <div class="portlet-body" >
			 <div class="table-responsive" >	


<?php 
                     $id_parrain_niveau_1  = return_id_parrain($id_affiliate);
					 $parrain_niveau_1     = (nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_1)); 
					 
					 $id_parrain_niveau_2  = return_id_parrain($id_parrain_niveau_1);
					 $parrain_niveau_2     = (nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_2)); 
					 
					 $id_parrain_niveau_3  = return_id_parrain($id_parrain_niveau_2);
					 $parrain_niveau_3     = (nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_3)); 

					 $id_parrain_niveau_4  = return_id_parrain($id_parrain_niveau_3);
					 $parrain_niveau_4     = (nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_4)); 

					 $id_parrain_niveau_5  = return_id_parrain($id_parrain_niveau_4);
					 $parrain_niveau_5     = (nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_5)); 

					 $id_parrain_niveau_6  = return_id_parrain($id_parrain_niveau_5);
					 $parrain_niveau_6     = nom_prenom_id_parrain_affilie($connection_database, $id_parrain_niveau_6); 
?>	


			 			 
			 <div class="col-md-12 note note-info margin-right-10" >
			 
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 6 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>				 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_6; ?>" readonly /> 
                 </div>
             </div>				 
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 5 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_5; ?>" readonly /> 
                 </div>
             </div>	
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 4 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_4; ?>" readonly /> 
                 </div>
             </div>	
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 3 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_3; ?>" readonly /> 
                 </div>
             </div>				 
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 2 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_2; ?>" readonly /> 
                 </div>
             </div>
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">PARRAIN NIVEAU 1 &nbsp <i class="fa fa-level-down"></i>   </label>
                 </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $parrain_niveau_1; ?>" readonly /> 
                 </div>
             </div>
 
			 </div>
			 
             <div class="col-md-12 note note-info margin-right-10" >

             <div class="form-group">
             <div class="col-md-3">
             <label class="control-label" for="nom">AFFILIÉ NOSREZO</label>
             </div>
                 <div class="col-md-9 input-icon">	
                 <i class="fa fa-user"></i>					 
                     <input class="form-control input-sm" type="text" name="affilie"  value="<?php echo $reponse10["first_name"].' '.$reponse10["last_name"].' [ID : '. $id_affiliate.']' ?>" readonly /> 
                 </div>
             </div>
			 </div>
			 
             <div class="col-md-12 margin-right-10" >
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">FILLEULS NIVEAU 1 &nbsp <i class="fa fa-level-down"></i>  </label>
                 </div>
             </div>
             </div>		 
			
			 <?php
   
             	 // REQUETTE DE REMPLISSAGE DU TABLEAU 
				 
                	$result = $connection_database->query( " SELECT  ".REQUETE_AFF_DETAILS_CHAMPS($id_affiliate, 0)." 
				                            FROM   affiliate_details ad, affiliate af 
										    WHERE  ad.id_affiliate = af.id_affiliate  
										    and    af.id_upline    = ".$id_affiliate."    ");
                	
                    $nb_equipe_level = $result->rowCount();

						
				 $result_3 = mysql_query("SELECT id_recommandation, r_gain FROM recommandation_details where r_status > 0 and r_status < 9 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ") or die("Requete pas comprise - #4Z1! ");

				 
	             echo '<div class="col-md-12">';
				 echo '<div class="portlet-body" >';
				 echo '<div class="table-responsive" >';
				 echo '<table class="table  table-advance table-hover">'."\n";
							IF ($nb_equipe_level > 0)
             				{
                                echo '<thead>';
								$background_color = '#4b8df8';
            	                $font_color = '#FFFFFF';
							   	echo '<tr>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-user"></i> PRÉNOM</th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-user"></i> NOM</th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " > ID</th>';
								echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " > <i class="fa fa-envelope"></i> E-MAIL </th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-phone"></i> TÉL</th>';
             				    echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-tasks"></i> RECO</th>';  
             				    echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-users"></i> FILLEULS L2</th>';   
             				    echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-users"></i> FILLEULS L3</th>';   

                                echo '</tr>'."\n";
								echo '</thead>';
									                                 								 
                                 while (   $reponse = $result->fetch(PDO::FETCH_ASSOC)  )
                                     {                                
                                          echo '<tr>'; 					    
										  $level_3 = 0;
							 
             	                          // REQUETTE DE REMPLISSAGE DU TABLEAU 
                                          $result_2   = mysql_query("SELECT id_recommandation, r_gain FROM recommandation_details where r_status > 0 and r_status < 9 and id_affiliate=".$reponse['id_affiliate']." ") or die("Requete pas comprise - #4Z1! ");
										  $result_2_1 = mysql_query("SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$reponse['id_affiliate']." ") or die("Requete pas comprise - #1ZEJ! ");
                                              while ($reponse_2_1 = mysql_fetch_array($result_2_1))
                                              { 
										       $result_2_2 = mysql_query("SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$reponse_2_1['id_affiliate']." ") or die("Requete pas comprise - #1ZEAAJ! ");											  
											   $level_3 = $level_3 + mysql_num_rows($result_2_2);
											  }
                                          echo '<td>'.($reponse["first_name"]).'</td>';
                                          echo '<td>'.($reponse["last_name"]).'</td>';                  
                                          echo '<td>'.$reponse["id_affiliate"].'</td>'; 
										  echo '<td>'.$reponse["email"].'</td>';
                                          echo '<td style="text-align:center;">'.$reponse["phone_number"].'</td>';
						                  echo '<td style="text-align:center;">'.mysql_num_rows($result_2).'</td>';
						                  echo '<td style="text-align:center;">'.mysql_num_rows($result_2_1).'</td>';
						                  echo '<td style="text-align:center;">'.$level_3.'</td>';
							 
						                  echo '</tr>'."\n";
           				             }
				              }	
							  echo"</table>";
	              echo ' </div> ';
				  echo ' </div> ';
				  echo ' </div> ';	
				 			  


             ?>				 
			 </div>			 
			 </div>
			 </div>	
             <!---------------------------------------------------------------------------------------------------------------->
			 <div id="tab_2_5" class="tab-pane fade in col-md-12 margin-top-20" >
			 <div class="portlet-body" >
			 <div class="table-responsive" >

             <div class="col-md-12 note note-info margin-right-10" >
             <div class="form-group">
                 <div class="col-md-3">
                     <label class="control-label" for="nom">FILLEULS IAD &nbsp <i class="fa fa-level-down"></i>  </label>
                 </div>
             </div>
             </div>		 
			
			 <?php
				            
	             echo '<div class="col-md-12">';
				 echo '<div class="portlet-body" >';
				 echo '<div class="table-responsive" >';
				 echo '<table class="table table-striped table-bordered table-advance table-hover">'."\n";
                                echo '<thead>';
								$background_color = '#4b8df8';
            	                $font_color = '#FFFFFF';
							   	echo '<tr>';
             				    echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-tasks"></i> NIVEAU</th>'; 
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-user"></i> PRÉNOM </th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-user"></i> NOM </th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " > ID NR</t>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " > ID IAD PARRAIN</th>';
								echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " > <i class="fa fa-envelope"></i> E-MAIL </th>';
                                echo '<th style="text-align:center; background-color:'.$background_color.' ; color:'.$font_color.' " ><i class="fa fa-phone"></i> TÉL</th>';    

                                echo '</tr>'."\n";
								echo '</thead>';

             	                 // REQUETTE DE REMPLISSAGE DU TABLEAU 
                                 List($result, $niveau)   = EQUIPE_IAD("", $reponse20["p_contact_mail"], $reponse20["p_contact_phone"], 1); 								
                                 while ($reponse = mysql_fetch_array($result))
                                     {                                
                                          echo '<tr>'; 	
                                          echo '<td style="text-align:center;">'.$niveau.'</td>';
                                          echo '<td style="text-align:center;">'.$reponse["iad_prenom"].'</td>'; 
                                          echo '<td style="text-align:center;">'.$reponse["iad_nom"].'</td>';                 
                                          echo '<td style="text-align:center;">'.$reponse["iad_id"].'</td>'; 
                                          echo '<td style="text-align:center;">'.$reponse["iad_id_parrain"].'</td>'; 
										  echo '<td style="text-align:center;">'.$reponse["iad_email"].'</td>';
                                          echo '<td style="text-align:center;">'.$reponse["iad_phone"].'</td>';
						                  echo '</tr>'."\n";
           				             }
							  echo"</table>";
	              echo ' </div> ';
				  echo ' </div> ';
				  echo ' </div> ';	

             ?>				 

			 </div>			 
			 </div>
			 </div>	

             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			 
			 <div id="tab_2_6" class="tab-pane fade in col-md-12 margin-top-20" >
			 <div class="portlet-body" >
			 <div class="table-responsive" >

             <div class="col-md-12 note note-info margin-right-10" >
             <div class="form-group">
                 <div class="col-md-12">
                     <label class="control-label" for="nom">MODULE DE TRANSFERT DE FILLEUL DE NIVEAU 1 : </label> <br/> <br/>
                 </div>
             </div>
			 
			
			 <form action="NosRezo12345678912.php" id="form_sample_3"  method="post"> 			 
                                 <div class="form-actions right">
                                    <input type="hidden" name="action_a_realiser"       value = 1 />
                                    <input type="hidden" name="transfert_filleul"         value = 1 />
                                    <input type="hidden" name="name_partenaire"         value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />
                                    <input type="hidden" name="id_partner"              value = "<?php echo $reponse20["id_partner"] ?>" />
			  	              	    <input type="hidden" name="name_affiliate-value"    value = "<?php echo $id_affiliate ?>" />
                                    <input type="hidden" name="name_affiliate"          value = "<?php echo $reponse10["first_name"].' '.$reponse10["last_name"] ?>" />

		 
	 
			
			     <div class="col-md-5 right-10" >
			      <?php
             	 // REQUETTE DE REMPLISSAGE DU TABLEAU 
             
                	$result = $connection_database->query( " SELECT  ".REQUETE_AFF_DETAILS_CHAMPS($id_affiliate, 0)." 
				                                                                      FROM   affiliate_details ad, affiliate af 
				  	                  					                              WHERE  ad.id_affiliate = af.id_affiliate  
				  	                  					                              AND    af.id_upline    = ".$id_affiliate."  ORDER BY ad.id_affiliate DESC   ");								  
																					  
			     			         echo '<div class="form-group">';
			     			         echo "<div class='col-md-12'>";
			     			             echo "<select class='form-control'  name='filleul_niv1_qui_transfert' >";
			     			             echo "<option value='0'>-- FILLEUL DE NIVEAU 1 À TRANSFÉRER --</option>"; 
			     			             
                                          WHILE ( $row = $result->fetch(PDO::FETCH_ASSOC)  ) 
			     					      { 					 
			     			                     echo" <option value=".$row["id_affiliate"]." > ".$row["id_affiliate"]." - ". $row["first_and_last_name"] ."</option>"; 
			     			  	          }
                                          
			     			             echo" </select>";	
			     			         echo" </div>";	
			     			         echo" </div>";
                  ?>	
                  </div>				 
				  
			      <div class="col-md-2 right-20" >
                     <label class="control-label" for="nom"> À TRANSFÉRER VERS </label>
                  </div>				 				  
				  
			     <div class="col-md-5 right-10" >
			      <?php
             	 // REQUETTE DE REMPLISSAGE DU TABLEAU 
                	$result = $connection_database->query( " SELECT  ".REQUETE_AFF_DETAILS_CHAMPS($id_affiliate, 0)." 
				                                                                      FROM   affiliate_details ad, affiliate af 
				  	                  					                              WHERE  ad.id_affiliate = af.id_affiliate  
				  	                  					                              AND    af.id_upline    = ".$id_affiliate."  ORDER BY ad.id_affiliate DESC   ");	
             
			     			         echo '<div class="form-group">';
			     			         echo "<div class='col-md-12 '>";
			     			             echo "<select class='form-control'  name='filleul_niv1_qui_recoit' >";
			     			             echo "<option value='0'>-- FILLEUL DE NIVEAU 1 QUI REÇOIT --</option>"; 
			     			             
                                          WHILE ( $row = $result->fetch(PDO::FETCH_ASSOC)  ) 
			     					      { 					 
			     			                     echo" <option value=".$row["id_affiliate"]." > ".$row["id_affiliate"]." - ". $row["first_and_last_name"] ."</option>"; 
			     			  	          }
                                          
			     			             echo" </select>";	
			     			         echo" </div>";	
			     			         echo" </div>";
                  ?>	
                  </div>					  

             </div>	<br/> <br/><br/><br/>

                                 <center>
	                                <button type="submit" class="btn small btn-sm  btn-circle red margin-top-20  ">TRANSFÉRER LE FILLEUL <i class="fa fa-refresh"></i></button>
								 </center>
								 
                                 </div>
			 </form>
				  
			 </div>			 
			 </div>
			 </div>	
			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->			 
             <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->

			 </div>			 
			 
			
			 </div> 

  <?php
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function EQUIPE_IAD($id_affiliate, $mail_partenaire, $tel_partenaire, $niveau) 
{

             	 // REQUETTE DE REMPLISSAGE DU TABLEAU 
                 $result   = mysql_query(" SELECT iad_nom, iad_prenom, iad_id_parrain,	iad_phone, iad_email, iad_id, iad_cp, iad_ville, iad_date_debut_iad 
				                           FROM partner_iad 
										   WHERE iad_id_parrain in 
										             ( SELECT iad_id FROM partner_iad piad
													   WHERE trim(piad.iad_email)    = trim(\"$mail_partenaire\")  	
                                                          OR trim(piad.iad_phone)    = trim(\"$tel_partenaire\")  )	  ") or die("Requete pas comprise #98AAFGTE !"); 
														  
                return array ($result, $niveau);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function REMPLISSAGE_TABLE_CHALLENGE_CUSTO($id_affiliate_owner, $mail_partenaire, $tel_partenaire, $nom, $prenom, $niveau) 
{
	// CETTE FUNCTION VA RECHERCHER TOUS LES FILLEULS IAD ATTACHÉ À CE PARRAIN DANS PARTNER_IAD SUR 5 NIVEAUX POUR REMPLIR EN PARTIE AFFILIATE_CHALLENGE_CUSTOM_ID
    // 1. ON ÉFFACE LA LISTE DES IAD DANS LA TABLE DES CHALLENGE						
    $result = mysql_query(' DELETE FROM affiliate_challenge_custom_id 
	                        WHERE 	id_affiliate_owner = '.$id_affiliate_owner.'  
						    AND      source_affiliate   =  \'IAD\'   ') or die("Requete pas comprise ~ZQQPPLSQSQS");
 
 
    //2 . REMPLISSAGE IAD
    List($result, $niveau)       = EQUIPE_IAD($id_affiliate_owner, $mail_partenaire, $tel_partenaire, 1);
    $id_affiliate_in_challenge_1 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner,  $mail_partenaire, $tel_partenaire,  $prenom, $nom, "IAD", 1); 
    
	while ($reponse = mysql_fetch_array($result))
        {                                
           $id_affiliate_in_challenge_1 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner,  $reponse["iad_email"], $reponse["iad_phone"], $reponse["iad_prenom"], $reponse["iad_nom"], "IAD", 1);    
           
		   IF ($niveau > 1) // A METTRE A 0 POUR LE CHALLENGE DE VADIM OU DE CEDRIC HERRERAS SINON IL FAUT METTRE 1
		   {
		   /// NIVEAU 2 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           List($result2, $niveau2) = EQUIPE_IAD($id_affiliate_in_challenge_1, trim($reponse["iad_email"]), trim($reponse["iad_phone"]), 2); 										  
           while ($reponse2 = mysql_fetch_array($result2))
             {  
               $id_affiliate_in_challenge_2 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner, $reponse2["iad_email"], $reponse2["iad_phone"], $reponse2["iad_prenom"], $reponse2["iad_nom"], "IAD", 2);

		             /// NIVEAU 3 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     List($result3, $niveau3) = EQUIPE_IAD($id_affiliate_in_challenge_2, $reponse2["iad_email"], $reponse2["iad_phone"], 3); 										  
                     while ($reponse3 = mysql_fetch_array($result3))
                     {  
                                        $id_affiliate_in_challenge_3 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner, $reponse3["iad_email"], $reponse3["iad_phone"], $reponse3["iad_prenom"], $reponse3["iad_nom"], "IAD", 3);

		                         /// NIVEAU 4 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                 List($result4, $niveau4) = EQUIPE_IAD($id_affiliate_in_challenge_3, $reponse3["iad_email"], $reponse3["iad_phone"], 3); 										  
                                 while ($reponse4 = mysql_fetch_array($result4))
                                 {  
                                                    $id_affiliate_in_challenge_4 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner, $reponse4["iad_email"], $reponse4["iad_phone"], $reponse4["iad_prenom"], $reponse4["iad_nom"], "IAD", 4);
                                 
		                                      /// NIVEAU 5 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                              List($result5, $niveau5) = EQUIPE_IAD($id_affiliate_in_challenge_4, $reponse4["iad_email"], $reponse4["iad_phone"], 3); 										  
                                              while ($reponse5 = mysql_fetch_array($result5))
                                              {  
                                                                 $id_affiliate_in_challenge_5 = INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner, $reponse5["iad_email"], $reponse5["iad_phone"], $reponse5["iad_prenom"], $reponse5["iad_nom"], "IAD", 5);
                                              
					  	                        
                                              }

					  	           
                                 }	

										
                     }			   
			   

			 }
			 
			 
		   } // FIN 123

		}						  
  

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function INSERT_INTO_AFFILIATE_CHALLENGE_CUSTOM_ID($id_affiliate_owner, $email, $mobile, $first_name, $last_name, $source_affiliate, $niveau_arborescence) 
{				
	List ($id_affiliate_in_challenge, $id_partenaire, $id_upline, $email_p, $first_name_p, $last_name_p ) = CHECK_IF_FULL_NOSREZO_EXIST($email, $mobile, $first_name, $last_name, $id_affiliate_owner);

				//date_default_timezone_set('Europe/Paris');
                $sql ='insert into affiliate_challenge_custom_id( id, id_affiliate_owner, id_affiliate_in_challenge, email, source_affiliate, niveau_arborescence, creation_date) 
				                             values (
											 "",
											 "'.$id_affiliate_owner.'",
											 "'.$id_affiliate_in_challenge.'",
											 "'.$email.'",
											 "'.$source_affiliate.'",
											 "'.$niveau_arborescence.'",
											 CURRENT_TIMESTAMP)
											 ';
                 $result = mysql_query($sql) or die("Requete pas comprise #12POZLLL");  
				 return ($id_affiliate_in_challenge);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function LIRE_CSV_IAD_CHARGEMENT($connection_database2, $nom_fichier, $source_pays_partenaire, $separateur = ";" )
{
	$ligne_chargee      = 0;
    $File_to_load       = fopen($nom_fichier,"r"); //OUVERTURE DU FICHIER EN LECTURE   
	$row_to_start       = 0;
	$STOP               = 0;
	$ligne_non_insert   = "";
		
    WHILE (!feof($File_to_load) AND $STOP < 1)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        {    	
			 $uneLigne          = fgets($File_to_load, 4096);			 
             $val               = explode($separateur, $uneLigne);
			 
			 IF ($row_to_start > 0)
			 { //#ROWTOSTART
                        IF (trim($val[0]) != '') 
			            { //#98ER
			              //echo "Val0 : ".$val[0]." - Val1 : ".$val[1]." - Val2 : ".$val[2]." - Val3 : ".utf8_encode($val[3])." - Val4 : ".utf8_encode($val[4])." - Val6 : ".utf8_encode($val[6])." - Val7 : ".$val[7]." - Val8 : ".utf8_encode($val[8])." - Val9 : ".$val[9]." - Val10 : ".utf8_encode($val[10])." - Val11 : ".utf8_encode($val[11])." - Val12 : ".$val[12]."  <br/> ";
			            ///////////////////////////////////////////////////////   CHARGEMENT DES VALEURS DANS DES VARIABLES NOMMÉES			 
			            $ID_IAD            = str_replace("\"", "", $val[0]);
			            $ID_email          = str_replace("\"", "", $val[1]);
			            $ID_genre          = str_replace("\"", "", $val[2]);
			            $ID_nom            = str_replace("\"", "", $val[3]);
						IF ( $source_pays_partenaire == "portugal") { $ID_nom        = str_replace("\"", "", utf8_encode( $ID_nom )); }
						
			            $ID_prenom         = str_replace("\"", "", $val[4]);
						IF ( $source_pays_partenaire == "portugal") { $ID_prenom        = str_replace("\"", "", utf8_encode( $ID_prenom )); }
						
			            $ID_telephone      = str_replace("\"", "", $val[5]);  
						IF (strlen($ID_telephone) == 9 AND substr($ID_telephone, 0, 1) <> 0) { $ID_telephone = "0".$ID_telephone; }
						
			            $ID_adresse        = str_replace("\"", "", trim($val[6]));
						IF ( $source_pays_partenaire == "portugal") { $ID_adresse        = str_replace("\"", "", utf8_encode( $ID_adresse )); }
						
			            $ID_cp             = str_replace("\"", "", $val[7]);
						IF (strlen($ID_cp) == 4 )                                            { $ID_cp = "0".$ID_cp; }
						
			            $ID_ville          = str_replace("\"", "", $val[8]);
						IF ( $source_pays_partenaire == "portugal") { $ID_ville        = str_replace("\"", "", utf8_encode( $ID_ville )); }
						
			            $ID_date_nais      = str_replace("\"", "", $val[9]);
						
			            $ID_lieu_nais      = str_replace("\"", "", $val[10]);
						IF ( $source_pays_partenaire == "portugal") { $ID_lieu_nais        = str_replace("\"", "", utf8_encode( $ID_lieu_nais )); }
						
			            $ID_nationalite    = str_replace("\"", "", $val[11]);
						IF (trim($ID_nationalite) == "" OR trim($ID_nationalite) == 0)       { $ID_nationalite = "FR"; }
						IF ( $source_pays_partenaire == "portugal") { $ID_nationalite        = str_replace("\"", "", utf8_encode( $ID_nationalite )); }

			            $ID_cp_secteur     = str_replace("\"", "", $val[12]);
						IF (strlen($ID_cp_secteur) == 4 ) { $ID_cp_secteur = "0".$ID_cp_secteur; }
						IF (trim($ID_cp_secteur) == "" OR trim($ID_cp_secteur) == 0)        { $ID_cp_secteur = $ID_cp; }
						
			            $ID_ville_secteur      = str_replace("\"", "", trim($val[13]));
						IF ( $source_pays_partenaire == "portugal") { $ID_ville_secteur        = str_replace("\"", "", utf8_encode( $ID_ville_secteur )); }
						$ID_ville_secteur      = str_replace("ET S FRANCE", "", $ID_ville_secteur);
						$ID_ville_secteur      = str_replace("TOUS ARRONDISSEMENTS", "", $ID_ville_secteur);
						$ID_ville_secteur      = str_replace("ET SES ENVIRONS", "", $ID_ville_secteur);
						$ID_ville_secteur      = str_replace("ENVIRON", "", $ID_ville_secteur);			
						$ID_ville_secteur      = str_replace("SECTEUR SUD", "", $ID_ville_secteur);		
						$ID_ville_secteur      = str_replace("SECTEUR NORD", "", $ID_ville_secteur);	
						$ID_ville_secteur      = str_replace("SECTEUR OUEST", "", $ID_ville_secteur);	
						$ID_ville_secteur      = str_replace("SECTEUR EST", "", $ID_ville_secteur);							
						IF (trim($ID_ville_secteur) == "")  { $ID_ville_secteur = $ID_ville; }
						
			            $ID_date_entree        = str_replace("\"", "", $val[14]);
			            $ID_rang               = str_replace("\"", "", $val[15]);
			            $ID_nb_compromis       = str_replace("\"", "", $val[16]);
						IF (trim($ID_nb_compromis) == "" )                                    { $ID_nb_compromis = 0; }
			            $ID_last_compromis     = str_replace("\"", "", $val[17]);
			            $ID_habilitation       = str_replace("\"", "", $val[18]);
			            $ID_num_securite       = str_replace("\"", "", $val[19]);
			            $ID_id_parrain         = str_replace("\"", "", $val[20]);
			            $ID_parrain_mail       = str_replace("\"", "", $val[21]);
			            $ID_statut_prof        = str_replace("\"", "", $val[22]);
			            $ID_tva                = str_replace("\"", "", $val[23]);
			            $ID_rsac               = str_replace("\"", "", trim($val[24]));
			            $ID_debut_conges       = str_replace("\"", "", trim($val[25]));
			            $ID_fin_conges         = str_replace("\"", "", trim($val[26]));
			            $ID_is_activated       = str_replace("\"", "", trim($val[27]));	
                        $va_quitter_iad        = str_replace("\"", "", trim($val[28]));						
                        $date_rec_resil        = str_replace("\"", "", trim($val[29]));
						$id_part_nr_replacant  = 0;
						$email_remplacant      = str_replace("\"", "", trim($val[30]));  IF ($email_remplacant <> "")   { $id_part_nr_replacant = RETURN_ID_PARTNER_ACTIF($connection_database2, $email_remplacant); }
						
						
	                    IF (               (is_num($ID_IAD) == 1)                      // CHAMPS ID IAD            : CHECK IF INTEGER                
                                      AND  (strstr($ID_email, "@iad"))                 // CHAMPS EMAIL             : CHECK IF EMAIL                
                                      AND  (strlen($ID_genre) > 0)                     // CHAMPS GENRE             : CHECK IF TAILLE MIN 1         
                                      AND  (strlen($ID_nom) > 1)                       // CHAMPS NOM               : CHECK IF TAILLE MIN 2           
                                      AND  (strlen($ID_prenom) > 1)                    // CHAMPS PRÉNOM            : CHECK IF TAILLE MIN 2        
                                      AND  (strlen($ID_telephone) < 20 )               // CHAMPS TÉLÉPHONE         : CHECK IF TAILLE MAX 10    
                                      //AND  (strlen($ID_adresse) > 2 )                // CHAMPS ADRESSE1          : CHECK IF TAILLE MIN 3       
                                      //AND  (is_num($ID_cp) == 1)                       // CHAMPS CP                : CHECK IF INTEGER                 
                                      AND  (strlen($ID_ville) > 1 )                    // CHAMPS VILLE             : CHECK IF TAILLE MIN 2         
                                      AND  (strlen($ID_date_nais) > 5 )                // CHAMPS DATE              : CHECK IF TAILLE MIN 6     
                                      //AND  (strlen($ID_lieu_nais) > 1 )              // CHAMPS LIEU_N            : CHECK IF TAILLE MIN 2      
 			            			  AND  (strlen($ID_nationalite) > 1 )              // CHAMPS NATIONALITE       : CHECK IF TAILLE MIN 2    
                                  //    AND  (is_num($ID_cp_secteur) == 1)               // CHAMPS CPSECTEUR1        : CHECK IF INTEGER		
                                      AND  (strlen($ID_ville_secteur) > 1 )            // CHAMPS VILLESECTEUR1     : CHECK IF TAILLE MIN 2  
                                      AND  (strlen($ID_date_entree) > 1 )              // CHAMPS DATE_ENTREE       : CHECK IF TAILLE MIN 2    
                                      AND  (strlen($ID_rang) > 0 )                     // CHAMPS RANG              : CHECK IF TAILLE MIN 2           
                                      AND  (strlen($ID_nb_compromis) >= 0 )            // CHAMPS NB_COMPROMIS      : CHECK IF TAILLE MIN 2   
                                  //  AND  (strlen($ID_last_compromis) > 1 )           // CHAMPS DERNIER_COMPROMIS : CHECK IF TAILLE MIN 2 
                                  //  AND  (strlen($ID_habilitation) > 1 )             // CHAMPS HABILITATION      : CHECK IF TAILLE MIN 2   
                                  //  AND  (strlen($ID_num_securite) > 1 )             // CHAMPS NUMEROSECU        : CHECK IF TAILLE MIN 2   
                                  //  AND  (strlen($ID_id_parrain) > 1 )               // CHAMPS ID_PARRAIN        : CHECK IF TAILLE MIN 2     
                                  //  AND  (strlen($ID_parrain_mail) > 1 )             // CHAMPS PARRAIN_EMAIL     : CHECK IF TAILLE MIN 2   
                                  //  AND  (strlen($ID_statut_prof) > 1 )              // CHAMPS STATUT_PRO        : CHECK IF TAILLE MIN 2    
                                  //  AND  (strlen($ID_tva) > 1 )                      // CHAMPS TVA               : CHECK IF TAILLE MIN 2            
                                  //  AND  (strlen($ID_rsac) > 1 )                     // CHAMPS NUMERORSAC        : CHECK IF TAILLE MIN 2           
                                  //  AND  (strlen($ID_debut_conges) > 1 )             // CHAMPS DATE_DEBUT_CONGES : CHECK IF TAILLE MIN 2   
                                  //  AND  (strlen($ID_fin_conges) > 1 )               // CHAMPS DATE_FIN_CONGES   : CHECK IF TAILLE MIN 2     
                                  //  AND  (strlen($ID_is_activated) > 1 )             // CHAMPS IS_ACTIVATED IAD  : CHECK IF TAILLE MIN 2   
			            			 )
			            		    { // ON PRÉPARE LA REQUÊTE POUR INSERER LES DONNÉES DANS : PARTNER_IAD
                                    //#12345						
                        
                                    $valeurs   = '                        ( "", CURRENT_TIMESTAMP,    0,         "'.$ID_IAD.'", "'.$ID_email.'", "'.$ID_genre.'", "'.$ID_nom.'", "'.$ID_prenom.'", "'.$ID_telephone.'", "'.$ID_adresse.'", "'.$ID_cp.'", "'.$ID_ville.'", "'.$ID_date_nais.'", "'.$ID_lieu_nais.'", "'.$ID_nationalite.'",  "'.$ID_cp_secteur.'", "'.$ID_ville_secteur.'", "'.$ID_date_entree.'", "'.$ID_rang.'", "'.$ID_nb_compromis.'", "'.$ID_last_compromis.'", "'.$ID_habilitation.'", "'.$ID_num_securite.'", "'.$ID_id_parrain.'", "'.$ID_parrain_mail.'", "'.$ID_statut_prof.'", "'.$ID_tva.'", "'.$ID_rsac.'", "'.$ID_debut_conges.'", "'.$ID_fin_conges.'", "'.$ID_is_activated.'", "'.$va_quitter_iad.'" , "'.$date_rec_resil.'" , "'.$email_remplacant.'" , "'.$id_part_nr_replacant.'"  )';	 
                                    $sql       = " INSERT INTO partner_iad( ligne, date_creation ,  is_managed,   iad_id,         iad_email,        iad_genre,       iad_nom,       iad_prenom,        iad_phone,           iad_adresse,      iad_cp,        iad_ville,      iad_date_naissance, iad_lieu_naissance, iad_nationalite,       iad_cp_secteur,        iad_ville_secteur,  iad_date_debut_iad,       iad_grade,       iad_compromis,        iad_last_compromis_date,    iad_habilitation,       iad_num_secu_sociale,  iad_id_parrain,       iad_mail_parrain,         iad_statut_pro,      iad_tva_intra,  iad_rcs_rsac,   iad_date_debut_conges, iad_date_fin_conges, iad_is_activated, va_quitter_iad, date_reception_resiliation, email_remplacant, id_part_nr_replacant  )     VALUES ".$valeurs; 					
		 	            			
									mysql_query('SET NAMES utf8');
                                    //echo $sql."<br/><br/>";						
                                    IF    (!mysql_query($sql)) { echo mysql_error()." - ".$sql."<br/><br/>";	 }
                                    ELSE                       { $ligne_chargee  = $ligne_chargee + 1;          }						 
                                    
			                        }//#12345 
			            			ELSE
			            			{  
			            			     //$STOP = 1; // ON A UN PROBLEME HOUSTON 
			                             $ligne_non_insert = "ID IAD : ".$val[0]." - ".$val[1]." - ".$val[2]." - ".$val[3]." - ".$val[4]." - ".$val[5]."  - ".$val[6]." ";
			            			 
			            			}
                         } #98ER	
                 } //#ROWTOSTART
				 $row_to_start  = $row_to_start + 1;
         } 	
		 
	fclose($File_to_load);
	return array($ligne_chargee, $row_to_start-2, $ligne_non_insert);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function LOAD_DATA_IAD_FILE($connection_database2, $nom_fichier, $source_pays_partenaire )
{    
    	 $ligne_chargee   = 0;
		 $nb_ligne        = 0;
		 // IS_MANAGED = 1 >> ON EFFACE TOUTES LES LIGNES : 0 ET 1
         // IS_MANAGED = 0 >> LES LIGNES SONT A TRAITER 
		 mysql_query("  DELETE FROM partner_iad 
		                WHERE is_managed in  (0,1)
                        AND trim(iad_email) like \"%$source_pays_partenaire%\" 			") or die('Erreur SQL DELETE #LOAD_DATA_IAD_FILE ');	 

	 	 list($ligne_chargee, $nb_ligne, $ligne_non_insert) = LIRE_CSV_IAD_CHARGEMENT($connection_database2, $nom_fichier, $source_pays_partenaire );
		 $reponse = mysql_fetch_array(mysql_query("  SELECT count(*) as nb_ligne_chargee FROM partner_iad 
		                                             WHERE trim(iad_email) like \"%$source_pays_partenaire%\"    "));	 
		 
	     return array($reponse['nb_ligne_chargee'], $nb_ligne, $ligne_non_insert);		
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function MAJ_PROMOTION_SUIVI($param1, $param2)
{           						 
                 $result           = mysql_query(" SELECT ligne_promo, id_affiliate, date_fin_promo, motif_promo, notification_code FROM promotion_suivi  WHERE  is_activated = 1 AND date_fin_promo < DATE_ADD(NOW(), INTERVAL 1 HOUR)    ") or die("Requete SENT date_fin_promo : PQQDJ pas comprise. ");				
   			     // ON RETIRE 1 HEURE CAR LE CRON SE LANCE TOUS LES JOURS A LA MEME HEURE - PB SI MEME SECONDE
				 $rapport_activite = ""; 
				 $nb_maj_dossier   = 0;
				 while ($reponse = mysql_fetch_array($result))
                        {  
						    $nb_maj_dossier     = $nb_maj_dossier + 1;
							$ligne_promo        = $reponse['ligne_promo'];
				            mysql_query(" UPDATE promotion_suivi 
							              SET is_activated  = 0
										  WHERE ligne_promo = '$ligne_promo'   ");  
                            
							$rapport_activite = $rapport_activite ." &nbsp &nbsp >> Promotion close pour A".$reponse['id_affiliate']." Ligne ".$ligne_promo." <br/>"; 										  
							$rapport_activite = $rapport_activite .update_action_notification_status($reponse['id_affiliate'], $reponse['notification_code'])."<br/>"; 										  
					   
						}
				IF ($nb_maj_dossier == 0) { $rapport_activite = "&nbsp &nbsp &nbsp >> OK - Aucune mise a jour <br/>";   }
                return ($rapport_activite);			
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function RELANCE_PARTENAIRE_DOCUMENTS_MISSING($connection_database2, $NosRezo_racine) 
{ 
     // FUNCTION DE RELANCE DES PARTENAIRES SUR LES DOCUMENTS QUI NE SONT PAS ENVOYÉS 
	 include($NosRezo_racine.'/scripts/email/Inscription_email_partenaire_relance_docs.php');
	 
	 $rapport_activite = "";
     mysql_query('SET NAMES utf8');	
	 $result = mysql_query(" SELECT aa.id_affiliate, pl.id_partner, pl.p_sub_category, pl.id_services, pl.p_contrat_recu, pl.p_kbis_recu, pl.p_assurance_recu, pl.p_creation_date
	                         FROM partner_list pl, affiliate aa
							 WHERE aa.id_partenaire = pl.id_partner
							 AND pl.id_services not in (1, 4, 7, 8, 9, 10, 11, 30, 31, 32, 35, 36)
                             AND pl.is_activated = 1
                             AND (pl.p_contrat_recu = 0 OR pl.p_kbis_recu = 0 OR pl.p_assurance_recu = 0)							 
							 ORDER BY pl.id_partner desc ") or die("Requete pas comprise - #AHCAAA30912! "); 		

	 while ($reponse = mysql_fetch_array($result))
             {
				 SEND_EMAIL_INSCRIPTION_NOUVEAU_AFFILIE_PARTENAIRE($connection_database2, $reponse['id_affiliate'], $reponse['id_partner'], $reponse['p_sub_category'], $NosRezo_racine, $reponse['p_contrat_recu'], $reponse['p_kbis_recu'], $reponse['p_assurance_recu']);
	             $rapport_activite = "&nbsp &nbsp >> RELANCE : A".$reponse['id_affiliate']." - P".$reponse['id_partner']." ";
			 }
     return ($rapport_activite);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DESACTIVATED_PARTENAIRE_DOCUMENTS_MISSING($connection_database2, $NosRezo_racine) 
{ 
     // FUNCTION DE RELANCE DES PARTENAIRES SUR LES DOCUMENTS QUI NE SONT PAS ENVOYÉS 
	 include($NosRezo_racine.'/scripts/email/Inscription_email_partenaire_relance_docs_fermeture.php');
	 
	 $rapport_activite = "";
     mysql_query('SET NAMES utf8');	
	 $result = mysql_query(" SELECT aa.id_affiliate, pl.id_partner, pl.p_sub_category, pl.id_services, pl.p_contrat_recu, pl.p_kbis_recu, pl.p_assurance_recu, pl.p_creation_date
	                         FROM partner_list pl, affiliate aa
							 WHERE aa.id_partenaire = pl.id_partner
							 AND pl.id_services not in (1, 4, 7, 8, 9, 10, 11, 30, 31, 32, 35, 36)
                             AND pl.is_activated = 1
                             AND (pl.p_contrat_recu = 0 OR pl.p_kbis_recu = 0 OR pl.p_assurance_recu = 0)
                             AND TO_DAYS( NOW( ) ) - TO_DAYS( p_creation_date ) > 30 							 
							 ORDER BY pl.id_partner desc 
							 Limit 0,50 ") or die("Requete pas comprise - #DESACTIVATED_PARTENAIRE_DOCUMENTS_MISSING! "); 		

	 WHILE ($reponse = mysql_fetch_array($result))
             {
				 SEND_EMAIL_INSCRIPTION_NOUVEAU_AFFILIE_PARTENAIRE_FERMETURE($connection_database2, $reponse['id_affiliate'], $reponse['id_partner'], $reponse['p_sub_category'], $NosRezo_racine, $reponse['p_contrat_recu'], $reponse['p_kbis_recu'], $reponse['p_assurance_recu']);
	             $rapport_activite = "&nbsp &nbsp >> RELANCE : A".$reponse['id_affiliate']." - P".$reponse['id_partner']." ";
				 UPDATE_PARTNER_LIST_ACTIVATED_ACCESS($connection_database2, $reponse['id_partner'], 0, 1);
			 }
     return ($rapport_activite);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function MOST_RECENT_FILE_TO_OPEN_IAD($chemin_vers_le_dossier)
{           						 
     $latest_ctime = 0;
     $latest_filename = '';    

     $d = dir($chemin_vers_le_dossier);
     while (false !== ($entry = $d->read())) 
	 {
         $filepath = "{$chemin_vers_le_dossier}/{$entry}";
         // COULD DO ALSO OTHER CHECKS THAN JUST CHECKING WHETHER THE ENTRY IS A FILE
         IF (is_file($filepath) && filectime($filepath) > $latest_ctime) 
		     {
                   $latest_ctime    = filectime($filepath);
                   $latest_filename = $entry;
             }
     }
	 /// VERIFICATION DU FORMAT CSV
	 IF ( SUBSTR($latest_filename, -3) == "csv" OR SUBSTR($latest_filename, -3) == "xls" OR SUBSTR($latest_filename, -4) == "xlsx" ) 
	      { return ($latest_filename);  }
	 ELSE { return ("");                }
	 		
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function CHECK_IF_FULL_NOSREZO_EXIST($email, $phone, $first_name, $last_name, $id_parrain) 
{	  // CE MODULE VA SCANNER L'ENSEMBLE DES TABLES NOSREZO AFIN DE CONNAITRE L'EXISTENCE D'UNE PERSONNE
      // LES CLÉS D'UNICITÉ DANS LES BASES SONT :
	                 // 1. MAIL PARTENAIRE, MAIL AFFILIÉ UNIQUE 
			         // 2. TELEPHONE PARTENAIRE UNIQUE
			         // ATTENTION >>>>>>>>>>>> LE TELEPHONE AFFILIÉ N'EST PAS UNIQUE <<<<<<<<<<<<<<<<< ATTENTION 

	  $id_affiliate  = 0;
	  $id_partenaire = 0;
	  $email         = trim($email);
	  $first_name    = trim($first_name);
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  //// 1. CHECK EMAIL : PROBABILITÉ MÊME PERSONNE = 100%
	     $sql_master    = "SELECT count(aa.id_affiliate) as is_exist, aa.id_affiliate, ad.email, ad.first_name, ad.last_name, ad.phone_number, ad.zip_code, aa.id_partenaire, aa.id_upline 
                           FROM affiliate_details ad, affiliate aa
                           WHERE ad.id_affiliate = aa.id_affiliate   
	                       AND aa.is_activated = 1
						   AND (trim(ad.email) like \"$email\" OR aa.id_partenaire in ( select pl.id_partner From partner_list pl 
				                                                                        WHERE trim(pl.p_contact_mail) like \"$email\" ) 
							    ) ";
	      $result = mysql_fetch_array(mysql_query( $sql_master)) or die("Requete pas comprise - #QEMCHB31! ");
	      IF ($result['is_exist'] == 1)     { return array($result['id_affiliate'], $result['id_partenaire'], $result['id_upline'], $result['email'], $result['first_name'],$result['last_name']  ); }	
	      ELSE
		  { //#2
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  // 2. CHECK SANS EMAIL : MÊME PERSONNE = 100%
					// NOM+PRENOM+PHONE
					// PRENOM+PHONE
					// PARRAIN+NOM+PRENOM
		 $phone         = substr($phone, 2, 8);
	     $sql_master    = "  SELECT count(aa.id_affiliate) as is_exist, ad.last_name, ad.first_name, ad.phone_number as phone, ad.id_affiliate, aa.id_upline, aa.id_partenaire, ad.email, aa.password 
                             FROM affiliate_details ad, affiliate aa 
                             WHERE ad.id_affiliate = aa.id_affiliate 
                             AND aa.is_activated = 1  
                             AND (
                                     (ad.last_name  like \"$last_name\"       AND ad.first_name   like \"$first_name%\"   AND ad.phone_number  like \"%$phone%\"    )
                                  OR (ad.first_name like \"$first_name%\"     AND ad.phone_number like \"%$phone%\"       )
                                  OR (aa.id_upline = $id_parrain              AND ad.last_name like \"$last_name\"          AND ad.first_name like \"$first_name%\"  )
                                 )    ";
		 //echo $sql_master."<br/>";
		 $result = mysql_fetch_array(mysql_query($sql_master)) or die("Requete pas comprise - #QEMCHB31! ");
	                 IF ($result['is_exist'] > 0)     
					         { 	            
  							  return array($result['id_affiliate'], $result['id_partenaire'], $result['id_upline'], $result['email'], $result['first_name'], $result['last_name'] ); 
							  }
                     ELSE    { 
                              return array(0, 0, $id_parrain, $email, $first_name, $last_name ); 					         
							 }    
                    					 
		  }	//FIN#2

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
}
?>

<?php  function MISE_A_JOUR_CHALLENGE_SUMMER_2015($NosRezo_racine) 
{ // LES CHAMPS PEUVENT ETRE EFFACEE APRES LE CHALLENGE

	 $TOTAL_PTS_CHALLENGE   = 0;
	 $PTS_FACEBOOK          = 10;

	 // POINTS DU 01 JUILLET AU 10 SEPTEMBRE 23:59:59
     $debut_challenge_1        = "2015-07-01";
	 $fin_challenge            = "2015-09-10";
	 $nb_reco_L1_points        = 10;	 
	 $nb_reco_downline         = 5;
	 $nb_filleuls_L2_points    = 1;
	 $nb_filleuls_L3_points    = 2;

	 // POINTS DU 11 SEPTEMBRE AU 30 SEPTEMBRE 23:59:59
     $debut_challenge          = "2015-09-11";
	 $fin_challenge            = "2015-09-30";
	 $nb_reco_L1_points_2      = 20;	 
	 $nb_reco_downline_2       = 10;
	 $nb_filleuls_L2_points_2  = 2;
	 $nb_filleuls_L3_points_2  = 4;
	 
    // ON DOUBLE A PARTIR DU 11 SEPTEMBRE
	   
	   
	 $result = mysql_query(" SELECT aa.id_affiliate, aa.first_name, aa.last_name , TOTAL_PTS_CHALLENGE, PTS_FACEBOOK,
				             RECO_DIRECT_E5,   RECO_TEAM,   FILLEULS_NIVEAU_1,   FILLEULS_NIVEAU_2,
							 RECO_DIRECT_E5_2, RECO_TEAM_2, FILLEULS_NIVEAU_1_2, FILLEULS_NIVEAU_2_2 
	         			     FROM affiliate aa, affiliate_details ad
							 WHERE aa.id_affiliate = ad.id_affiliate
	         			     AND   aa.is_activated = 1
						     AND   aa.id_affiliate > 10
						     ORDER BY id_affiliate            ") or die("Requete pas comprise - #AHCAAA30912! "); 		

	 WHILE ( $reponse = mysql_fetch_array($result) )
             {
										 echo $reponse["id_affiliate"]."<br/>";
                                         $points_total = $reponse["FILLEULS_NIVEAU_1"] * $nb_filleuls_L2_points + $reponse["RECO_DIRECT_E5"] * $nb_reco_L1_points + $reponse["RECO_TEAM"] * $nb_reco_downline + $reponse["FILLEULS_NIVEAU_2"] * $nb_filleuls_L3_points  ;						
										 
										 $liste_affiliate = '  FROM affiliate aff, affiliate_details afd
				                         				       WHERE aff.id_affiliate = afd.id_affiliate
                                                               AND	aff.id_upline = '.$reponse["id_affiliate"].' 
                                                               AND  aff.is_activated = 1
                                                               AND	creation_date >= "'.$debut_challenge_1.'"
                                                               AND	creation_date <= "'.$fin_challenge.'"	      ';


										 // 1. ON COMPTE LES FILLEULS DE NIVEAU 1
                                          $result_L1        = mysql_fetch_array( mysql_query(' SELECT count( aff.id_affiliate ) as nb_affiliate_l1 
                                                               FROM affiliate aff, affiliate_details afd
				                         				       WHERE aff.id_affiliate = afd.id_affiliate
                                                               AND	aff.id_upline = '.$reponse["id_affiliate"].' 
                                                               AND  aff.is_activated = 1
                                                               AND	creation_date >= "'.$debut_challenge.'"
                                                               AND	creation_date <= "'.$fin_challenge.'"	                ') );
		                                  $nb_affiliate_l1  = $result_L1['nb_affiliate_l1'];
										  IF ($nb_affiliate_l1 > 10 ) { $nb_affiliate_l1 = 10; }


                                         // 2. ON COMPTE LES FILLEULS DE NIVEAU 2
                                          $result_L2  = mysql_fetch_array( mysql_query(' SELECT count( af.id_affiliate ) as nb_affiliate_l2 
										                                        FROM affiliate af, affiliate_details ad
																				WHERE af.id_affiliate = ad.id_affiliate
                                                                                AND	af.id_upline in ( select aff.id_affiliate '.$liste_affiliate.'  )   
                                                                                AND	creation_date >= "'.$debut_challenge.'"
                                                                                AND	creation_date <= "'.$fin_challenge.'"			') );
		                                  $nb_affiliate_l2  = $result_L2['nb_affiliate_l2'];
										  IF ($nb_affiliate_l2 > 100 ) { $nb_affiliate_l2 = 100; }
										  

                                         // 3. ON COMPTE LES RECOMMANDATIONS
                                          $result_L1  = mysql_fetch_array( mysql_query(' SELECT count( id_recommandation ) as nb_reco 
										                                        FROM recommandation_details rd
																				WHERE rd.id_affiliate = '.$reponse["id_affiliate"].' 
                                                                                AND rd.r_sub_category_code = 1
																				AND id_recommandation in (SELECT id_recommandation FROM action_list	al WHERE action_id_category = 15 and id_recommandation = rd.id_recommandation )																			
                                                                                AND	r_creation_date >= "'.$debut_challenge.'"	
																				AND	r_creation_date <= "'.$fin_challenge.'"        ') );
		                                  $nb_reco     = $result_L1['nb_reco'];

                                         // 4. ON COMPTE LES RECOMMANDATIONS DE LA DOWN LINE SUR 4 NIVEAUX
                                          $result_RDL1  = mysql_fetch_array( mysql_query(' SELECT count( id_recommandation ) as nb_reco 
										                                        FROM recommandation_details rd
																				WHERE rd.id_affiliate in ( select aff.id_affiliate '.$liste_affiliate.'   )																			
                                                                                AND   rd.r_sub_category_code = 1
																				AND   id_recommandation in (SELECT id_recommandation FROM action_list	al WHERE action_id_category = 15 and id_recommandation = rd.id_recommandation )
																				AND	  r_creation_date >= "'.$debut_challenge.'"	
																				AND	  r_creation_date <= "'.$fin_challenge.'"        ') );
		                                  $nb_reco_dl1  = $result_RDL1['nb_reco'];
										  
                                          $result_RDL2  = mysql_fetch_array( mysql_query(' SELECT count( id_recommandation ) as nb_reco 
										                                        FROM recommandation_details rd
																				WHERE rd.id_affiliate in ( SELECT id_affiliate FROM affiliate where id_upline in ( select aff.id_affiliate '.$liste_affiliate.'  )   )																			
                                                                                AND   rd.r_sub_category_code = 1
																				AND   id_recommandation in (SELECT id_recommandation FROM action_list	al WHERE action_id_category = 15 and id_recommandation = rd.id_recommandation )
																				AND	  r_creation_date >= "'.$debut_challenge.'"	
																				AND	  r_creation_date <= "'.$fin_challenge.'"        ') );
		                                  $nb_reco_dl2  = $result_RDL2['nb_reco'] + $nb_reco_dl1;
										  
                                          $result_RDL3  = mysql_fetch_array( mysql_query(' SELECT count( id_recommandation ) as nb_reco 
										                                        FROM recommandation_details rd
																				WHERE rd.id_affiliate in ( SELECT id_affiliate FROM affiliate WHERE id_upline in ( SELECT id_affiliate FROM affiliate WHERE id_upline in (  select aff.id_affiliate '.$liste_affiliate.'  ) )   )																			
                                                                                AND	  r_creation_date >= "'.$debut_challenge.'"
                                                                                AND   id_recommandation in (SELECT id_recommandation FROM action_list	al WHERE action_id_category = 15 and id_recommandation = rd.id_recommandation )																				
																				AND	  r_creation_date <= "'.$fin_challenge.'"        ') );
		                                  $nb_reco_dl  = $result_RDL3['nb_reco'] + $nb_reco_dl2;
                                          
										  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                          $points_total = $points_total + $nb_affiliate_l1 * $nb_filleuls_L2_points_2 + $nb_reco * $nb_reco_L1_points_2 + $nb_reco_dl * $nb_reco_downline_2 + $nb_affiliate_l2 * $nb_filleuls_L3_points_2 + $reponse["PTS_FACEBOOK"] ;										  
										  
										  // echo " ".$points_total." = ".$nb_affiliate_l1." * ".$nb_filleuls_L2_points." + ".$nb_reco." * ".$nb_reco_L1_points." +  ".$nb_reco_dl." * ".$nb_reco_downline." + ".$nb_affiliate_l2." * ".$nb_filleuls_L3_points." + ".$reponse["PTS_FACEBOOK"]."<br/> <br/>" ;										  	 	 
                                          
										 $result_RDL3  =  mysql_query(' UPDATE affiliate_details 
										                                                  SET TOTAL_PTS_CHALLENGE   = '.$points_total.', 
										 											       RECO_DIRECT_E5_2        = '.$nb_reco.',
										 												   RECO_TEAM_2             = '.$nb_reco_dl.',
										 												   FILLEULS_NIVEAU_1_2     = '.$nb_affiliate_l1.',
										 											       FILLEULS_NIVEAU_2_2     = '.$nb_affiliate_l2.'
                                                                                          WHERE id_affiliate        = '.$reponse["id_affiliate"].'       ') ;
											 
			 }
			 
			 return ("OK");

	 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function GENERATE_XML_FILE_PAIEMENT( $NosRezo_racine, $action_id_category, $id_affiliate, $id_cles_unique, $file_folder )
{     

        include 'scripts/config.php';
        $url_file = "BEN IS COOL";
		IF ( $id_affiliate == "FULL") { $requete_filtre_affiliate = " ";                                         $requete_filtre_cles = " "; }
		ELSE                          { $requete_filtre_affiliate = " AND    af.id_affiliate = $id_affiliate ";  $requete_filtre_cles = " AND aX_ref    = \"".$id_cles_unique."\"  "; }
        
        // Liste des actions 9.4
        $sql = "SELECT ac.action_id_category,  ac.id_recommandation, ac.id_partner, ac.id_affiliate, af.first_name, af.last_name, af.address, af.zip_code, af.city 
                FROM   action_list ac, affiliate_details af
                WHERE  action_id_category = $action_id_category 
                AND    action_status_int = 1
                AND    af.id_affiliate = ac.id_affiliate  $requete_filtre_affiliate ";
        $result = mysql_query ( $sql ) or die ( "Requete pas comprise #92346767 !" );
        $nb_rows = mysql_num_rows ( $result );
        
        // S'IL Y'A DES ÉTAPES  À TRAITER ON GÉNRÈRE LE FICHIER XML
        IF ($nb_rows >= 1) {
        	
        	// PAYMENTINFORMATION
        	$PaymentInformationIdentification = 'Virement 00001'; // Question banque
        	$PaymentMethod = 'TRF';
        	$CodePayment = 'SEPA';
        	$RequestedExecutionDate = '2016-10-30'; // Banque
        	$NameDebtor = 'NOSREZO';
        	$AdrsDebtor = '41 RUE PAUL CLAUDEL';
        	$CityDebtor = '91000 EVRY';
        	$CountryDebtor = 'FR';
        	$IbanDebtor = 'FR7610207001212121985699417';
        	$BicDebtor = 'CCBPFRPPMTG';
        	$ChargeBearer = 'SLEV';
        	
        	$ListCredtitTransfertTransactionInformation = '';
        	$ControlSum = 0;
        	WHILE ( $reponse = mysql_fetch_array ( $result ) ) {
        		
        		//
        		$sql_amount = "SELECT rc.aX_amount_ht, rc.aX_only_tva, rc.amount_net_payed, rc.amount_payed_ht, rc.amount_tva_percent, rc.amount_payed_ttc, nom_banque, code_banque, code_guichet, numero_compte, cle_rib, IBAN, bic_client 
        			           FROM   recommandation_comptable rc, affiliate_iban af 
        			           WHERE  aX_id_affiliate  = af.id_affiliate
							   AND    aX_id_affiliate  = " . $reponse ['id_affiliate'] . " 
        			           AND    af.id_affiliate  = " . $reponse ['id_affiliate'] . " 	
        			           AND    aX_payed         = 5   $requete_filtre_affiliate   $requete_filtre_cles "; 
        		$result_amount = mysql_query ( $sql_amount ) or die ( "Requete pas comprise GENERATE_XML_FILE_PAIEMENT : ".$sql_amount );
        		
        		IF ($response_amount = mysql_fetch_array ( $result_amount )) 
				{	
        			// CREDIT_TRANSFER_TRANSACTION_INFORMATION
        			$id_virement  = 'Viremment partenaire x pour la facture y';
        			$InstructedAmount = $response_amount ['amount_net_payed'];
        			$BicCreditor  = $response_amount ['bic_client'];
        			$NameCreditor = $reponse ['first_name'] . ' ' . $reponse ['last_name'];
        			$AdrsCreditor = $reponse ['address'];
        			$CityCreditor = $reponse ['zip_code'] . ' ' . $reponse ['city'];
        			$CountryCreditor = 'FR';
        			$IbanCreditor = $response_amount ['IBAN'];
        			$ControlSum  += $response_amount ['amount_net_payed'];
        			
        			$ListCredtitTransfertTransactionInformation .= '<CdtTrfTxInf>
        										        <PmtId>
        										          <EndToEndId>' . $id_virement . '</EndToEndId>
        										        </PmtId>
        										        <Amt>
        										          <InstdAmt Ccy="EUR">' . $InstructedAmount . '</InstdAmt>
        										        </Amt>
        										        <CdtrAgt>
        										          <FinInstnId>
        										            <BIC>' . $BicCreditor . '</BIC>
        										          </FinInstnId>
        										        </CdtrAgt>
        										        <Cdtr>
        										          <Nm>' . $NameCreditor . '</Nm>
        										          <PstlAdr>
        										            <AdrLine>' . $AdrsCreditor . '</AdrLine>
        										            <AdrLine>' . $CityCreditor . '</AdrLine>
        										            <Ctry>' . $CountryCreditor . '</Ctry>
        										          </PstlAdr>
        										        </Cdtr>
        										        <CdtrAcct>
        										          <Id>
        										            <IBAN>' . $IbanCreditor . '</IBAN>
        										          </Id>
        										        </CdtrAcct>
        										      </CdtTrfTxInf>';
        		}
        	}
        	
        	$PaymentInformation = '    <PmtInf>
        						      <PmtInfId>' . $PaymentInformationIdentification . '</PmtInfId>
        						      <PmtMtd>' . $PaymentMethod . '</PmtMtd>
        						      <PmtTpInf>
        						        <SvcLvl>
        						          <Cd>' . $CodePayment . '</Cd>
        						        </SvcLvl>
        						      </PmtTpInf>
        						      <ReqdExctnDt>' . $RequestedExecutionDate . '</ReqdExctnDt>
        						      <Dbtr>
        						        <Nm>' . $NameDebtor . '</Nm>
        						        <PstlAdr>
        						          <AdrLine>' . $AdrsDebtor . '</AdrLine>
        						          <AdrLine>' . $CityDebtor . '</AdrLine>
        						          <Ctry>' . $CountryDebtor . '</Ctry>
        						        </PstlAdr>
        						      </Dbtr>
        						      <DbtrAcct>
        						        <Id>
        						          <IBAN>' . $IbanDebtor . '</IBAN>
        						        </Id>
        						      </DbtrAcct>
        						      <DbtrAgt>
        						        <FinInstnId>
        						          <BIC>' . $BicDebtor . '</BIC>
        						        </FinInstnId>
        						      </DbtrAgt>
        						      <ChrgBr>' . $ChargeBearer . '</ChrgBr>
        						      ' . $ListCredtitTransfertTransactionInformation . '		
        						    </PmtInf>';
        	
        	// GROUPHEADER
        	$MessageIdentification = date ( 'd/m/Y H:i:s' ) . ' NOSREZO';
        	$CreationDateTime = date ( 'Y-m-d' ) . 'T' . date ( 'H:i:s' );
        	$NumberOfTransactions = $nb_rows;
        	$Grouping = 'MIXD';
        	$NameParty = 'NOSREZO';
        	$SiretParty = '80011878800010';
        	
        	$GroupHeader = '<GrpHdr>
        			      <MsgId>' . $MessageIdentification . '</MsgId>
        			      <CreDtTm>' . $CreationDateTime . '</CreDtTm>
        			      <NbOfTxs>' . $NumberOfTransactions . '</NbOfTxs>
        			      <CtrlSum>' . $ControlSum . '</CtrlSum>
        			      <Grpg>' . $Grouping . '</Grpg>
        			      <InitgPty>
        			        <Nm>' . $NameParty . '</Nm>
        			        <Id>
        			          <OrgId>
        			            <PrtryId>
        			              <Id>' . $SiretParty . '</Id>
        			            </PrtryId>
        			          </OrgId>
        			        </Id>
        			      </InitgPty>
        			    </GrpHdr>';
        	
        	$xml = '<?xml version="1.0" encoding="utf-8"?>
        <Document xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.02">
          <pain.001.001.02>
          ' . $GroupHeader . '
          ' . $PaymentInformation . '
          </pain.001.001.02>
        </Document>';
        	
        	//echo htmlspecialchars ( $xml );
        	
        	// URL FILE /////////////////////////////////////////

			$sepa_file    = 'sepa_xml' . date ( 'Y-m-dH-i-s' ) . '.txt';
        	$url_file     = $file_folder.'/'.$sepa_file;
        	
        	// FICHIER XML GÉNÉRÉ
        	$file_xml = fopen ( $url_file, 'a+' );
        	fputs ( $file_xml, '' );
        	fputs ( $file_xml, $xml );
        }      						 

	return ($sepa_file);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>









