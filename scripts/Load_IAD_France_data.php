<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  1. CHARGEMENT DES DONNEES IAD :
//         >> RECEPTION DU FICHIER TOUS LES SOIRS À 21H SUR LE SERVEUR : NOSREZO\IAD_PROXY\IAD_FILE 
//         >> LANCEMENT DU CRON À 21H30
//         >> FICHIER .CSV SCANNÉ, CONTRÔLÉ PUIS DÉPLACÉ POUR ARCHIVE : NOSREZO\IAD_PROXY\IAD_ARCHIVE
//         >> CHARGEMENT TABLE PARTNER_IAD
//
//  2. TRAITEMENT DES DONNÉES
//         >> ATTENTION AU PARRAIN NON ENCORE CHEZ NOSREZO
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function LOAD_DATA_IAD_FULL($connection_database2, $NosRezo_racine, $source_pays_partenaire)
{
       /// LOAD DES DATA IAD FRANCE VIA LE PLANNIFICATEUR DE TACHE N°1
       /// FREQUENCE : TOUS LES JOURS A 3H DU MATIN 
 
         $retour1            = "<br/>";	      
		 $retour2            = "<br/><br/>";     	     
		 $space1             = "&nbsp &nbsp &nbsp &nbsp &nbsp";       		 
		 $etat_chargement    = "KO";
         $raport_load_data   = " - LOAD_DATA_IAD_FULL".$retour1;	
			 	
             /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
             ///////////  1. IDENTIFICATION DU BON FICHIER A CHARGER : 
             ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			 
			 
			 IF ( $source_pays_partenaire == "france" ) { $chemin_vers_le_dossier  = $NosRezo_racine."/iad_proxy/IAD_file/"; }
			 ELSE                                       { $chemin_vers_le_dossier  = $NosRezo_racine."/iad_proxy/IAD_portugal/"; }
			 
             $file_data               = MOST_RECENT_FILE_TO_OPEN_IAD($chemin_vers_le_dossier);
			 IF ($file_data == "")    // PAS DE FICHIER CORRECT A CHARGER
			 {
			         $raport_load_data = $raport_load_data."&nbsp 1. Pas de fichier a charger !".$retour1;
			 }
			 ELSE     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			          //////////////////////// NOUS CHARGEONS LE FICHIER AU FORMAT CSV ///////////////////////////////////////////////////////////////////
					  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 { //#1
					 $file_data_last_updated  = date ('Y-m-d H:i:s', filemtime($chemin_vers_le_dossier."/".$file_data));
                     $file_data_size          = filesize($chemin_vers_le_dossier."/".$file_data);                     
					 $raport_load_data        = $raport_load_data."&nbsp 1. $file_data $retour1 cree le $file_data_last_updated - $file_data_size Ko $retour1";
  
					 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					 ///////  ANALYSE DU FICHIER CSV OU XSLX AVANT INSERTION DES DONNÉES DANS NOTRE TABLE TEMPORAIRE : PARTNER_IAD  ////
                     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					 $raport_load_data = $raport_load_data."&nbsp 2. Analyse du fichier csv".$retour1;
                     $nb_ligne	       = 0;				 
                     List($ligne_chargee, $nb_ligne, $ligne_non_insert)     = LOAD_DATA_IAD_FILE($connection_database2, $chemin_vers_le_dossier."/".$file_data, $source_pays_partenaire );
                     IF ($ligne_non_insert <> '') { $raport_load_data = $raport_load_data."&nbsp &nbsp &nbsp >> PB LIGNE : $ligne_non_insert - PB FORMAT.".$retour1;}					 
					 
					 IF ($ligne_chargee == 0)
					 {
                     $raport_load_data = $raport_load_data."&nbsp &nbsp &nbsp >> 0 ligne prise en compte sur $nb_ligne - PB FORMAT.".$retour1;	
                     }
                     ELSE					 
                     ////////////////////////////////////////////////////////////////////////////////////////////
					 /////////  TABLE PARTNER_IAD CHARGÉE - PARCOURS DES DONNEES DES AGENTS IAD	/////////////////				 
                     ////////////////////////////////////////////////////////////////////////////////////////////
					 {//#2 
                     $raport_load_data = $raport_load_data."&nbsp 3. Load $ligne_chargee / $nb_ligne lignes dans PARTNER_IAD ".$retour1;					 
                     $raport_load_data = $raport_load_data."&nbsp 4. Fichier déplacé : /IAD_archive ".$retour1;
					 
			         IF ( $source_pays_partenaire == "france" ) { rename($NosRezo_racine."/iad_proxy/IAD_file/".$file_data, $NosRezo_racine."/iad_proxy/IAD_archive/IAD Daily File - ".date('Y-m-d H-i-s',time()).".csv");}
			         ELSE                                       { rename($NosRezo_racine."/iad_proxy/IAD_portugal/".$file_data, $NosRezo_racine."/iad_proxy/IAD_archive/IAD Portugal File - ".date('Y-m-d H-i-s',time()).".csv");}					 
					 					 
 					 $etat_chargement = "OK";
								 
					 } //#2
             } /// FIN#1
			 
			 return array($raport_load_data, $etat_chargement, $nb_ligne);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function TRAITEMENT_DATA_IAD_FULL($NosRezo_racine, $connection_database2, $nb_ligne, $raport_load_data, $serveur, $source_script, $source_pays_partenaire)
{       //////////////// UNE FOIS LA TABLE PARTNER_IAD CHARGÉE NOUS TRAITONS LES DONNÉES IAD

         $retour1          = "<br/>";	      
		 $retour2          = "<br/><br/>";  
         $raport_load_data = $raport_load_data."&nbsp 5. Parcours des donnees de la table PARTNER_IAD :".$retour1;					 
		 $sql2        	   =  " SELECT   ligne, date_creation , iad_id, iad_email, iad_genre, iad_nom, iad_prenom, iad_phone, iad_adresse, iad_cp, iad_ville, iad_date_naissance, iad_lieu_naissance, iad_nationalite, iad_cp_secteur, iad_ville_secteur, iad_grade, iad_habilitation,  iad_date_debut_iad, iad_compromis, iad_last_compromis_date, iad_num_secu_sociale, iad_id_parrain , iad_mail_parrain , iad_statut_pro, iad_tva_intra , iad_rcs_rsac 
		                        FROM     partner_iad 
						        WHERE    is_managed = 0  ";
        $result_2          =  mysql_query($sql2) or die("Requete pas comprise - #PPPQ3AZ1! ");
						 
                         IF ( mysql_num_rows($result_2) < 1) 
						     { $raport_load_data = $raport_load_data."&nbsp >> Pas de nouveaux partenaires IAD à traiter".$retour1;	 }		
						 ELSE                                 
						     {   ///////////////////////////////////////////////////////////////////////////////////////////////////
								 ////////////////////////////     TRAITEMENT DES DONNÉES     ///////////////////////////////////////
                                 ///////////////////////////////////////////////////////////////////////////////////////////////////								 
   			                     $raport_load_data  = $raport_load_data."&nbsp &nbsp >> $nb_ligne partenaires contenus dans le fichier IAD ".$retour1;
								 $nb_ligne_en_cours = 1;
								 WHILE (  $reponse = mysql_fetch_array($result_2) )
                                 {    //#33
                                         List ($affiliate_already_exist, $id_partenaire, $id_upline, $email_p, $first_name_p, $last_name_p ) = CHECK_IF_FULL_NOSREZO_EXIST($reponse['iad_email'], $reponse['iad_phone'], $reponse['iad_prenom'], $reponse['iad_nom'], 0);                                        
										 /////////////////////////////////////////////////////////////////////////////////////////////////////////////
										 IF ($id_partenaire > 0 )    // LE PARTENAIRE EXISTE DANS LA BASE DONC IL DOIT FORCEMENT AVOIR ACCES A SON COMPTE PARTENAIRE
                                          { 
                                                 List ($id_affiliate, $id_partenaire, $first_name_a, $last_name_a, $email_a, $phone_number_a, $address_a, $zip_code_a, $city_a, $firt_last_id , $is_activated, $last_connection_date, $password, $p_sub_category, $p_company, $p_contact_mail,  $id_services, $recommanded_by, $p_zip_code, $p_city, $id_parrain, $partenaire_grade, $SIRET , $qcm_iad, $is_access_intranet  ) = RETURN_INFO_AFFILIATE_FROM_ID_PARTENAIRE($connection_database2, $id_partenaire ); 

												 // ON DONNE ACCÈS AU PARTENAIRE À L'INTRANET POUR GÈRER LES DÉSACTIVATIONS DUES AU PROBLÈME DE FICHIER IAD FRANCE
												 IF ( $is_access_intranet == 0)  { mysql_query(" UPDATE partner_list SET is_access_intranet = 1,  is_activated = 1 WHERE id_partner = $id_partenaire     "); }
						   
						                        // MISE A JOUR DU SECTEUR DU PARTENAIRE
												IF (trim($p_zip_code) <> trim($reponse['iad_cp_secteur']) )
                                                 {	 
                                                     //$source_script = "CRON OU FULL"												 
												     MAJ_SECTEUR_PARTENAIRE($id_partenaire, $reponse['iad_cp_secteur'], $reponse['iad_ville_secteur'], "", $source_script, $source_pays_partenaire);
													 $raport_load_data = $raport_load_data." ".$reponse['iad_email']." - MAJ SECTEUR $retour1 ";
												 }
                                                 ELSE IF (   strlen(trim($p_zip_code)) == 4  )
                                                 {	 
                                                     //$source_script = "CRON OU FULL"
                                                     echo "<br/>p_zip_code : ".$p_zip_code." et iad_cp_secteur : ".$reponse['iad_cp_secteur'];													 
												     MAJ_SECTEUR_PARTENAIRE($id_partenaire, $reponse['iad_cp_secteur'], $reponse['iad_ville_secteur'], "", $source_script, $source_pays_partenaire);
													 $raport_load_data = $raport_load_data." ".$reponse['iad_email']." - MAJ SECTEUR $retour1 ";
												 }
                                                 ELSE
                                                 {
												    //$raport_load_data = $raport_load_data."- NO MAJ SECTEUR $retour1";
                                                 }												 
										
											 /////////// MISE A JOUR DES INFORMATIONS ENTREPRISES 
												IF ( trim($reponse['iad_rcs_rsac']) <> $SIRET  )
                                                 {	 											 
													 UPDATE_PARTENAIRE_ENTREPRISE($id_partenaire, $reponse['iad_rcs_rsac'], $reponse['iad_tva_intra'], 1); 
													 $raport_load_data = $raport_load_data." ".$reponse['iad_email']." - MAJ SIRET $retour1 ";
												 }	
										 		
											///////////// MISE A JOUR DES INFORMATIONS SUR LE GRADE IAD 	 
												IF ( trim($partenaire_grade) <> trim($reponse['iad_grade']) )
                                                 {	 											 
													 MAJ_GRADE_PARTENAIRE($id_partenaire, trim($reponse['iad_grade']) );
												 }	
											   
										  }										 
									     ELSE
									      {   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									          ///////   LE PARTENAIRE N'EXISTE PAS  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
											  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
											    
												$is_activated = 3;	// IS_ACTIVATED = 3; -  LE PARTENAIRE N'A PAS REPONDU AU QCM IAD		                                 
											    
												//1. IDENTIFICATION DU PARRAIN DU NOUVEAU PARTENAIRE
												IF ( trim($reponse['iad_mail_parrain']) > 0) 
												   {  List ($id_parrain, $id_parrain_partenaire, $id_upline_du_parrain, $email_parrain, $first_name_parrain, $last_name_parrain ) = CHECK_IF_FULL_NOSREZO_EXIST( $reponse['iad_mail_parrain'], "66666666", "first_name", "last_name", 0); }
												ELSE
												   {  $id_parrain = 10;
											         IF (  $source_pays_partenaire == "portugal" ) { $id_parrain    = 11692; 
													                                                 $is_activated  = 1;          } // COMPTE IAD PORTUGAL
											         
											       }
												
												IF   ($id_parrain < 10)  { $id_parrain = 10;}
												
					                                  $p_rayon_level1               = 50;
											          $rayon_action                 = 10;
											          $s_category                   = "immobilier";
											          $fonction                     = "Conseiller immobilier";

											          $s_sub_category_code          = 1;
				                                      $id_partenaire                = id_partner_max_FROM_partner_list("");		
                                                      $s_sub_category               = s_sub_category_FROM_s_sub_category_code($s_sub_category_code); 
											          $com_nr_contrat_percent       = 0; // PAR DÉFAUT LA NÉGOCIATION DU CONTRAT EST A 0	
                                                      $why_recommand                = "Massive INSERT IAD ".$source_pays_partenaire;	
                                                      $is_access_intranet           = 1;													  

													  
												//2. INSERTION DANS LES TABLES NR DU PARTENAIRE ET/OU DE L'AFFILIÉ SI IL N'EXISTE PAS
				                                      $id_affiliate     = INSERT_INTO_PARTNER_LIST_MASTER($connection_database2, $reponse['iad_genre'], $id_partenaire, $s_category , $s_sub_category, $s_sub_category_code, "IAD", $reponse['iad_prenom'], $reponse['iad_nom'], $reponse['iad_phone'], $reponse['iad_email'], " ", $reponse['iad_adresse'], $reponse['iad_cp'], $reponse['iad_ville'], "", "", $rayon_action, $p_rayon_level1, "-", $fonction, $is_activated, $com_nr_contrat_percent, $id_parrain, $why_recommand, $reponse['iad_cp_secteur'], $reponse['iad_ville_secteur'], $reponse['iad_date_naissance'], $reponse['iad_lieu_naissance'], $reponse['iad_num_secu_sociale'], $is_access_intranet, "CRON", $serveur, $source_pays_partenaire );
  
													  INSERT_LOG_TRACK_ACTIONS( $id_partenaire, $reponse['iad_email'], 'Creation Nouveau partenaire', 'TRAITEMENT DATA_IAD_FULL.php','Mise à jour daily');
													  
													  $reponse55        = mysql_fetch_array(mysql_query("SELECT id_upline FROM affiliate WHERE id_affiliate = ".$id_affiliate."   ")) or die("Requete Load_IAD_France_data.php - #ZAEEE31! ");
                                                      IF ($reponse55['id_upline'] == $id_parrain ) {	$statut_parrain = $reponse55['id_upline']." BON PARRAIN IAD";}
                                                      ELSE         			                       {	$statut_parrain = $reponse55['id_upline']." MAUVAIS PARRAIN IAD MAIS PAS D ACTION";}										  
													  
													  $raport_load_data   = $raport_load_data." &nbsp &nbsp &nbsp >> L$nb_ligne_en_cours - CREATION PARTENAIRE :  ".$reponse['iad_email']." - A$id_affiliate - P$id_partenaire - Parrain A$statut_parrain  $retour1  ";
									     							 
										  }
										  
									$nb_ligne_en_cours = $nb_ligne_en_cours + 1;
									
								    // MISE A JOUR DES CALCUS DE POINTS POUR CHAQUE PARTENAIRES POUR L'ALGORITHME
									UPDATE_PARTNER_NOTATION_DATA($id_partenaire, $reponse['iad_compromis'], $reponse['iad_last_compromis_date'],  $reponse['iad_date_debut_iad'], $connection_database2 ); 
									
								    // FERMETURE DE LA LIGNE POUR PRÉCISER QUE LE TRAITEMENT EST REALISÉ
								    UPDATE_PARTNER_IAD($connection_database2, $reponse['ligne'] , 1);	
									
									//echo "<br/> $nb_ligne_en_cours - ".$reponse['iad_email']." ".$reponse['iad_phone']." ".$reponse['iad_prenom']." ".$reponse['iad_nom']; 
									//echo " - Ligne fermée pour ".$reponse['ligne'];
									
								 } //#33
								 

                             }
             return ($raport_load_data);

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function ATTRIBUTION_DES_BONS_PARRAINS_IAD($connection_database2, $NosRezo_racine, $source_pays_partenaire)
{     // ID_UPLINE = 10       = PARRAIN TEMPORAIRE
		 $sql2        	   =  " SELECT   ligne  FROM     partner_iad  ";
         $result_2          =  mysql_query($sql2) or die("Requete pas comprise - #PPqPQ3AZ1! ");				 
         echo mysql_num_rows($result_2)." Lignes dans partner_iad &nbsp ";

         $rapport_attribution = "<br/>&nbsp 6. ATTRIBUTION_DES_BONS_PARRAINS_IAD <br/>";	
		 $result = mysql_query(' SELECT pl.p_contact_mail, pi.iad_mail_parrain, id_affiliate, first_name, last_name, id_upline, id_partenaire 
		                         FROM affiliate aa, partner_list pl, partner_iad pi
		                         WHERE aa.is_activated = 1 
								 AND   aa.id_upline in ( 10, 11692) 
								 AND   aa.id_partenaire = pl.id_partner
								 AND   pl.id_services = 1
								 AND   pl.p_contact_mail like "%@iad%" 
								 AND   trim(pl.p_contact_mail) = trim(pi.iad_email)		 ')  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		 WHILE ($reponse = mysql_fetch_array($result))
             { 
				 IF ( trim($reponse['iad_mail_parrain']) <> "") 
				    { List ($id_parrain, $id_parrain_partenaire, $id_parrain_parrain, $email_parrain, $first_name_p, $last_name_p ) = CHECK_IF_FULL_NOSREZO_EXIST(trim($reponse['iad_mail_parrain']), "9999999999", "FIRST_NAME", "LAST_NAME", 0);     }
				 ELSE
				    {  $id_parrain = 10;}
				 
				 IF   ($id_parrain < 10)  { $id_parrain = 10;}
			     
				 // UPDATE AVEC LE BON PARRAIN SI IL EXISTE :
                 $id_affiliate = $reponse['id_affiliate'];
                 IF ($id_parrain > 10) 
				     {  
				         mysql_query(" UPDATE affiliate SET id_upline= $id_parrain  WHERE id_affiliate = $id_affiliate     "); 
				         $rapport_attribution = $rapport_attribution." >> OK : A$id_affiliate ".$reponse['p_contact_mail']." - NOUVEAU PARRAIN A$id_parrain $email_parrain <br/> ";
						 UPDATE_IS_PROTECTED_UP($connection_database2, $id_parrain , "is_protected" , "1" ); // LES PARRAINS NE PEUVENT PAS ETRE DÉSACTIVÉS
				     }
				 ELSE
				     {
				         $rapport_attribution = $rapport_attribution." &nbsp &nbsp - KO : A$id_affiliate  ".$reponse['p_contact_mail']." - NOUVEAU PARRAIN n'existe pas ! <br/> ";					 
					 } 
			 }
	     IF ($rapport_attribution == '') { $rapport_attribution = " - Aucune mise à jour réalisée"; }
	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function DESACTIVATION_PARTENAIRES_ANCIEN_IAD($connection_database2, $NosRezo_racine, $source_pays_partenaire)
{        
         // 0. ON COMPTE LA TABLE 
		 $sql2        	           =  " SELECT   ligne  FROM     partner_iad  ";
         $result_2                 =  mysql_query($sql2) or die("Requete pas comprise - #PPAAqPQ3AZ1! ");				 
         $ligne_dans_iad           =  mysql_num_rows($result_2);
         $rapport_attribution      = "&nbsp 7. DESACTIVATION_PARTENAIRES_ANCIEN_IAD <br/>";
         $compteur_reco_desactives = 0;		 

        IF ($ligne_dans_iad	> 2500)
        {		 
		 
         // 1. ON DÉSACTIVE LES PARTENAIRES  
		 $result = mysql_query(' SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, pl.p_zip_code, pl.p_city 
		                         FROM  partner_list pl
		                         WHERE pl.id_services = 1
								 AND   pl.p_contact_mail like "%@iad%" 
								 AND   (is_activated = 1 OR is_access_intranet = 1)
								 AND   trim(pl.p_contact_mail) not in ( SELECT trim(pi.iad_email) FROM partner_iad pi )  	')  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		

		WHILE ($reponse = mysql_fetch_array($result))
             { 			     
				 // 2. ON ENLEVE ACCÈS A CEUX QUI N'ONT PAS DE RECOMMANDATION EN COURS
                 $id_partner = $reponse['id_partner'];
		         $result2    = mysql_query(' SELECT count(*) as nb_reco_en_cours 
				                             FROM   recommandation_details 
											 WHERE  id_privileged_partner =	'.$id_partner.'  
											 AND    r_status > 2 and  r_status < 8 ')  or die(" Requete : #AAPTXPA pas comprise. ");				
                 $reponse2   = mysql_fetch_array($result2);
                 
				 IF ($reponse2['nb_reco_en_cours'] > 0) // DES RECO SONT EN COURS DE TRAITEMENT PAR LE PARTENAIRE
				 {
				      mysql_query(" UPDATE partner_list SET is_activated = 0 WHERE id_partner = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." #".$reponse2['nb_reco_en_cours'] ." REC <br/> ";
					  INSERT_LOG_TRACK_ACTIONS( $id_partner, $reponse['p_contact_mail'], 'désactivation partenaire 1', 'Load_IAD_France_data.php','Mise à jour daily');
					  $compteur_reco_desactives = $compteur_reco_desactives + 1;
				 }
				 ELSE  // ON FERME TOUT
				 {
				      mysql_query(" UPDATE partner_list SET is_activated = 0, is_access_intranet = 0 WHERE id_partner = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." -#CLOSE  <br/> ";
                      INSERT_LOG_TRACK_ACTIONS( $id_partner, $reponse['p_contact_mail'], 'désactivation partenaire 2', 'Load_IAD_France_data.php','Mise à jour daily');					  
                   
	             }
			 }
		}
 
	     $rapport_attribution = $rapport_attribution." <br/> TOTAL : ". $compteur_reco_desactives." PARTENAIRES À TRAITER <br/> "; 
	     $rapport_vacances_iad = VACANCES_PARTENAIRES_IAD($NosRezo_racine, $source_pays_partenaire);
		 $rapport_attribution = $rapport_attribution."<br/>".$rapport_vacances_iad;
		
	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function MAUVAISE_AFFILIATION_IAD($NosRezo_racine)
{     

         $rapport_attribution = " <br/>";	
		 $result = mysql_query(' SELECT pi.iad_email, pi.iad_mail_parrain, pl.p_contact_mail, id_partenaire , id_affiliate, first_name, last_name, id_upline 
		                         FROM affiliate aa, partner_list pl, partner_iad pi
		                         WHERE aa.is_activated = 1 
								 AND   aa.id_partenaire = pl.id_partner
								 AND   pl.id_services = 1
								 AND   pl.p_contact_mail like "%@iad%" 
								 AND   trim(pl.p_contact_mail) = trim(pi.iad_email)		 ')  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		 WHILE ($reponse = mysql_fetch_array($result))
             { 
				 $id_partenaire        = $reponse['id_partenaire'];
				 $id_affiliate         = $reponse['id_affiliate']; IF ($id_affiliate =="") {$id_affiliate = 0;}
				 $email_partenaire     = trim($reponse['p_contact_mail']);
				 $email_parrain_iad    = trim($reponse['iad_mail_parrain']);
				 $id_parrain_iad       = $reponse['id_upline'];
				 
				 IF ( $email_parrain_iad  <> "") 
				    { 
					
	                   $sql = "  SELECT count(ad.email) as nb_rows, ad.email, pl.p_contact_mail 
	  	                				     FROM affiliate aa, affiliate_details ad , partner_list pl
	  	                				     WHERE aa.id_affiliate = ad.id_affiliate 
											 AND   aa.id_partenaire = pl.id_partner
	  	                				     AND   aa.id_affiliate in (SELECT id_upline FROM affiliate where id_affiliate= ".$id_affiliate." )      ";
											 
											 //echo $sql."<br/><br/><br/>";
					   
					   $result222           = mysql_fetch_array(mysql_query($sql)) or die("Requete pas comprise - #3AA01R912! ");
                       
                       $mail_parrain_1            = trim($result222['email']);
					   $mail_parrain_2            = trim($result222['p_contact_mail']);

					   
					 IF ($email_parrain_iad <> $mail_parrain_1) // PB
					     {
						      IF ($email_parrain_iad <> $mail_parrain_2) // PB 
		                      {		              
 							  $rapport_attribution = $rapport_attribution." &nbsp - $email_partenaire DEVRAIT AVOIR COMME PARRAIN $email_parrain_iad AU LIEU DE $mail_parrain_1=$mail_parrain_2 <br/> ";
					           }
						 }
					
					}
			 }

	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function VACANCES_PARTENAIRES_IAD($NosRezo_racine, $source_pays_partenaire)
{        
	     
		 $nb_days_a_ajouter       = 0;
		 $date_jour               = date('Y-m-d ',time() + $nb_days_a_ajouter * 60*60*24 );
		 
		 // 0. ON COMPTE LA TABLE POUR S'ASSURER QU'IL N'Y A PAS DE PROBLEME
		 $sql2        	   =  " SELECT   ligne  FROM     partner_iad  ";
         $result_2         =  mysql_query($sql2) or die("Requete pas comprise - #PPAAqPQ3AZ1! ");				 
         $ligne_dans_iad   =  mysql_num_rows($result_2);
         $rapport_attribution = "&nbsp 8. VACANCES_PARTENAIRES_IAD <br/>";	

        IF ($ligne_dans_iad	> 2200)
        {		 
		 
         // 1. ON DÉSACTIVE TEMPORAIREMENT LES PARTENAIRES SAUT CEUX QUI ONT DES REMPLACANTS
         $sql    = " SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, pl.p_zip_code, pl.p_city, iad_date_debut_conges, iad_date_fin_conges
		                         FROM partner_list pl, partner_iad piad
		                         WHERE pl.id_services = 1
								 AND   pl.p_contact_mail like '%@iad%' 
								 AND   piad.iad_email = pl.p_contact_mail 
								 AND   IS_ACTIVATED   = 1
								 AND   iad_date_fin_conges >= iad_date_debut_conges
								 AND   \"".$date_jour."\" >= iad_date_debut_conges
								 AND   \"".$date_jour."\" <= iad_date_fin_conges  
								 AND   iad_date_debut_conges > '0000-00-00'
								 AND   id_part_nr_replacant = 0
                                 								 ";
         //echo $date_jour."<br/>".$sql."<br/><br/><br/>";
         // ATTENTION ON LAISSE ACTIF LES PARTENAIRES IAD QUI ONT CHOISI UN REMPLACANT	id_part_nr_replacant <> 0	 
		 $result = mysql_query($sql)  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		

		WHILE ($reponse = mysql_fetch_array($result))
             { 			     
                      $id_partner        = $reponse['id_partner'];
					  $date_debut_conges = $reponse['iad_date_debut_conges'];
					  $date_fin_conges   = $reponse['iad_date_fin_conges'];
                 
				      mysql_query(" UPDATE partner_list 
					                SET  is_activated      =  8, 
									     date_debut_conges = '$date_debut_conges',
                                         date_fin_conges   = '$date_fin_conges'										 
										 WHERE id_partner  = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." - VACANCES <br/> ";
			 }
			 
		 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
         // 2. ON REACTIVE LES PARTENAIRES 
		 $rapport_attribution = $rapport_attribution."<br/>";
         $sql2    = " SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, pl.p_zip_code, pl.p_city, iad_date_debut_conges, iad_date_fin_conges
		                         FROM partner_list pl, partner_iad piad
		                         WHERE pl.id_services = 1
								 AND   pl.p_contact_mail like '%@iad%' 
								 AND   piad.iad_email = pl.p_contact_mail 
								 AND   IS_ACTIVATED = 8
								 AND   iad_date_fin_conges >= iad_date_debut_conges
								 AND   \"".$date_jour."\" >= iad_date_fin_conges  
                                 								 ";
         //echo $date_jour."<br/>".$sql."<br/><br/><br/>";																 
		 $result2 = mysql_query($sql2)  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		

		WHILE ($reponse = mysql_fetch_array($result2))
             { 			     
                      $id_partner = $reponse['id_partner'];
				      mysql_query(" UPDATE partner_list SET is_activated = 1 WHERE id_partner = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." - RETOUR DE VACANCES <br/> ";
			 }			 
			 
			 
		}

	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function VA_BIENTOT_QUITTER_IAD($NosRezo_racine)
{       // FORMAT DE LA DATE 30/03/2015
        // ON FERME MEME AVANT AFIN D'EVITER DE LUI ENVOYER DES RECOMMANDATIONS INUTILES 
	     
		 $nb_days_a_ajouter       = 0;
		 $date_jour               = date('Y-m-d ',time() + $nb_days_a_ajouter * 60*60*24 );
		 
		 // 0. ON COMPTE LA TABLE POUR S'ASSURER QU'IL N'Y A PAS DE PROBLEME
		 $sql2        	          =  "SELECT   ligne  FROM     partner_iad  ";
         $result_2                =  mysql_query($sql2) or die("Requete pas comprise - #VA_BIENTOT_QUITTER_IAD! ");				 
         $ligne_dans_iad          =  mysql_num_rows($result_2);
         $rapport_attribution     = "&nbsp 9. VA_BIENTOT_QUITTER_IAD <br/>";	

        IF ($ligne_dans_iad	> 2000)
        {		 
		 
         // 1. ON DÉSACTIVE LES PARTENAIRES QUI VONT QUITTER IAD MÊME CEUX EN VACANCES
         $sql    = " SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, pl.p_zip_code, pl.p_city, date_reception_resiliation
		                         FROM partner_list pl, partner_iad piad
		                         WHERE pl.id_services = 1
								 AND   pl.p_contact_mail like '%@iad%' 
								 AND   piad.iad_email = pl.p_contact_mail 
								 AND   (IS_ACTIVATED = 1 OR IS_ACTIVATED = 8 OR IS_ACTIVATED = 3 OR IS_ACTIVATED = 9 )
								 AND   va_quitter_iad = 'Oui'						 ";
															 
		 $result = mysql_query($sql)  or die(" Requete coordonnees : #ASPL pas comprise. ");				
		

		WHILE ($reponse = mysql_fetch_array($result))
             { 			     
                      $id_partner        = $reponse['id_partner'];
                 
				      mysql_query(" UPDATE partner_list 
					                SET  is_activated      =  2									 
								    WHERE id_partner       = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." <br/> ";
			 }
			 
		}

	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
