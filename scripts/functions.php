<?php  function REQUETE_AFF_DETAILS_CHAMPS($id_affiliate, $level) 
{    // LISTE DES TOUS LES CHAMPS RELATIFS À L'AFFILIÉ
	 $requete_a_retourner =  " af.id_affiliate, IFNULL(id_upline, 0) as id_upline, af.password, ad.first_name, ad.last_name, CONCAT(ad.first_name, ' ', ad.last_name) as first_and_last_name, ad.address, ad.zip_code, ad.city, ad.phone_number, ad.email, ad.numero_de_pack, is_protected, ad.creation_date, ad.birth_place, ad.nationality, ad.birth_date, af.last_connection_date, af.is_activated, ad.contract_signed, af.id_partenaire ,  id_securite_sociale, affiliate_latitude, affiliate_longitude, ".$level." as niveau ";		 
	 return ($requete_a_retourner);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function RETURN_INFO_AFFILIATE($id_affiliate)
{    ///////////////////////////////////////////////////// #1111
     mysql_query('SET NAMES utf8');
	 $result              = mysql_fetch_array(mysql_query(" 
	                         SELECT count(*) as is_exist, ".REQUETE_AFF_DETAILS_CHAMPS($id_affiliate, 0)."
						     FROM   affiliate af, affiliate_details ad 
						     WHERE  af.id_affiliate = ad.id_affiliate 
						     AND    af.id_affiliate = ".$id_affiliate."      " )) or die("Requete pas comprise - #3QW0912! "); 
  
     $id_parrain            = $result['id_upline'];	
     $id_partenaire         = $result['id_partenaire'];
     $first_name_p          = $result['first_name'];	
     $last_name_p           = $result['last_name'];	
     $email_p               = $result['email'];
     $phone_number_p        = $result['phone_number'];
     $address_p             = $result['address'];
     $zip_code_p            = $result['zip_code'];
     $city_p                = $result['city'];
     $is_activated          = $result['is_activated'];  
     $last_connection_date  = $result['last_connection_date']; 
	 $firt_last_id          = $result['first_name'] .' '. $result['last_name'].' [ID : '. $result['id_affiliate'].']';
	 $password              = $result['password'];
     $is_protected          = $result['is_protected'];
     $first_and_last_name   = $result['first_and_last_name'];	 
	
     return array($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p, $address_p, $zip_code_p, $city_p, $firt_last_id , $is_activated, $last_connection_date, $password, $is_protected, $first_and_last_name ); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function RETURN_INFO_PARRAIN( $id_affiliate)
{    ///////////////////////////////////////////////////// #2222
     mysql_query('SET NAMES utf8');
	 $result              = mysql_fetch_array(mysql_query(" 
	                         SELECT count(aa.id_affiliate) as nb_ligne, aa.id_affiliate, aa.id_partenaire, aa.password, aa.id_upline, aa.is_activated, aa.first_name, aa.last_name, ad.email, ad.phone_number, ad.address, ad.zip_code, ad.city, last_connection_date 
						     FROM affiliate aa, affiliate_details ad 
						     WHERE aa.id_affiliate = ad.id_affiliate 
						     AND aa.id_affiliate in (SELECT id_upline FROM affiliate where id_affiliate=".$id_affiliate.")  ")) or die("Requete pas comprise - #301R912! ");
  
     $id_parrain            = $result['id_affiliate'];	
     $id_partenaire         = $result['id_partenaire'];
     $first_name_p          = trim($result['first_name']);	  IF ($first_name_p == "") { $first_name_p = "Le siège NosRezo"; }
     $last_name_p           = trim($result['last_name']);	
     $email_p               = trim($result['email']);
     $phone_number_p        = trim($result['phone_number']);
     $address_p             = trim($result['address']);
     $zip_code_p            = trim($result['zip_code']);
     $city_p                = trim($result['city']);
     $is_activated          = $result['is_activated'];  
     $last_connection_date  = $result['last_connection_date']; 
	 $firt_last_id          = $result['first_name'] .' '. $result['last_name'].' [ID : '. $result['id_affiliate'].']';
	 $password              = trim($result['password']);
     $id_parrain_parrain    = $result['id_upline'];	

     return array($id_parrain, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p, $address_p, $zip_code_p, $city_p, $firt_last_id , $id_parrain_parrain, $is_activated, $last_connection_date, $password ); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function VALUE_TO_CHECK_NORRIS($connection_database, $value_to_check ) 
{    
	 $value_to_check = trim(stripslashes($value_to_check));
	 $value_to_check = trim(addslashes($value_to_check)); 

	 return ($value_to_check);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_TABLE_ONE_FIELD_QUERY($connection_database, $table_to_update, $field_key, $id_key, $id_field, $c_value, $source ) 
{
	 date_default_timezone_set('Europe/Paris');	
	 $c_value = VALUE_TO_CHECK_NORRIS( $connection_database, $c_value );	
	 
     IF ( $c_value == "NOW" )
     {	
         $sql_to_update = " UPDATE  $table_to_update 
	                        SET     $id_field   =  CURRENT_TIMESTAMP							 
	                        WHERE   $field_key  = :id_key          ";			
	 } 
	 ELSE IF ( $id_key > 0 )
     {		
         $sql_to_update = " UPDATE  $table_to_update 
	                        SET     $id_field   = :c_value								 
	                        WHERE   $field_key  = :id_key          ";
	 }	
	 
   	    $result = $connection_database->prepare( $sql_to_update );
   		$result->bindParam(":c_value", $c_value, PDO::PARAM_STR);
   		$result->bindParam(":id_key", $id_key, PDO::PARAM_INT);
   		$result->execute();
	 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function RETURN_INFO_RECOMMANDATION($id_recommandation)
{    ///////////////////////////////////////////////////// #3333
         mysql_query('SET NAMES utf8');
         $result                 = mysql_fetch_array(mysql_query(" 
		                            SELECT count(id_recommandation) as is_exist, r_creation_date, id_recommandation, id_affiliate, r_status, r_category, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, r_lat, r_long, r_devis_ttc, montant_tva_percent, r_gain_TTC, r_gain, duplicate_id_recommandation, choose_to_not_pay  , filename_facture_reco
		                            FROM recommandation_details 
		                            WHERE id_recommandation = ".$id_recommandation."   ")) or die("Requete pas comprise - #3EFP0912! ");               

         $r_creation_date              = $result['r_creation_date'];
         $r_category                   = $result['r_category'];		 
         $r_lat                        = $result['r_lat'];
         $r_long                       = $result['r_long'];
         $r_devis_ttc                  = $result['r_devis_ttc'];
         $montant_tva_percent          = $result['montant_tva_percent'];
         $r_gain_TTC                   = $result['r_gain_TTC'];
         $r_gain                       = $result['r_gain'];
         $duplicate_id_recommandation  = $result['duplicate_id_recommandation'];
         $choose_to_not_pay            = $result['choose_to_not_pay'];		 
         $r_sub_category               = $result['r_sub_category'];
         $r_status                     = $result['r_status'];
		 $r_sub_category_code          = $result['r_sub_category_code'];
	     $id_privileged_partner        = $result['id_privileged_partner'];
		 $r_last_name                  = $result['r_last_name'];
		 $r_first_name                 = $result['r_first_name'];
		 $r_city                       = $result['r_city'];
		 $r_zip_code                   = $result['r_zip_code'];
		 $r_address                    = $result['r_address'];
		 $r_type                       = $result['r_type'];
		 $r_phone_number               = $result['r_phone_number'];
		 $r_email                      = $result['r_email'];		 
         $id_affiliate                 = $result['id_affiliate'];		 
		 $r_connection_with            = $result['r_connection_with'];
		 $r_commentary                 = $result['r_commentary'];
		 $filename_facture_reco        = $result['filename_facture_reco'];

     return array($r_sub_category_code, $id_affiliate, $id_privileged_partner, $r_lat, $r_long, $r_last_name,  $r_first_name, $r_sub_category, $r_city, $r_zip_code, $r_address, $r_type, $r_phone_number, $r_email, $r_connection_with, $r_commentary, $r_creation_date, $r_status, $r_category, $r_devis_ttc, $montant_tva_percent, $r_gain_TTC, $r_gain, $duplicate_id_recommandation, $choose_to_not_pay, $filename_facture_reco  ); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function RETURN_INFO_AFFILIATE_FROM_ID_PARTENAIRE($connection_database2, $id_partenaire)
{    ///////////////////////////////////////////////////// #1111
     mysql_query('SET NAMES utf8');
	 $result              = mysql_fetch_array(mysql_query(" 
	                         SELECT count(aa.id_affiliate) as is_exist, aa.id_affiliate, aa.id_partenaire, aa.password, aa.id_upline, aa.is_activated, aa.first_name, aa.last_name, ad.email, ad.phone_number, ad.address, ad.zip_code, ad.city, aa.last_connection_date, pl.p_sub_category, pl.id_services, pl.p_contact_mail, pl.p_company, pl.recommanded_by, pl.p_zip_code, pl.p_city, partenaire_grade , pl.SIRET, qcm_iad, is_access_intranet
						     FROM affiliate aa, affiliate_details ad, partner_list pl 
						     WHERE aa.id_affiliate = ad.id_affiliate 
							 AND  aa.id_partenaire = pl.id_partner
						     AND  aa.id_partenaire = ".$id_partenaire."     ")) or die("Requete pas comprise - #RETURN_INFO_AFFILIATE_FROM_ID_PARTENAIRE ! ");
  
     $id_parrain            = $result['id_upline'];
     $id_affiliate          = $result['id_affiliate'];	
     $id_partenaire         = $result['id_partenaire'];
     $first_name_a          = $result['first_name'];	
     $last_name_a           = $result['last_name'];	
     $email_a               = $result['email'];
     $phone_number_a        = $result['phone_number'];
     $address_a             = trim($result['address']);
     $zip_code_a            = $result['zip_code'];
     $city_a                = $result['city'];
     $is_activated          = $result['is_activated'];  
     $last_connection_date  = $result['last_connection_date']; 
	 $firt_last_id          = trim($result['first_name'] .' '. $result['last_name'].' [ID : '. $result['id_affiliate'].']');
	 $password              = $result['password']; 
	 $p_sub_category        = $result['p_sub_category']; 	 
	 $p_company             = $result['p_company']; 		 
	 $p_contact_mail        = $result['p_contact_mail']; 	
	 $id_services           = $result['id_services']; 
	 $recommanded_by        = $result['recommanded_by']; 
	 $p_zip_code            = $result['p_zip_code']; 
	 $p_city                = $result['p_city']; 
	 $partenaire_grade      = $result['partenaire_grade']; 
	 $SIRET                 = trim($result['SIRET']);
	 $qcm_iad               = $result['qcm_iad'];
     $is_access_intranet    = $result['is_access_intranet'];	 
	 
     return array($id_affiliate, $id_partenaire, $first_name_a, $last_name_a, $email_a, $phone_number_a, $address_a, $zip_code_a, $city_a, $firt_last_id , $is_activated, $last_connection_date, $password, $p_sub_category, $p_company, $p_contact_mail,  $id_services, $recommanded_by, $p_zip_code, $p_city, $id_parrain, $partenaire_grade, $SIRET, $qcm_iad, $is_access_intranet  ); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $id_affiliate, $field_to_update, $value_to_take) 
{
		 $value_to_take = stripslashes($value_to_take);
		 $value_to_take = addslashes($value_to_take);  
		 
		 $sql = " UPDATE affiliate_details 
		          SET  $field_to_update     = \"$value_to_take\"
		 		  WHERE id_affiliate        = '$id_affiliate' "; 
		 mysql_query($sql) or die("Requete UPDATE_AFFILIATE DETAILS_FIELD pas comprise #AZ8JJ9");	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_IS_PROTECTED_UP($connection_database2, $id_affiliate, $field_to_update, $value_to_take) 
{  // MODULE DE PROTECTION DE L'AFFILIÉ ET SON PARRAIN : ILS NE POURRONT PAS ÊTRE DÉSACTIVÉS
   // TABLE AFFILIATE_DETAILS / CHAMPS : IS_PROTECTED
   
   //  RÈGLES :
   //  --------
   // 1. DÈS QUE JE PARRAINE QUELQU'UN      : JE SUIS PROTÉGÉ
   // 2. DÈS QUE JE FAIS UNE RECOMMANDATION : JE SUIS PROTÉGÉ [AINSI QUE MON PARRAIN]

   
		 UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $id_affiliate, $field_to_update, $value_to_take);
		 $id_affiliate = RETURN_ID_PARRAIN($id_affiliate); 
		 UPDATE_AFFILIATE_DETAILS_FIELD($connection_database2, $id_affiliate, $field_to_update, $value_to_take);	
		 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_PLUS_1($connection_database, $id_recommandation) 
{

				mysql_query(" UPDATE recommandation_details 
				              SET count_relance_paiement    = count_relance_paiement + 1, 
							  r_managed_date  = CURRENT_TIMESTAMP 
							  WHERE id_recommandation = '$id_recommandation'   ");            
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function IS_NUM($var)
{
	 IF (is_numeric($var))    { return (1);} 
	 ELSE                     { return (0);}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function SING_PLUR($mot_a_changer, $nb, $maj_ou_min) 
{
     IF ($nb > 1)          { $mot_a_changer = $mot_a_changer."s"; }
     ELSE IF ($nb < -1)    { $mot_a_changer = $mot_a_changer."s"; }
	 ELSE                  { $mot_a_changer = $mot_a_changer;     }

	 IF ($maj_ou_min == 1) {$mot_a_changer = strtoupper($mot_a_changer) ;}
	 
     return ($mot_a_changer);							
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function ID_AFFILIATE_FROM_ID_RECOMMANDATION($id_recommandation)
{ // 
     $result = mysql_fetch_array(mysql_query("SELECT id_affiliate FROM recommandation_details where id_recommandation =".$id_recommandation."  limit 0,1   ")) or die("Requete pas comprise - #30912! ");
     $id_affiliate = $result['id_affiliate'];	
	 
     return ($id_affiliate); 
}
?>


<?php  function COUNT_RECOMMANDATION_TO_PARTNER($id_partner)
{ // 
     $result = mysql_fetch_array(mysql_query(" SELECT count(id_recommandation) as nb_reco_recu 
	                                           FROM recommandation_details 
											   where id_privileged_partner = ".$id_partner."    ")) or die("Requete pas comprise - #3AA0912! ");
     $nb_reco_recu = $result['nb_reco_recu'];	
	 
     return ($nb_reco_recu); 
}
?>


<?php  function ID_AFFILIATE_MAXIMUM($connection_database, $param)
{ // 

	 $result            = mysql_fetch_array(mysql_query(" SELECT IFNULL(max(id_affiliate)+1, 1) as id_affiliate 
	                                                      FROM affiliate_details ")) or die("Requete pas comprise - #MAX! ");
     $id_affiliate_max  = $result['id_affiliate'];
	 	 
     return ($id_affiliate_max); 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function RETURN_IF_IS_SOCIETE($connection_database, $societe, $id_partner, $id_services)
{ 
     IF ( $id_services == 1 OR $id_services == 50 OR $id_services == 4 )
	 {
		 $is_company = "";
	 }
	 ELSE
	 {
     $sql = " SELECT count(id_partner) as is_company 
	          FROM   partner_list 
	          WHERE  id_partner  = $id_partner 
	 		  AND    id_services  = $id_services
			  AND   (p_company like \"%$societe%\"  OR  why_recommand like \"%$societe%\"  OR  site_web like \"%$societe%\"  )  ";

     $result      = $connection_database->query( $sql );
	 $reponse     = $result->fetch(PDO::FETCH_ASSOC);	 
	 IF ( $reponse['is_company'] > 0 ) {  $is_company  = $societe; }
     ELSE 	                           {  $is_company = "";        }
     }	 
     return ($is_company); 
}
?>


<?php  function RETURN_MAX_FACTURE_TO_TAKE($param)
{ // 

	 $result            = mysql_fetch_array(mysql_query(" SELECT IFNULL(max(facture_num_chronos)+1, 1) as facture_num_chronos 
	                                                      FROM recommandation_facture ")) or die("Requete pas comprise - #MAfacture_num_chronosX! ");
     $facture_num_chronos  = $result['facture_num_chronos'];
	 	 
     return ($facture_num_chronos); 
}
?>



<?php  function RETURN_INFO_SUR_LA_DATE($date) 
{ // FORMAT DE $date = date("Y-m-d H:i:s")
    IF ( strlen($date) == 10 ) { $date = $date." 00:00:00"; }
    IF ( strlen($date) == 7 )  { $date = $date."-01 00:00:00"; }
	
            // TABLEAU DES JOURS DE LA SEMAINE
            $joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
			
            // EXTRACTION DES JOUR, MOIS, AN DE LA DATE
            list($annee, $mois, $jour)       = explode('-', substr(trim($date), 0, 10));
            list($heure, $minute, $seconde)  = explode(':', substr(trim($date), 11, 10));
			
            // CALCUL DU TIMESTAMP
            $timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
			
            // AFFICHAGE DU JOUR DE LA SEMAINE
            $jour_de_la_semaine =  $joursem[date("w",$timestamp)];
			
                   IF ($mois == 1)  { $mois_a_afficher = "Jan";   $mois_a_afficher2 = "Janvier";          }
              ELSE IF ($mois == 2)  { $mois_a_afficher = "Fév";   $mois_a_afficher2 = "Février";          }			  
              ELSE IF ($mois == 3)  { $mois_a_afficher = "Mars";  $mois_a_afficher2 = "Mars";         }	
              ELSE IF ($mois == 4)  { $mois_a_afficher = "Avr";   $mois_a_afficher2 = "Avril";          }	
              ELSE IF ($mois == 5)  { $mois_a_afficher = "Mai";   $mois_a_afficher2 = "Mai";          }	
              ELSE IF ($mois == 6)  { $mois_a_afficher = "Juin";  $mois_a_afficher2 = "Juin";         }	
              ELSE IF ($mois == 7)  { $mois_a_afficher = "Jui";   $mois_a_afficher2 = "Juillet";          }	
              ELSE IF ($mois == 8)  { $mois_a_afficher = "Aout";  $mois_a_afficher2 = "Aout";         }	
              ELSE IF ($mois == 9)  { $mois_a_afficher = "Sept";  $mois_a_afficher2 = "Septembre";         }	
              ELSE IF ($mois == 10) { $mois_a_afficher = "Oct";   $mois_a_afficher2 = "Octobre";          }	
              ELSE IF ($mois == 11) { $mois_a_afficher = "Nov";   $mois_a_afficher2 = "Novembre";          }	
              ELSE IF ($mois == 12) { $mois_a_afficher = "Déc";   $mois_a_afficher2 = "Décembre";          }	
			
 
	 return array($jour, $mois, $annee, $jour_de_la_semaine, $timestamp, $heure, $minute, $seconde, $mois_a_afficher, $mois_a_afficher2 ); 
}
?>

<?php  function id_partner_to_p_contact_name($id_partner)
{ // 
     $p_contact = "-";
	 if ($id_partner == 0) {return (" Pas de partenaire choisi");}
	 
	 mysql_query('SET NAMES utf8');	 
	 $result         = mysql_fetch_array(mysql_query("SELECT CONCAT( p_first_name, ' ', p_last_name ) AS p_contact FROM partner_list where id_partner =".$id_partner."   ")) or die("Requete pas comprise - #3BGA0912! ");
     $p_contact      = $result['p_contact'];	
	 
     return ($p_contact); 
}
?>


<?php  function NOM_PRENOM_AFFILIATE($id_affiliate)
{ // 
	 
	 mysql_query('SET NAMES utf8');	 
	 $result         = mysql_fetch_array(mysql_query("SELECT count(*) as is_xist, CONCAT( first_name, ' ', last_name )  AS p_contact FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #AA3BGA0912! ");
     $p_contact      = $result['p_contact'];	
	 
     return ($p_contact); 
}
?>

<?php  function IS_APPORTEUR($id_affiliate)
{ // UN APPORTEUR EST UN AFFILIATE DONT NOUS AVONS RECU SON CONTRAT
  // 0 : is not apporteur
  // 1 : is apporteur
  
     $result = mysql_fetch_array(mysql_query(" SELECT contract_signed 
	                                           FROM affiliate_details 
											   where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #3091! ");
     $is_apporteur = $result['contract_signed'];	
	 
     return ($is_apporteur); 
}
?>


<?php  function RETURN_ID_AFFILIATE_FROM_PARTENAIRE($id_partenaire)
{ 
     $result = mysql_fetch_array(mysql_query(" SELECT id_affiliate 
	                                           FROM affiliate
											   where id_partenaire =".$id_partenaire."  limit 0,1   ")) or die("Requete pas comprise - #3091! ");
     $id_affiliate = $result['id_affiliate'];	
	 
     return ($id_affiliate); 
}
?>


<?php function randomPassword()
{
     $numAlpha=6;
     $numNonAlpha=0;
     $listAlpha = 'abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
     $listNonAlpha = ',;:!?.$/*-+&@_+;./*&?$-!,';
     return str_shuffle(
         substr(str_shuffle($listAlpha),0,$numAlpha) .
         substr(str_shuffle($listNonAlpha),0,$numNonAlpha)
    );
}
?>


<?php  function CHECK_PARRAIN_EXIST($connection_database, $id_parrain, $nom_parrain_1) 
{
    $nom_parrain     = strtolower($nom_parrain_1);
    $nom_parrain_maj = strtoupper($nom_parrain_1);
	
	if (empty($id_parrain) or empty($nom_parrain) or ($id_parrain == "ID") or ($nom_parrain == "Nom") ) 
	{return (0);}
	if (intval($id_parrain)) { $ca_marche = "OK";} // On check que c'est un integer en format string
	else {return (0);}
	
    include('config.php'); 
    mysql_query('SET NAMES utf8');
	$sql    = " SELECT count(*) as parrain_exist, 
	                   lower( trim( ad.last_name ) ) AS last_name, 
	                   lower( trim( ad.first_name ) ) AS first_name,
					   ad.last_name  AS last_name2, 
					   ad.first_name AS first_name2, 
	                   upper( trim( ad.last_name ) ) AS last_name3, 
	                   upper( trim( ad.first_name ) ) AS first_name3
	            FROM   affiliate_details ad, affiliate aa 
				WHERE  aa.id_affiliate = ad.id_affiliate 
				AND   aa.id_affiliate  = ".$id_parrain."      ";   			
    $result = mysql_fetch_array(mysql_query($sql)) or die(" Oups, cet identifiant n'est pas valide. Merci ce contacter le support à contact@nosrezo.com !  ");

              IF ($result['last_name']   == $nom_parrain)                          {  return (1);  }
		 ELSE IF ($result['first_name']  == $nom_parrain)                          {  return (1);  }
         ELSE IF ($result['last_name']   == utf8_encode($nom_parrain))             {  return (1);  }
		 ELSE IF ($result['first_name']  == utf8_encode($nom_parrain))             {  return (1);  }
		 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 ELSE IF ($result['first_name2'] == $nom_parrain)                          {  return (1);  }
		 ELSE IF ($result['last_name2']  == $nom_parrain)                          {  return (1);  }
		 ELSE IF ($result['first_name2'] == utf8_encode($nom_parrain) )            {  return (1);  }
		 ELSE IF ($result['last_name2']  == utf8_encode($nom_parrain) )            {  return (1);  }		 
		 ELSE IF ($result['first_name2'] == $nom_parrain_1)                        {  return (1);  }
		 ELSE IF ($result['last_name2']  == $nom_parrain_1)                        {  return (1);  }
		 ELSE IF ($result['first_name2'] == utf8_encode($nom_parrain_1) )          {  return (1);  }
		 ELSE IF ($result['last_name2']  == utf8_encode($nom_parrain_1) )          {  return (1);  }	
         /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 ELSE IF ($result['first_name3'] == $nom_parrain_maj)                      {  return (1);  }
		 ELSE IF ($result['last_name3']  == $nom_parrain_maj)                      {  return (1);  }
		 ELSE IF ($result['first_name3'] == utf8_encode($nom_parrain_maj))         {  return (1);  }
		 ELSE IF ($result['last_name3']  == utf8_encode($nom_parrain_maj))         {  return (1);  }		 
		 ELSE IF ($result['first_name3'] == $nom_parrain_1)                        {  return (1);  }
		 ELSE IF ($result['last_name3']  == $nom_parrain_1)                        {  return (1);  }
		 ELSE IF ($result['first_name3'] == utf8_encode($nom_parrain_1))           {  return (1);  }
		 ELSE IF ($result['last_name3']  == utf8_encode($nom_parrain_1))           {  return (1);  }

		 
		 ELSE IF ($result['last_name'].' '.$result['first_name'] == $nom_parrain)  {  return (1);  }
		 ELSE IF ($result['last_name'].''.$result['first_name']  == $nom_parrain)  {  return (1);  }
		 ELSE IF ($result['first_name'].' '.$result['last_name'] == $nom_parrain)  {  return (1);  }
         ELSE {return (0);} // PAS DE CORRESPONDANCE


}
?>

<?php  function COUNT_PRESCRIPTION_POUR_AFFILIE($id_affiliate) 
{
	if ($id_affiliate == 0) {$sql = "SELECT * FROM recommandation_details    ";}
	else                    {$sql = "SELECT * FROM recommandation_details where id_affiliate=".$id_affiliate." and r_status > 0 and r_status < 10   ";}              
    $result = mysql_query($sql) or die("Site en maintenance : contact@nosrezo.com : 1 ");
    return (mysql_num_rows($result));
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_PRESCRIPTION_POUR_PARTENAIRE($id_partenaire) 
{
    include('config.php'); 
	if ($id_partenaire == 0) {$sql = "SELECT * FROM recommandation_details where r_status > 2 and r_status < 8    ";}
	else                     {$sql = "SELECT * FROM recommandation_details where id_privileged_partner = ".$id_partenaire." and r_status > 2 and r_status < 8   ";}              
    $result = mysql_query($sql) or die("Site en Maintenance - contact@nosrezo.com : 2 ");
    return (mysql_num_rows($result));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_PARTNER_NOTATION($id_partner) 
{
	$sql    = " SELECT  count(id_recommandation) as nb_inter
	            FROM    partner_notation_details 
	            WHERE   id_partner       = ".$id_partner."  
                AND     is_activated = 1					";
										
    $result = mysql_fetch_array(mysql_query($sql)) or die("Site Partenaire en maintenance #55- contact@nosrezo.com ");
	
    return ($result['nb_inter']);  
}
?>

<?php  function COUNT_PARTENAIRES($id_services) 
{
    include('config.php'); 
	if ($id_services == 0 ) //TOUS LES SERVICES
	   {$sql = "SELECT * FROM partner_list where is_activated = 1 "; }
    else                    //FILTRE SUR UN SEUL SERVICE
	   {$sql = "SELECT * FROM partner_list where is_activated = 1 and id_services =".$id_services."    "; }
   
    $result = mysql_query($sql) or die("Requete pas comprise ! ");
    return (mysql_num_rows($result));
}
?>


<?php  function COUNT_INTRANEWS($id_affiliate) 
{
    include('config.php'); 
	$sql = "SELECT * FROM intranews where n_is_displayed = 1 ";               
    $result = mysql_query($sql) or die("Requete pas comprise ! ");
    return (mysql_num_rows($result));
}
?>


<?php  function MAIL_PARRAIN_AFFILIE($id_affiliate) 
{
	include('config.php'); 
	$idupline = mysql_fetch_array(mysql_query("SELECT id_upline FROM affiliate where id_affiliate=".$id_affiliate." limit 0,1  ")) or die("Requete pas comprise - #31! ");
	if (empty($idupline['id_upline'])) 
	     { 
		     return($mail_parrain_siege);
		 }
	else
	     {
	         $result = mysql_fetch_array(mysql_query("SELECT email FROM affiliate_details where id_affiliate =".$idupline['id_upline']."   ")) or die("Requete pas comprise - #31! ");
	         return ($result['email']);
		 }
}
?>


<?php  function OWNER_ACTION_ADMIN($id_affiliate) 
{   // SOIT BENJAMIN [1], SOIT KARIM [2]
    if (($id_affiliate == 1) or ($id_affiliate == 2)) {return ($id_affiliate);}
	else
	{
         include('config.php'); 
         $affiliate_en_cours = $id_affiliate; 
	     $idupline = mysql_fetch_array(mysql_query("SELECT id_upline, id_affiliate FROM affiliate where id_affiliate = ".$affiliate_en_cours."   ")) or die("Requete pas comprise - #ZAEEE31! ");
   		  while ($idupline['id_upline'] <> 0)
		         {
	                 $affiliate_en_cours = $idupline['id_upline'] ; 
				     $idupline = mysql_fetch_array(mysql_query("SELECT id_upline, id_affiliate FROM affiliate where id_affiliate = ".$affiliate_en_cours."   ")) or die("Requete pas comprise - #ZZAE31! ");
		         }
         if ($idupline['id_upline'] == 0) 
		        { 
				  if ($idupline['id_affiliate'] == 1)   {return (1);}
				  if ($idupline['id_affiliate'] == 2)   {return (2);}	
				  if ($idupline['id_affiliate'] == 11)  {return (1);}
				  if ($idupline['id_affiliate'] == 12)  {return (2);}
				} 			 
    }
}
?>



<?php  function PHONE_PARRAIN_AFFILIE($id_affiliate) 
{
    include('config.php'); 
	$idupline = mysql_fetch_array(mysql_query("SELECT id_upline FROM affiliate where id_affiliate=".$id_affiliate." limit 0,1  ")) or die("Requete pas comprise - #31! ");
	if (empty($idupline['id_upline'])) 
	     { 
		     return($telephone_siege);
		 }
	else
	     {
	         $result = mysql_fetch_array(mysql_query("SELECT phone_number FROM affiliate_details where id_affiliate =".$idupline['id_upline']."   ")) or die("Requete pas comprise - #31! ");
	         return ($result['phone_number']);
		 }
}
?>

<?php  function RETURN_ID_PARRAIN($id_affiliate) 
{
    include('config.php'); 
	if ($id_affiliate == 0) 
	     { 
		     return(0);
		 }
	else
	     {	
	      $idupline = mysql_fetch_array(mysql_query(" SELECT id_upline 
		                                              FROM affiliate where id_affiliate=".$id_affiliate."  ")) or die("Requete pas comprise - #1732! ");
	      return($idupline['id_upline']); 
		 }
}///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function NOM_PRENOM_ID_PARRAIN_AFFILIE($connection_database2, $id_upline) 
{
    include('config.php'); 
	IF (is_num($id_upline) == 0)       { $id_upline = 0; }	
	IF ($id_upline == 0) 
	     { 
		     return($nom_prenom_parrain_siege);
		 }
	ELSE
	     {
	         $sql = "SELECT first_name, last_name, id_affiliate FROM affiliate_details where id_affiliate =".$id_upline."   ";
			 $result  = mysql_fetch_array(mysql_query($sql)) or die("Requete pas comprise - #9031! ");
	         $resultat = $result['first_name'] .' '. $result['last_name'].' [ID : '. $result['id_affiliate'].']';
			 return ($resultat);
		 }
}
?>

<?php  function INFO_PARRAIN_AFFILIATE($connection_database2, $id_upline) 
{
	         mysql_query('SET NAMES utf8');
			 IF ( is_num($id_upline) == 0) { $id_upline = 0; }
			 
             $result   = mysql_fetch_array(mysql_query("SELECT count(*) as is_exist, first_name, last_name, email, phone_number 
                                                        FROM affiliate_details 
                                                        WHERE id_affiliate = ".$id_upline."   ")) or die("Requete pas comprise - #9031! ");
        
	
	         
			 IF ( $result['is_exist'] == 0 )
			 {
			 $name_parrain  = "NosRezo";
			 $email_parrain = "contact@nosrezo.com";
			 $tel_parrain   = "0608508812";				 
			 }
			 ELSE
			 {
			 $name_parrain  = trim($result['first_name']) .' '. trim($result['last_name']);
			 $email_parrain = trim($result['email']);
			 $tel_parrain   = trim($result['phone_number']);
			 }
			 
			 return array($name_parrain, $email_parrain, $tel_parrain);
}
?>


<?php function removeAccents_use($string) {
	    if ( !preg_match('/[\x80-\xff]/', $string) )
	        return $string;

	    $chars = array(
	    // Decompositions for Latin-1 Supplement
	    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
	    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
	    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
	    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
	    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
	    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
	    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
	    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
	    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
	    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
	    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
	    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
	    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
	    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
	    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
	    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
	    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
	    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
	    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
	    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
	    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
	    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
	    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
	    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
	    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
	    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
	    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
	    chr(195).chr(191) => 'y',
	    // Decompositions for Latin Extended-A
	    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
	    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
	    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
	    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
	    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
	    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
	    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
	    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
	    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
	    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
	    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
	    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
	    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
	    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
	    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
	    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
	    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
	    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
	    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
	    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
	    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
	    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
	    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
	    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
	    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
	    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
	    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
	    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
	    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
	    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
	    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
	    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
	    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
	    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
	    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
	    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
	    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
	    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
	    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
	    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
	    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
	    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
	    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
	    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
	    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
	    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
	    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
	    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
	    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
	    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
	    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
	    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
	    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
	    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
	    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
	    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
	    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
	    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
	    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
	    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
	    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
	    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
	    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
	    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
	    );

	    $string = strtr($string, $chars);

	    return $string;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function nb_page_tableau($max_line, $nb_rows)
{
 	 $nb_page = ceil($nb_rows / $max_line);
     if ($nb_page == 0) {$nb_page = 1 ;} // Si pas de prescription, ou d'intranews ou... on affiche quand même une page
	 return ($nb_page);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_INTO_AFFILIATE_DETAILS($connection_database2, $id_upline, $id_affiliate, $id_partenaire, $status, $gender, $first_name, $last_name, $address, $zip_code, $city, $phone_number, $email, $creation_date, $pseudo, $birth_date, $birth_place, $nationality, $contract_signed, $is_able_to_develop, $affiliate_latitude, $affiliate_longitude)  
{
                $is_protected = 0;
				// 1. TOUS LES PARTENAIRES SONT PROTÉGÉS ET NE PEUVENT PAS ÊTRE DÉSACTIVÉS POUR L'INSTANT 
				IF ( $id_partenaire > 0 ) 
				    { 
				     $is_protected = 1; 
					 UPDATE_IS_PROTECTED_UP($connection_database2, $id_upline , "is_protected" , "1" ); // AINSI QUE LEURS PARRAINS QU'ON PROTÉGENT TOUT DE SUITE AU CAS OU 
					 } 
				
				// 2. TOUS LES AFFILIÉS SONT ILLIMITÉS SI LEUR PARRAIN EST PORTUGAIS
                ELSE // ON RENTRE ICI QUE SI $is_protected <> 1
				{
				List ( $country, $is_protected ) = RETURN_PAYS_AFFILIATE( $id_upline ) ;
                }				
					 
					 
				$sql = 'insert into affiliate_details(id_affiliate, status, gender, first_name, last_name, address, zip_code, city, phone_number, email, creation_date, pseudo, birth_date, birth_place, nationality, contract_signed, is_able_to_develop, affiliate_latitude, affiliate_longitude, is_protected) 
				                             values (
											 "'.$id_affiliate.'",
											 "'.$status.'",
											 "'.$gender.'",
											 "'.$first_name.'",
											 "'.$last_name.'",
											 "'.$address.'",
											 "'.$zip_code.'",
											 "'.$city.'",
											 "'.$phone_number.'",
											 "'.$email.'",
											 "'.date("Y-m-d H:i:s").'",
											 " ",
											 "'.$birth_date.'",
											 "'.$birth_place.'",
											 "'.$nationality.'",
											 "0",
											 "0",
											 "'.$affiliate_latitude.'",
											 "'.$affiliate_longitude.'",
											 "'.$is_protected.'"  ) ';
		         mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise insert into affiliate_details - function.php ");

				 $details  = "Nouvel affilié : ".$first_name." ".$last_name." ".$zip_code." ".$city." - ".$email." - ".$phone_number."   ";
                 INSERT_ACTION_LIST("Nouvel affilié", 1, "ID Affilié : [ ".$id_affiliate." ]", 0,0,$id_affiliate, "FERME", $details ,"", "Service Admin", 0, "");
                 INSERT_INTO_AFFILIATE($id_affiliate, $first_name, $last_name, $id_upline, $id_partenaire);
				 INSERT_TIMELINE( 1, 1, 0 , $city, "", $gender, $id_affiliate,"", 0, "", ""  );
				 
   			     return (1);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_INTO_PARTNER_LIST_VISITE($id_affiliate_cible, $id_affiliate_qui_visite) 
{
	
	IF ( $id_affiliate_cible <> $id_affiliate_qui_visite AND $id_affiliate_qui_visite > 0 AND $id_affiliate_qui_visite > 10)
	{
		
     $result       =  mysql_fetch_array(mysql_query(" SELECT count(id_ligne) as ligne_deja_inseree
						                              FROM partner_list_visite  
						                              WHERE creation_date > DATE_SUB( CURDATE(),  INTERVAL 1 HOUR) 
													  AND id_affiliate_qui_visite  = ". $id_affiliate_qui_visite ."    
													  AND id_affiliate_cible       = ". $id_affiliate_cible."      ")) or die("Requete pas comprise - INSERT_INTO_PARTNER_LIST_VISITE ");
     $ligne_deja_inseree =  $result['ligne_deja_inseree'];
		
	        IF ( $ligne_deja_inseree == 0 )
	        {		 
				$sql ='insert into partner_list_visite(id_ligne, id_affiliate_cible, id_affiliate_qui_visite, creation_date) 
				                             values (
											 "",
											 "'.$id_affiliate_cible.'",
                                             "'.$id_affiliate_qui_visite.'",
											 CURRENT_TIMESTAMP )
											 ';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete pas comprise INSERT_INTO_PARTNER_LIST_VISITE - function.php ");  
	        }				
	}				
   	return (1);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function INSERT_INTO_AFFILIATE($id_affiliate, $first_name, $last_name, $id_upline, $id_partenaire) 
{
				$sql ='insert into affiliate(id_affiliate, is_activated, first_name, last_name, id_upline, password, last_connection_date, id_partenaire) 
				                             values (
											 "'.$id_affiliate.'",
											 "1",
											 "'.$first_name.'",
											 "'.$last_name.'",
											 "'.$id_upline.'",
											 "'.randomPassword().'",
											 CURRENT_TIMESTAMP,
											 "'.$id_partenaire.'")
											 ';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete pas comprise insert_into_affiliate - function.php ");            
   			    return (1);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_INTO_RECOMMANDATION_ANNULEE($id_recommandation, $r_motif, $r_detail, $id_affiliate_qui_a_fermer) 
{ // NosRezo12345678911_4.php
  // Intranet_Nouvelle_recommandation_suivi.php
  
				$sql ='insert into recommandation_annulee(id_recommandation, r_creation_date, r_motif, r_detail, id_affiliate_qui_a_fermer) 
				                             values (
											 "'.$id_recommandation.'",
											 CURRENT_TIMESTAMP,
											 "'.$r_motif.'",
											 "'.$r_detail.'",
											 "'.$id_affiliate_qui_a_fermer.'" )
											 ';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete pas comprise insert_into_recommandation_annulee - function.php ");            
   			    return ("OK");
}
?>

<?php  function insert_log_track_actions($id_affiliate, $first_name, $action, $page_php, $details) 
{
                include('config.php');				
				//date_default_timezone_set('Europe/Paris');
				$sql ='insert into log_track_action(l_date, id_affiliate, first_name, l_action, l_page_php, l_details) 
				                             values (
											 "'.date("Y-m-d H:i:s").'",
											 "'.$id_affiliate.'", 
											 "'.$first_name.'",
											 "'.$action.'",
											 "'.$page_php.'",
											 "'.$details.'" )
											 ';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die(" ");            
   			    return ("OK");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_FILLEUL_LEVEL($id_affiliate, $level) 
{
	      IF ($level == 1 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate WHERE is_activated = 1 and id_upline = ".$id_affiliate." ")) or die("Requete pas comprise - #1! "); }
	 ELSE IF ($level == 2 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_affiliate."   ) ")) or die("Requete pas comprise - #2! "); }
	 ELSE IF ($level == 3 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_affiliate." )) ")) or die("Requete pas comprise - #3! "); }
	 ELSE IF ($level == 4 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_affiliate." )  )) ")) or die("Requete pas comprise - #333! "); }
	 ELSE IF ($level == 5 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_affiliate." ) )  )) ")) or die("Requete pas comprise - #3AQZ! "); }
	 ELSE IF ($level == 6 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_affiliate." ) ) )  )) ")) or die("Requete pas comprise - #3! "); }
	 
     $nb_affiliate = $result['id_affiliate'];
	 
	return ($nb_affiliate);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function COUNT_RECOMANDATION_LEVEL($id_affiliate, $level) 
{
	      IF ($level == 1 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate=".$id_affiliate." ")) or die("Requete pas comprise - #4! "); }
	 ELSE IF ($level == 2 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ")) or die("Requete pas comprise - #5! "); }
	 ELSE IF ($level == 3 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." )) ")) or die("Requete pas comprise - #6! "); }
	 ELSE IF ($level == 4 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) )) ")) or die("Requete pas comprise - #7! "); }
	 ELSE IF ($level == 5 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ) )) ")) or die("Requete pas comprise - #7! "); }
	 ELSE IF ($level == 6 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ) ) )) ")) or die("Requete pas comprise - #7! "); }
	 ELSE IF ($level == 7 ) { $result = mysql_fetch_array(mysql_query("SELECT count(id_recommandation) as id_recommandation FROM recommandation_details where r_status > 0 and r_status < 10 and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ) ) ) )) ")) or die("Requete pas comprise - #7! "); }

     $nb_recommandation = $result['id_recommandation'];
	 
	 return ($nb_recommandation);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function COUNT_SUM_GAIN_RECO_LEVEL( $id_affiliate, $level, $coeff_mlm ) 
{

	      IF ($level == 1 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate=".$id_affiliate." ")) or die("Requete pas comprise - #8! ");   }
	 ELSE IF ($level == 2 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ")) or die("Requete pas comprise - #9! "); }
	 ELSE IF ($level == 3 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." )) ")) or die("Requete pas comprise - #10! "); }
	 ELSE IF ($level == 4 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) )) ")) or die("Requete pas comprise - #11! "); }
	 ELSE IF ($level == 5 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." )  ) )) ")) or die("Requete pas comprise - #11! "); }
	 ELSE IF ($level == 6 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) )  ) )) ")) or die("Requete pas comprise - #11! "); }
	 ELSE IF ($level == 7 ) { $result = mysql_fetch_array( mysql_query("SELECT sum(r_gain) as sum_des_gains FROM recommandation_details where r_status in (7) and id_affiliate in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline in (SELECT id_affiliate FROM affiliate where id_upline=".$id_affiliate." ) ) )  ) )) ")) or die("Requete pas comprise - #11! "); }
		  
	 $sum_des_gains = round( $result['sum_des_gains'] * $coeff_mlm  , 0, PHP_ROUND_HALF_DOWN);
	 
	 return ($sum_des_gains);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function COUNT_COMMISSION_COMPTABLE_LEVEL( $id_affiliate, $level ) 
{
     $result = mysql_fetch_array( mysql_query("SELECT sum(ax_amount_ht) as ax_amount_ht FROM recommandation_comptable WHERE aX_level = ".$level." and aX_payed in (0,5) and aX_id_affiliate = ".$id_affiliate."     ")) or die("Requete pas comprise - #A8! ");
     $sum_ax_amount_ht = $result['ax_amount_ht'];
	 
	 return( $sum_ax_amount_ht );
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function GESTION_DE_ACTION_MAX_DATE($action_creation_date, $action_id_category, $id_recommandation, $prochaine_echeance, $compteur_relance, $source, $mode) 
{    // - $DATE_A_RELANCER_AUTOMATIQUE    : DATE À LAQUELLE LE PARTENAIRE EST RELANCÉ AUTOMATIQUEMENT PAR LE CRON AVANT INTERVENTION DU BACKOFFICE 
     // - $ACTION_MAX_DATE                : DATE À PARTIR DE LAQUELLE LE BACKOFFICE INTERVIENT 
     
	//date_default_timezone_set('Europe/Paris');
	List($jour, $mois, $annee, $jour_de_la_semaine,  $timestamp, $heure, $minute, $seconde ) = return_info_sur_la_date($action_creation_date) ;
	$date_a_relancer_automatique = date('Y-m-d H:i:s',time()+$prochaine_echeance*24*3600);    // DATE A LAQUELLE ON RELANCE LES PARTENAIRES CAR ILS ONT CHOISIS CETTE DATE
	$prochaine_echeance          = $prochaine_echeance + 1;                                   // LE BACK OFFICE INTERVIENT 1 JOURNÉE APRÈS LE RAPPEL DE L'ÉCHÉANCE SI PAS DE MISE À JOUR
	$message = "";
	
	// SI ÉTAPE 3   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //              INTERVENTION DU BACKOFFICE AU BOUT DE 48H OUVRÉ ENTRE 8H ET 20H
    IF ($action_id_category == 13 AND $source == "NEW") // ÉTAPE 3 NOUVELLE RECOMMANDATION SOUMISE AUX RELANCES
		     { 

                     IF ($compteur_relance == 0)  {  $date_a_relancer_automatique = date('Y-m-d H:i:s',time()+6*3600);    // RELANCE À 6H 
					                                 $message = " \n - Relance mail 1 : ". date('Y-m-d H:i') ."  ";  }
													 
                ELSE IF ($compteur_relance == 1)  {  $date_a_relancer_automatique = date('Y-m-d H:i:s',time()+6*3600);    // RELANCE À 6H 
				                                     $message = " \n - Relance mail 2 : ". date('Y-m-d H:i') ."  ";  }
													 
                ELSE IF ($compteur_relance == 2)  {  $date_a_relancer_automatique = date('Y-m-d H:i:s',time()+12*3600);   // RELANCE À 12H 
				                                     $message = " \n - Relance mail 3 : ". date('Y-m-d H:i') ."  ";  }

                ELSE IF ($compteur_relance == 3)  {  $date_a_relancer_automatique = date('Y-m-d H:i:s',time()+12*3600);   // RELANCE À 12H 
				                                     $message = " \n - Relance SMS : ". date('Y-m-d H:i') ."  ";  }
				            			                                                                                   // ENSUITE ENVOI SMS A 48H		 

		           IF ( $jour_de_la_semaine == 'jeudi')    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				         { 
					         $prochaine_echeance = 4;      // LE BACKOFFICE INTERVIENT LE LUNDI PAS AVANT
					     } 
		      ELSE IF ( $jour_de_la_semaine == 'vendredi') ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			             { 
					          $prochaine_echeance = 4;     // LE BACKOFFICE INTERVIENT LE MARDI PAS AVANT	
						 } 		  
		      ELSE IF ( $jour_de_la_semaine == 'samedi')   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			             { 
					          $prochaine_echeance = 4;     // LE BACKOFFICE INTERVIENT LE MERCREDI PAS AVANT
						 } 
		      ELSE IF ( $jour_de_la_semaine == 'dimanche') ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			             { 
					          $prochaine_echeance = 3;     // LE BACKOFFICE INTERVIENT LE MERCREDI PAS AVANT
						 } 			  
		      ELSE  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                      
    				     {   
							  $prochaine_echeance = 2;     // LE BACKOFFICE INTERVIENT À 48H PAS AVANT
						 } 
			  }   



																																		
    $action_max_date =  date('Y-m-d H:i:s',time()+$prochaine_echeance*24*3600); 
	return array($action_max_date, $date_a_relancer_automatique, $message);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function RETURN_ACTION_STATUS_INT($statut) 
{
    IF ( trim($statut) == "OUVERT" )  { $action_status_int = 1; }
	ELSE                              { $action_status_int = 0; }
	
    return ( $action_status_int );
}
?>


<?php  function INSERT_ACTION_LIST($action_category, $action_id_category, $action_details, $id_recommandation, $id_partner, $id_affiliate, $statut, $description, $description_2, $owner_action, $prochaine_echeance, $source) 
{ //////////////////////////////////////////////////////////
  // MODULE D'INSERTION DES ACTIONS À TRAITER PAR LE BACKOFFICE NOSREZO - MODULE TRÈS IMPORTANT
  
  // - $ACTION_MAX_DATE                : DATE À PARTIR DE LAQUELLE LE BACKOFFICE INTERVIENT 
  // - $ACTION_CATEGORY                : ÉTAPE EN COURS SOUS LE FORMAT "ÉTAPE 1"
  // - $ACTION_ID_CATEGORY             : IDENTIFIANT DE L'ÉTAPE EN COURS [11, 12, ...]  
  // - $ACTION_DETAILS                 : STATUT ENVOYÉ À L'AFFILIÉ 
  // - $ACTION_STATUT                  : OUVERT OU FERMER 
  // - $DESCRIPTION                    : STATUT SUR LA RECOMMANDATION VISIBLE PAR LE BACK OFFICE POUR UN SUIVI COMPLET ET RAPIDE 
  // - $DESCRIPTION_2                  : 
  // - $COMPTEUR_RELANCE               : COMPTEUR DE RELANCE POUR LE SUIVI DES ÉTAPES 2 AVANT FERMETURE SI NÉCESSAIRE  
  // - $DATE_A_RELANCER_AUTOMATIQUE    : DATE À LAQUELLE LE PARTENAIRE EST RELANCÉ AUTOMATIQUEMENT PAR LE CRON  
  // - $source                         : CONNAITRE QUI APPELLE CE SCRIPT POUR RELANCE SPECIFIQUE [SI NEW ALORS RELANCCE, SI PARTENAIRE RELANCES DIFFERENTES... ]  
  
  
	 //date_default_timezone_set('Europe/Paris');
	 List($action_max_date, $date_a_relancer_automatique, $message) =  GESTION_DE_ACTION_MAX_DATE(date('Y-m-d H:i:s'), $action_id_category, $id_recommandation, $prochaine_echeance, 0,  $source, "NON URGENT"); 
	 
	 $sql_insert_al ='insert into action_list(id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, date_a_relancer_automatique, relance_automatique, compteur_relance, source_action) 
				                             values (
											 "",
											 "'.date("Y-m-d H:i:s").'",
											 "'.$action_max_date.'",
											 "'.$action_category.'",
											 "1",
											 "'.$action_id_category.'",
											 "'.$action_details.'",
											 "'.$id_recommandation.'",
											 "'.$id_partner.'",
											 "'.$id_affiliate.'",
											 "'.$statut.'",
											 "'.RETURN_ACTION_STATUS_INT($statut).'",
											 "'.$description.'",
											 "'.$description_2.'",
											 "2",
											 "'.$owner_action.'", 
											 "'.$date_a_relancer_automatique.'",
											 "0",
                                             "0",
                                             "'.$source.'"											 )';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql_insert_al) or die("Requete INSERT_ACTION_LIST pas comprise via functions.php"); 
}
?>

<?php  function INSERT_ACTION_LIST_BACKUP($connection_database2, $id_action ) 
{ //////////////////////////////////////////////////////////
  // MODULE D'INSERTION DES ACTIONS À TRAITER PAR LE BACKOFFICE NOSREZO - MODULE TRÈS IMPORTANT
 
     $reponse4     = mysql_fetch_array(mysql_query(" SELECT id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, date_a_relancer_automatique, relance_automatique, compteur_relance, source_action
                                                 	 FROM   action_list 
													 WHERE  id_action = ".$id_action." limit 0,1 ")) ;

	 $action_details = str_replace("\"", "", $reponse4['action_details']);
	 $action_details = stripslashes($action_details);
	 $action_details = addslashes($action_details); 
	 
	 $description = str_replace("\"", "", $reponse4['description']);
	 $description = stripslashes($description);
	 $description = addslashes($description); 

	 $description_2 = str_replace("\"", "", $reponse4['description_2']);
	 $description_2 = stripslashes($description_2);
	 $description_2 = addslashes($description_2); 	 

     IF ( $reponse4['id_action'] > 0 )
     {
	 $sql_insert_al ='insert into action_list_backup(id_action, action_creation_date, action_max_date, action_category, action_priority, action_id_category, action_details, id_recommandation, id_partner, id_affiliate, action_statut, action_status_int, description, description_2, owner_id, owner_action, date_a_relancer_automatique, relance_automatique, compteur_relance, source_action) 
				                             values (
											 "'.$id_action.'",
											 "'.$reponse4['action_creation_date'].'",
											 "'.$reponse4['action_max_date'].'",
											 "'.$reponse4['action_category'].'",
											 "'.$reponse4['action_priority'].'",
											 "'.$reponse4['action_id_category'].'",
											 "'.$action_details.'",
											 "'.$reponse4['id_recommandation'].'",
											 "'.$reponse4['id_partner'].'",
											 "'.$reponse4['id_affiliate'].'",
											 "'.$reponse4['action_statut'].'",
											 "'.$reponse4['action_status_int'].'",
											 "'.$description.'",
											 "'.$description_2.'",
											 "'.$reponse4['owner_id'].'", 
											 "'.$reponse4['owner_action'].'", 
											 "'.$reponse4['date_a_relancer_automatique'].'", 
											 "'.$reponse4['relance_automatique'].'",  
											 "'.$reponse4['compteur_relance'].'", 
											 "'.$reponse4['source_action'].'"					 )';
		     mysql_query('SET NAMES utf8');
             $result = mysql_query($sql_insert_al) or die("Requete INSERT_ACTION_LIST_BACKUP KO [ID_action à insérer $id_action ] : <br/> ".$sql_insert_al); 
				
             $sql_delete = "DELETE FROM action_list  WHERE id_action = ".$id_action."  "; 
  	         mysql_query($sql_delete); 
	 }
}
?>


<?php  function CHECK_IF_AFFILIATE_ALREADY_EXIST($connection_database, $email) 
{

	$sql = " SELECT ad.id_affiliate 
	         FROM affiliate_details ad, affiliate aa
	         WHERE email = \"$email\"  
			 AND ad.id_affiliate  = aa.id_affiliate
             AND aa.is_activated  = 1			 ";               
    $result = mysql_query($sql) or die("Requete pas comprise ! ");
    return (mysql_num_rows($result));
}
?>

<?php  function CHECK_IF_AFFILIATE_ALREADY_EXIST_RETURN_ID($email) 
{
    include('config.php'); 	
	$result = mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as count_id, id_affiliate from affiliate_details where email=\"$email\" limit 0,1  ")) or die("Requete pas comprise - #QHB31! ");
	if ($result['count_id'] == 0)     { return (0); }	
	else                              { return ($result['id_affiliate']); }	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function NB_FILLEUL_AFFILIATE($id_affiliate) 
{   //    NUMERO_DE_PACK = 0;    -  LIMITÉ À 5 FILLEULS PAR MOIS
    //    NUMERO_DE_PACK = 1;    -  ASSOCIATION - ILLIMITÉ EN NOMBRE DE FILLEULS
    //    NUMERO_DE_PACK = 2;    -  COMPTE PRO  - ILLIMITÉ EN NOMBRE DE FILLEULS	
    //	  return array(10, 0, 0, "ben", "ben", "0608508812", 4);
	
	$max_filleul = 10;
	$nb_place_disponible = 0;

	// 1. ON COMPTE LE NOMBRE DE FILLEUL DE $ID_AFFILIATE
	$result  = mysql_fetch_array(mysql_query("   SELECT count(aa.id_affiliate) as count_id
  	                                             FROM affiliate aa
				                                 WHERE  aa.id_upline    = '$id_affiliate' 
                                                 AND    aa.is_activated = 1 	   ")) or die("Requete pas comprise - #COUNTQHB31! ");
    $nb_filleul = $result['count_id']; 

	// 2. ON CHECK SI $ID_AFFILIATE EST UN PARTENAIRE
	$id_partenaire = 0;
    $result2 = mysql_fetch_array(mysql_query("   SELECT count(*) as IS_PARTENAIRE, aa.id_partenaire 
				                                 FROM affiliate aa, partner_list pl 
				                                 WHERE aa.id_partenaire = pl.id_partner 
				                                 AND (pl.is_activated = 1 OR pl.is_activated = 8 )
				                                 AND aa.id_affiliate = '$id_affiliate' 
				                                 AND aa.is_activated = 1 ")) or die("Requete pas comprise - #COUNTQHB32! ");

	// 3. ON REMONTE LES INFORMATIONS DE $ID_AFFILIATE 
	$result3  = mysql_fetch_array(mysql_query(" SELECT count(*) as if_exist, first_name, phone_number, email, numero_de_pack
  	                                            FROM affiliate_details ad 
				                                WHERE  ad.id_affiliate = '$id_affiliate'    ")) or die("Requete pas comprise - #COUNTQHB33! ");
    $numero_de_pack = $result3['numero_de_pack'];	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	     IF ( $nb_filleul <= $max_filleul)    {  $is_able_to_invit = 1; $nb_place_disponible = $max_filleul - $nb_filleul; }  // OK - IL N'A PAS UTILISÉ SON QUOTA DE RECRUTEMENT
	    
  		 IF ($numero_de_pack  == 1)           {  $is_able_to_invit = 1;  }  // OK - ASSOCIATION DONC ILLIMITÉ
	ELSE IF ($numero_de_pack  == 2)           {  $is_able_to_invit = 1;  }  // OK - COMPTE PRO  - ILLIMITÉ EN NOMBRE DE FILLEULS
	ELSE IF ($result2['IS_PARTENAIRE']  > 0) // SI C'EST UN PARTENAIRE CHECKONS LE MAX PAR MOIS
	     { 
		     $id_partenaire    = $result2['id_partenaire'];
			 //date_default_timezone_set('Europe/Paris');
			 $today = date("Y-m-d");                             // 2015-08-10
			 list($annee, $mois, $jour) = explode('-', $today);
             $resultAZE = mysql_fetch_array(mysql_query(
	                      "SELECT count(*) as NB_AFFILIATE_BY_CURRENT_MONTH, aa.id_partenaire 
	         			   FROM affiliate aa, affiliate_details ad 
	         			   WHERE aa.id_affiliate = ad.id_affiliate
						   AND   aa.id_upline = '$id_affiliate' 
	         			   AND   aa.is_activated = 1
                           AND   substring(ad.creation_date,1,4) = ".$annee." 
						   AND   substring(ad.creation_date,6,2) = ".$mois." 		   ")) or die("Requete pas comprise - #MONTHQHB32! ");
	         $NB_AFFILIATE_BY_CURRENT_MONTH      = $resultAZE['NB_AFFILIATE_BY_CURRENT_MONTH']; 
			
	         IF ( $NB_AFFILIATE_BY_CURRENT_MONTH <= $max_filleul) { $is_able_to_invit = 1; $nb_place_disponible = $max_filleul - $NB_AFFILIATE_BY_CURRENT_MONTH; }
		     ELSE                                                 { $is_able_to_invit = 0;}						 

		 }
	ELSE                      // AFFILIÉ NON PARTENAIRE DONC LIMITÉ À 10                  
	     { 
		     $id_partenaire = 0;
	         IF ( $nb_filleul <= $max_filleul) { $is_able_to_invit = 1; $nb_place_disponible = $max_filleul - $nb_filleul;}
		     ELSE                              { $is_able_to_invit = 0;}
		 }
		 
	 
		 
	return array($nb_filleul, $id_partenaire, $is_able_to_invit, $result3['first_name'], $result3['email'], $result3['phone_number'], $nb_place_disponible, $numero_de_pack);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function COUNT_FILLEULS_LEVEL($connection_database, $id_affiliate, $level) 
{
	
    IF ($level == 1 )
	{
         $result = $connection_database->prepare( " SELECT id_affiliate FROM affiliate 
	                                                WHERE  is_activated = 1 
							                        AND    id_upline = :id_affiliate    " );

    }
	ELSE IF ($level == 2 )
	{	
         $result = $connection_database->prepare( " SELECT id_affiliate FROM affiliate 
	                                                WHERE  is_activated = 1 
							                        AND    id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline = :id_affiliate   )   " );	
    }
	
    $result->execute(array(':id_affiliate' => $id_affiliate));
	$count_nb_affiliate = $result->rowCount();	
	return ($count_nb_affiliate);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function IS_ABLE_TO_PARRAINER($connection_database, $id_affiliate) 
{        //    NUMERO_DE_PACK = 0;    -  LIMITÉ À 5 FILLEULS PAR MOIS
         //    NUMERO_DE_PACK = 1;    -  ASSOCIATION - ILLIMITÉ EN NOMBRE DE FILLEULS
         //    NUMERO_DE_PACK = 2;    -  COMPTE PRO  - ILLIMITÉ EN NOMBRE DE FILLEULS	
         
	     $max_filleul         = 5;
	     $multiple_filleul    = 2; // 2 FOIS PLUS DE SOUS FILLEULS QUE DE FILLEUL
	     $nb_place_disponible = 0;
	     $is_able_to_invit    = 0; 
		 $grade_nosrezo       = "AFFILIÉ";
         $is_protected        = 0;		 
         
	     // 1. ON COMPTE LE NOMBRE DE FILLEUL DE $ID_AFFILIATE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		 
		 $nb_filleul_L1                = COUNT_FILLEULS_LEVEL($connection_database,  $id_affiliate , 1);    // ON COMPTE LES FILLEULS DE NIVEAU 1
		 $nb_filleul_L2                = COUNT_FILLEULS_LEVEL($connection_database,  $id_affiliate , 2);    // ON COMPTE LES FILLEULS DE NIVEAU 2
	     $multiple_de_5_L1             = (int)($nb_filleul_L1 / $max_filleul);
	     $multiple_de_5_L2             = (int)($nb_filleul_L2 / $max_filleul);
		 
	     $multiple_de_calcul           = round( $multiple_de_5_L2/2 + 1, 0, PHP_ROUND_HALF_DOWN);
		 
		 //echo "<br/> - Multiple L2 de 5 : ".$nb_filleul_L2." filleuls / 5 = ".$multiple_de_5_L2;
		 //echo "<br/> - multiple_de_calcul : ".$multiple_de_calcul."<br/><br/>";
	       
	     // 2. ON REMONTE LES INFORMATIONS DE $ID_AFFILIATE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		                
         $result = $connection_database->prepare( " SELECT count(*) as if_exist, first_name, phone_number, email, numero_de_pack, is_protected
  	                                                FROM   affiliate_details ad 
	     			                                WHERE  ad.id_affiliate = :id_affiliate    " );
         $result->execute(array(':id_affiliate' => $id_affiliate));
         $reponse3 = $result->fetch(PDO::FETCH_ASSOC); 
         $numero_de_pack = $reponse3['numero_de_pack'];	
		 $is_protected   = $reponse3['is_protected'];	 
		 
		
	     
	     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
	     IF ( $numero_de_pack <> 0)
	     {
	     	  $is_able_to_invit     = 1;
			  $grade_nosrezo        = "";
			  $nb_place_disponible  = 100;
	     }
	     ELSE
	     { 
              $nb_place_disponible = $multiple_de_calcul * $max_filleul  - $nb_filleul_L1 ;
			  IF ( $nb_filleul_L1 == 0 ) { $nb_filleul_L1 = 1; }
              IF ( $nb_place_disponible > 0 )            { $is_able_to_invit    = 1; }	

	     	  IF (  $nb_filleul_L2 >= 10 )    
	                     {     
                              $grade_nosrezo       = "ASSOCIÉ ÉCHELON #".$multiple_de_5_L1;							   
	                     }  
         }   
         
	  return array($nb_filleul_L1, $nb_filleul_L2, $is_able_to_invit, $reponse3['first_name'], $reponse3['email'], $reponse3['phone_number'], $nb_place_disponible, $numero_de_pack, $grade_nosrezo, $is_protected );
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function CHECK_IF_AFFILIATE_ALREADY_EXIST_PHONE($connection_database2, $phone) 
{
    include('config.php'); 
	$sql = "SELECT id_affiliate from affiliate_details where phone_number=\"$phone\"  ";               
    $result = mysql_query($sql) or die("Requete pas comprise ! ");
    return (mysql_num_rows($result));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function CHECK_NEW_MDP($password) 
{
    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,20}$/', $password)) 
	{
     return (0); //KO the password does not meet the requirements !
    }
	else 
	{ 
	 return (1);
	} //OK
	
	//     Between Start -> ^
	//     And End -> $
	//     of the string there has to be at least one number -> (?=.*\d)
	//     and at least one letter -> (?=.*[A-Za-z])
	//     and it has to be a number, a letter or one of the following: !@#$% -> [0-9A-Za-z!@#$%]
	//     and there have to be 8-12 characters -> {8,12}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function CHECK_IF_PARTNER_ALREADY_EXIST($connection_database2, $email) 
{	
	$result = mysql_fetch_array(mysql_query(" SELECT count(id_partner) as count_id, id_partner FROM partner_list WHERE p_contact_mail=\"$email\" limit 0,1  ")) or die("Requete pas comprise - #QEMCHB31! ");
	if ($result['count_id'] == 0)     { return (0); }	
	else                              { return ($result['id_partner']); }	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function CHECK_IF_PARTNER_ALREADY_EXIST_PHONE($connection_database2, $phone) 
{ 	
	$result = mysql_fetch_array(mysql_query(" SELECT count(id_partner) as count_id, id_partner FROM partner_list WHERE p_contact_phone = \"$phone\"  limit 0,1  ")) or die("Requete pas comprise - #QEMCHB31! ");
	if ($result['count_id'] == 0)     { return (0); }	
	else                              { return ($result['id_partner']); }	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function RETURN_ID_PARTNER_ACTIF($connection_database2, $email) 
{	
	$result = mysql_fetch_array(mysql_query(" SELECT count(id_partner) as count_id, id_partner 
	                                          FROM partner_list WHERE trim(p_contact_mail) = \"$email\" 
											  AND is_activated = 1
											  limit 0,1  ")) or die("Requete pas comprise - #RETURN_ID_PARTNER ACTIF ");
	if ($result['count_id'] == 0)     { return (0); }	
	else                              { return ($result['id_partner']); }	
}
?>


<?php  function update_status_recommandation_details($connection_database2, $id_recommandation, $r_status) 
{
				//date_default_timezone_set('Europe/Paris');
		        mysql_query('SET NAMES utf8');
				mysql_query(" UPDATE recommandation_details 
				              SET r_status    ='$r_status', 
							  r_managed_date  = CURRENT_TIMESTAMP 
							  WHERE id_recommandation = '$id_recommandation'   ");            
   			    return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_PARTNER_LIST_COMPETENCER($connection_database2, $id_ligne, $is_activated) 
{
				//date_default_timezone_set('Europe/Paris');
		        mysql_query('SET NAMES utf8');
				mysql_query(" UPDATE partner_list_competencer 
				              SET is_activated       ='$is_activated', 
							  date_is_activated      = CURRENT_TIMESTAMP 
							  WHERE id_ligne         = '$id_ligne'   ");            
   			    return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php  function UPDATE_AFFILIATE_DESINSCRIPTION($id_affiliate, $r_status) 
{
 	 $reponse      = mysql_fetch_array(mysql_query("SELECT count(*) as nb_filleul FROM  affiliate where id_upline =".$id_affiliate." and is_activated = 1  ")) or die("Requete pas comprise - #31JPPPPPP   ");
	 $nb_filleul   = $reponse['nb_filleul'];     

 	 $reponse2    = mysql_fetch_array(mysql_query("SELECT count(*) as nb_reco FROM  recommandation_details where id_affiliate =".$id_affiliate." and r_status > 0  ")) or die("Requete pas comprise - #31JPPPRRPPP   ");
	 $nb_reco     = $reponse2['nb_reco'];  
	 
	 mysql_query(" UPDATE affiliate SET is_activated = '$r_status' WHERE id_affiliate='$id_affiliate'  ");  
     return array($nb_filleul, $nb_reco);				
}
?>

<?php  function update_partner_notation_details($is_activated, $id_recommandation) 
{
                include('config.php'); 
				mysql_query("UPDATE partner_notation_details 
				             SET is_activated        = '$is_activated' 
							 WHERE id_recommandation = '$id_recommandation' ");   
                 
				 // MISE A JOUR DU SCRIPT DE CALCUL DES NOTES GLOBALES DES PARTENAIRES
					 update_notation_partner($id_recommandation); 							 
   			    return ("OK");
}
?>


<?php  function note_to_criteria_partenaire($id_note) 
{
			 if ($id_note == 1) {$id_criteria = "Mauvais";}
	    else if ($id_note == 2) {$id_criteria = "A améliorer";}
		else if ($id_note == 3) {$id_criteria = "Moyen";}
	    else if ($id_note == 4) {$id_criteria = "Bon";}
		else if ($id_note == 5) {$id_criteria = "Très bon";}
		else if ($id_note == 6) {$id_criteria = "Excellent";}

        return ($id_criteria);
}
?>

<?php  function convert_note_partenaire($id_note) 
{
			 if ($id_note == 1) {$id_value = 2;}
	    else if ($id_note == 2) {$id_value = 3;}
		else if ($id_note == 3) {$id_value = 4;}
	    else if ($id_note == 4) {$id_value = 5;}
		else if ($id_note == 5) {$id_value = 6;}
		else if ($id_note == 6) {$id_value = 6;}

        return ($id_value); 
}
?>


<?php  function send_password($id_param, $mode)
{
             $mail = $id_param;
             if ($mode == "INSCRIPTION") // PARAMETRE = ID_AFFILIATE
		         {
         	         $result = mysql_fetch_array(mysql_query("SELECT email, id_affiliate FROM affiliate_details where id_affiliate =".$id_param."   ")) or die("Requete pas comprise - #31! ");
	                 $mail = $result['email'];			 
		         }
				 
 		     $req2 = mysql_query('select first_name, last_name, password, id_affiliate from affiliate where id_affiliate in (select id_affiliate from affiliate_details where email="'.$mail.'" )') or die(".");
		     $dn2  = mysql_fetch_array($req2);
 
             $first_name    = $dn2['first_name'];
	         $last_name     = $dn2['last_name'];
			 $id_affiliate  = $dn2['id_affiliate'];
             $mdp           = $dn2['password'];
	     
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";

if ($mode == "INSCRIPTION") 
{
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bienvenue $first_name, <br />                               
<br />
Vous venez de vous inscrire afin de rejoindre la communauté <a href='www.NosRezo.com' target='_blank'><b>NosRezo.com</b></a>  <br /><br />
Vous trouverez ci-après votre mot de passe d'accés : <br />
     >> <u>Votre Nom</u> :  <b> $last_name </b> <br />
     >> <u>Votre Prénom</u> : <b>  $first_name </b> <br />
     >> <u>Votre Login</u> : <b>  $id_affiliate </b> ou <b> $email </b> <br />
     >> <u>Votre Mot de passe</u> : <b>  $mdp</b><br />
<br />
Vous pouvez modifier votre mot de passe dans la partie \"Mon compte > Profil\" de votre intranet.<br />
</p>
<br />
</div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
N'oubliez pas de nous suivre sur la page Facebook NosRezo réservée uniquement à nos membres. Votre parrain vous fera suivre une invitation.<br />
<br />
Nous vous souhaitons de pouvoir profiter pleinement de l'ensemble de nos services et pour toute demande, merci de nous contacter à l'adresse : <a href='contact@nosrezo.com' target='_blank'><b>contact@nosrezo.com</b></a> <br />
<br /><br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br /><br />
</p>
</div>


 </body></html>";}

else if ($mode == "OUBLIE") 
{
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $first_name, <br />                               
										   <br />
Vous venez de faire une demande afin de recevoir votre mot de passe d'accès à <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>  <br /><br />
Vous trouverez ci-après les informations que vous avez renseignées : <br />
     <img src=$src_carre> <u>Votre Nom</u> :  <b> $last_name </b> <br />
     <img src=$src_carre> <u>Votre Prénom</u> : <b>  $first_name </b> <br />
     <img src=$src_carre> <u>Votre Login</u> : <b>  $id_affiliate </b> <br />
     <img src=$src_carre> <u>Votre Mot de passe</u> : <b>  $mdp </b> <br />

<br />
Si vous n'avez pas réalisé cette demande, merci de nous prévenir à l'adresse : <a href='contact@nosrezo.com' target='_blank'><b>contact@nosrezo.com</b></a> <br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>
 </body></html>";} 
 

//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Demande de mot de passe NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_INFORMATION_RECOMMANDATION_DETAILS($id_recommandation, $id_privileged_partner, $r_commentary, $reco_etape) 
{
				$r_commentary = stripslashes($r_commentary);
				$r_commentary = addslashes($r_commentary);   		
				$sql = "UPDATE recommandation_details 
				                     SET id_privileged_partner ='$id_privileged_partner',
									 r_status                  = '$reco_etape',
                                     r_commentary              = \"$r_commentary\",									 
									 r_managed_date            = CURRENT_TIMESTAMP 
									 WHERE id_recommandation   ='$id_recommandation' "; 
				mysql_query($sql) or die("Requete update_info_recommandation_details pas comprise #AZ8JJ9");	
				return ("OK");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_RECOMMANDATION_DETAILS_FIELD($id_recommandation, $field_to_update, $value_to_take) 
{
				$value_to_take = stripslashes($value_to_take);
				$value_to_take = addslashes($value_to_take);   		
				$sql = "UPDATE recommandation_details 
				         SET  $field_to_update     = \"$value_to_take\",									 
						 r_managed_date            = CURRENT_TIMESTAMP 
						 WHERE id_recommandation   = '$id_recommandation' "; 
				mysql_query($sql) or die("Requete UPDATE_RECOMMANDATION_DETAILS_FIELD pas comprise #AZ8JJ9");	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_PARTNER_LIST_FIELD($id_partner, $field_to_update, $value_to_take) 
{
				$value_to_take = stripslashes($value_to_take);
				$value_to_take = addslashes($value_to_take);   		
				$sql = "UPDATE partner_list 
				         SET  $field_to_update     = \"$value_to_take\"
						 WHERE id_partner          = '$id_partner' "; 
				mysql_query($sql) or die("Requete UPDATE_PARTNER_LIST_FIELD pas comprise #AZ8JJ9");	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_DEVIS_RECOMMANDATION_DETAILS($id_recommandation, $montant_devis_ttc, $montant_tva_percent, $montant_qui_entre_dans_mlm, $r_sub_category_code ) 
{  // LE CALCUL EST MIS A JOUR DES QUE LES DONNESS SONT MODIFIEES PAR ADMINISTRATEUR OU PARTENAIRE
        IF ( $montant_devis_ttc > 1) 
			{
				$tva        = tva_nosrezo_services($id_recommandation);
				
				IF ($r_sub_category_code == 4)
				{ 	$r_gain_TTC = $montant_devis_ttc * 0.5/100; }
				ELSE
				{	$r_gain_TTC = $montant_qui_entre_dans_mlm * (1 + $tva/100);	}
				
				include('config.php'); 
				//date_default_timezone_set('Europe/Paris');      		
				$sql = "UPDATE recommandation_details 
				                     SET r_devis_ttc         = '$montant_devis_ttc',	
                                     montant_tva_percent     = '$tva',
									 r_gain_TTC  	         = '$r_gain_TTC',
									 r_gain 		         = '$montant_qui_entre_dans_mlm',							 
									 r_managed_date          = CURRENT_TIMESTAMP 
									 WHERE id_recommandation = '$id_recommandation' "; 
				mysql_query($sql) or die("Requete pas comprise #A1ZPX00Z89");	
				return ("OK");
			}
		ELSE {return ("KO");}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_information_recommandation_details_category($id_recommandation, $r_category, $r_sub_category_code) 
{
                include('config.php'); 
				//date_default_timezone_set('Europe/Paris'); 
				$reponse         = mysql_query("SELECT s_sub_category FROM services WHERE id_services=".$r_sub_category_code."      ") or die("Requete update_info_recommandation_details_statuts pas comprise #AZAAER89");               
                $data            = mysql_fetch_array($reponse);
			    $r_sub_category  = $data['s_sub_category'];
				
				$sql = "UPDATE recommandation_details 
				                     SET  r_category         = \"$r_category\",
									 r_sub_category          = \"$r_sub_category\",
									 r_sub_category_code     = '$r_sub_category_code',
									 r_managed_date          = CURRENT_TIMESTAMP 
									 WHERE id_recommandation = '$id_recommandation' "; 
				mysql_query($sql) or die("Requete update_info_recommandation_details_statuts pas comprise #AQZER89");	
				return ("OK");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function update_info_recommandation_details_statuts($id_recommandation, $reco_etape) 
{
                include('config.php'); 
				//date_default_timezone_set('Europe/Paris');
				$sql = "UPDATE recommandation_details 
				                     SET  r_status       = '$reco_etape',									 
									 r_managed_date = CURRENT_TIMESTAMP 
									 WHERE id_recommandation='$id_recommandation'"; 
				mysql_query($sql) or die("Requete update_info_recommandation_details_statuts pas comprise #AZ89123");					 							 
   			    return ("OK");
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_INFO_RECOMMANDATION_DATE_ENCAISSEMENT($connection_database2, $id_recommandation ) 
{
				IF ( $id_recommandation > 1 )
				{
				$sql = " UPDATE recommandation_details 
				                     SET  date_encaissement = CURRENT_TIMESTAMP,									 
									      r_managed_date = CURRENT_TIMESTAMP 
									 WHERE id_recommandation = '$id_recommandation'"; 
				mysql_query($sql) or die("Requete UPDATE_INFO_RECOMMANDATION_DATE_ENCAISSEMENT pas comprise #AZ89123");	
                }				
   			    return ("OK");
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function UPDATE_INFO_RECOMMANDATION_DETAILS_GAIN( $connection_database2, $id_recommandation, $gain) 
{
                include('config.php'); 
				//date_default_timezone_set('Europe/Paris');
				$sql = "UPDATE recommandation_details 
				                     SET  r_gain       = '$gain',									 
									 r_managed_date    = CURRENT_TIMESTAMP 									 
									 WHERE id_recommandation='$id_recommandation'"; 
				mysql_query($sql) or die("Requete update_info_recommandation_details_statuts pas comprise #BaAZ89123");					 							 
   			    return ("OK");
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function SEND_EMAIL_PARTENAIRE_RECO($connection_database2, $id_recommandation, $mode)
{
	      IF ( $mode == 1) { $texte = ""; $titre = "Recommandation d'affaire NosRezo.com ";} // 1ER  ENVOI DE LA RECOMMANDATION AU PARTENAIRE
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
	 ELSE IF ( $mode == 2) { $texte = ">> <b>RELANCE 1</b> << <br/>  >> NON MISE A JOUR DE VOTRE INTRANET <<  <br/> <br/> "; 
	                         $titre = "URGENT - RELANCE N°1";} // 1ER   RELANCE DE LA RECOMMANDATION AU PARTENAIRE
							 
	 ELSE IF ( $mode == 3) { $texte = ">> <b>RELANCE 2</b> << <br/>  >> NON MISE A JOUR DE VOTRE INTRANET <<  <br/> <br/> "; 
	                         $titre = "URGENT - RELANCE N°2";} // 2IÈME RELANCE DE LA RECOMMANDATION AU PARTENAIRE
							 
	 ELSE IF ( $mode == 4) { $texte = ">> <b>RELANCE 3</b> << <br/>  >> NON MISE A JOUR DE VOTRE INTRANET <<  <br/> <br/> "; 
	                         $titre = "URGENT - RELANCE N°3";} // 3IÈME RELANCE DE LA RECOMMANDATION AU PARTENAIRE
							 
	 ELSE                  { $texte = ">> <b>RELANCE</b> << <br/>  >> NON MISE A JOUR DE VOTRE INTRANET <<  <br/> <br/> "; 
	                         $titre = "URGENT - RELANCE ";} // 3IÈME RELANCE DE LA RECOMMANDATION AU PARTENAIRE							 

	 // REQUETTE DE REMPLISSAGE DU MAIL 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary FROM recommandation_details where id_recommandation=".$id_recommandation."   ";               
		 $result                   = mysql_query($sql) or die("Requete pas comprise #12B789");
		 $reponse                  = mysql_fetch_array($result);
         $r_sub_category           = $reponse['r_sub_category'];
		 $r_sub_category_code      = $reponse['r_sub_category_code'];
	     $id_privileged_partner    = $reponse['id_privileged_partner'];
		 $r_last_name              = $reponse['r_last_name'];
		 $r_first_name             = $reponse['r_first_name'];
		 $r_city                   = $reponse['r_city'];
		 $r_zip_code               = $reponse['r_zip_code'];
		 $r_address                = $reponse['r_address'];
		 $r_type                   = $reponse['r_type'];
		 $r_phone_number           = $reponse['r_phone_number'];
		 $r_email                  = $reponse['r_email'];		 
         $id_affiliate             = $reponse['id_affiliate'];		 
		 $r_connection_with        = $reponse['r_connection_with'];
		 $r_commentary             = $reponse['r_commentary'];

		 $reponse2       = mysql_fetch_array(mysql_query("SELECT first_name, last_name, zip_code, city, phone_number, email FROM affiliate_details where id_affiliate = ".$id_affiliate."   ")) or die("Requete pas comprise - #AA32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $a_phone_number = $reponse2['phone_number'];
		 $a_email        = $reponse2['email'];
		 
		 $reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."   ")) or die("Requete pas comprise - #3OO3-1! ");
	     $mail                        = $reponse3['p_contact_mail'];
		 $name_id_privileged_partner  = $reponse3['p_contact'];
         
		 $reponse4 = mysql_fetch_array(mysql_query("SELECT count(*) as countrow, id_affiliate, password FROM affiliate where id_partenaire =".$id_privileged_partner."   ")) or die("Requete pas comprise - #PASS32! ");
		 $password                    = $reponse4['password'];
		 $id_affiliate_partenaire     = $reponse4['id_affiliate'];

	 	 
		 
IF ($r_sub_category_code == 1 ) // MISE EN VENTE IMMOBILIERS
        { $message_partenaire = "Merci de mettre <b><font color=#fa38a3> IMPÉRATIVEMENT </font></b> Nos Rezo en apporteur d'affaire dans votre intranet IAD lors de la saisie du <b>e-mandat </b>.<br />"; }	
        else {$message_partenaire = "";}		

IF ($r_sub_category_code == 50 ) // RECHERCHE IMMOBILIERS
        { $r_complement_information = "<b><u> LE CLIENT ACQUÉREUR </u>: <br /> 
		         1. A validé son mode de financement <br />
		         2. Accepte de mandater un chasseur immobilier  <br />
		         3. Ne recherche pas par lui même  <br />
		         4. Il n'a pas besoin de vendre son bien au préalable <br />	</b>			 
				 "; }	
ELSE IF ($r_sub_category_code == 55 ) // PINEL
        { $r_complement_information = "<b><u> LE CONTACT INVESTISSEUR </u>: <br /> 
		         1. À une capacité d'épargne de 300€/mois <br />
		         2. Imposable à plus de 4000€/an  <br />
		         3. Souhaite se constituer un patrimoine  <br /></b>			 
				 "; }
ELSE IF ($r_sub_category_code == 8 ) // RECRUTEMENT
        { $r_complement_information = "<b><u> VOUS ACCEPTEZ LES CONDITIONS SUIVANTES </u>: <br /> 
		         1. Réaliser une POA à ce contact <br />
		         2. Reverser 500 € HT à NosRezo uniquement à la 1ère vente du contact si ce dernier intègre IAD France <br />
		         [0€ si pas de vente réalisée]  <br />	
		 		 3. Contacter Karim Ouali en cas de question : 0686495254 <br />
				 "; }				 
        else { $r_complement_information = "";}

		
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // ON FILTRE LES SERVEURS QUI RENCONTRENT DES BOGUES.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#FFFFFF;'>
      <div style='width:auto height:auto; margin-top:0px; ' >
	    <img style='border-radius:0px;' src=$src >	
     </div>
<div style='width:auto; height:auto; margin-top:0px; border-style: solid; border-color:#2375b0; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $name_id_privileged_partner, <br />
<br />
$texte En tant que partenaire de <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>, vous venez de recevoir une recommandation d'affaire :  <br />
     <img src=$src_carre> <u>Projet du contact </u> :  <b> $r_sub_category </b> <br />
     <img src=$src_carre> <u>Contact </u> :  <b> $r_last_name $r_first_name  </b> <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville du contact </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Coordonnées </u> : <b>  $r_phone_number  </b> <br />
	 <img src=$src_carre> <u>Dossier </u> : <b>  R$id_recommandation </b> <br />
     <img src=$src_carre> <u>Prise de contact </u> : <b>  <font color=#fa38a3> DÈS QUE POSSIBLE </font> </b> <br />
<br />
Cette personne vous est recommandée par :<br />
     <img src=$src_carre> <u>Nom de l'affilié </u> :  <b> $a_last_name </b> <br />
     <img src=$src_carre> <u>Prénom de l'affilié  </u> : <b>  $a_first_name </b> <br />
	 <img src=$src_carre> <u>Ville de l'affilié </u> : <b>  $zip_code $a_city </b> <br />
	 <img src=$src_carre> <u>Contact pour plus de détails </u> : <b>  $a_phone_number $a_email </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br /> $r_complement_information <br />
<br />
$message_partenaire 
Merci de vous mettre en relation avec ce contact dès que possible, et de tenir à jour l'avancement du projet via votre Intranet. <br />
<br />
Pour rappel : <br />
     <img src=$src_carre>  <u>Votre identifiant </u> : <font color=#fa38a3><b>$id_affiliate_partenaire</b></font><br />
     <img src=$src_carre>  <u>Votre mot de passe </u> : <b>$password</b>  <br />
     <img src=$src_carre>  <a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate_partenaire&amp;token=$password' > Cliquez ici pour vous connecter.</a><br />
<br />
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = $titre;
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
IF ($r_sub_category_code == 1 and $mode < 2) // MISE EN VENTE IMMOBILIERS ET PAS EN MODE RELANCE 
        { $header.= "Cc: nos.rezo@iadfrance.fr ".$passage_ligne; }
//ELSE { IF ($mode < 2) // MISE EN VENTE IMMOBILIERS ET PAS EN MODE RELANCE 
//     { $header.= "Cc: contact@nosrezo.com ".$passage_ligne; } }
$header.= "Cci: karim.ouali@iadfrance.fr, contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function SEND_EMAIL_AFFILIE_STATUT($connection_database2, $id_recommandation, $action_id_category, $message_partenaire)
{
     include('config.php'); 
	 // REQUETTE DE REMPLISSAGE DU MAIL 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary 
		            FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #12");
		 $reponse = mysql_fetch_array($result);

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];

		 $reponse2       = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #CCCCC32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $mail           = $reponse2['email'];

		 $reponse10 = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as countifexist, id_affiliate, password FROM affiliate where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #R323AARFT: TEST !");
		 $mdp       = $reponse10['password'];

		 
		 if  ($id_privileged_partner == 0) // PAS DE PARTENAIRE CAR RECOMMANDATION ANNULEE AVANT
		     {$name_id_privileged_partner  = "Aucun partenaire sélectionné par NosRezo";}
		 else	 
		     {$reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact , p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."  limit 0,1   ")) or die("Requete pas comprise - #33-2! ");
		     $name_id_privileged_partner  = $reponse3['p_contact'];}

			 
		 IF ($action_id_category > 0 )
         {		 
		 $reponse4        = mysql_fetch_array(mysql_query(" SELECT count(action_details) as nb_count, action_details, id_recommandation 
		                                                    FROM action_list 
															where id_recommandation =".$id_recommandation." 
															and action_id_category  = ".$action_id_category."  
															ORDER by action_creation_date desc limit 0,1 ")) or die("Requete pas comprise du statut action_list - #31J3-453   ");
		 $action_details  = $reponse4['action_details']."<br/>".$message_partenaire;  // STATUT PRESENTE AU CLIENT DANS LE MAIL		 
		 }
		 ELSE
		 {
		 $action_details = $message_partenaire;
		 }

	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body>
      <div style='width:auto height:auto; margin-top:0px; ' >
	    <img style='border-radius:1px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:5px; margin-left:5px;'> 
Bonjour $a_first_name, <br />                               
<br />
En tant qu'affilié <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>, vous avez fait une recommandation d'affaire.  <br /><br />
Nous vous faisons un <font color=#fa38a3><b> statut </b> </font> sur le suivi d'avancement :<br />
     <img src=$src_carre> <u>Partenaire en charge du service</u> :  <b> $name_id_privileged_partner </b> <br />
     <img src=$src_carre> <u>Statut</u> : <b>  $action_details  </b>
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Votre recommandation : <br />
     <img src=$src_carre> <u>Votre Contact </u> :  <font color=#fa38a3><b> $r_first_name  $r_last_name </b></font>  <br />
     <img src=$src_carre> <u>Projet </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Adresse </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Dossier </u> : <b>  R$id_recommandation </b> <br />
     <img src=$src_carre> <u>Coordonnées </u> : <b>  $r_phone_number   </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Pour rappel votre identifiant est le : <font color=#fa38a3><b>$id_affiliate</b></font><br /> 
<a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' > Cliquez ici pour vous connecter.</a>
<br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Nous vous souhaitons de belles opportunités d'affaires grâce à nos services.<br />
<br />
Julie de l'équipe NosRezo<br />
Vous pouvez nous contacter au $telephone_call_center<br /> 
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>



 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Statut - Recommandation NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
//$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.

     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function insert_recommandation_comptable($id_recommandation, $id_partner, $amount_ttc, $tva_percent_to_pay, $amount_ht, $id_affiliate, $id_parrain_niveau_1, $id_parrain_niveau_2, $id_parrain_niveau_3, $id_parrain_niveau_4, $id_parrain_niveau_5, $id_parrain_niveau_6 ) 
{
     include('config.php');      
	 mysql_query('SET NAMES utf8');
	 //date_default_timezone_set('Europe/Paris');
	 $aX_payed         = 0;
	 $aX_payed_date    = "";
	 $aX_ref           = "Ref";
	 $aX_note          = "Note";
	 $total_tva        = $amount_ttc - round($amount_ttc / (1+$tva_percent_to_pay/100), 3, PHP_ROUND_HALF_DOWN);
	 
	 //////////////////////////////////////////////   LEVEL 0      ////////////////////////////////////////// 
	 $level_en_cours   = 0; 
	 $amount_aX        = round($amount_ht*0.6 , 3, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_affiliate;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva, aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.60 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 0 pas comprise. ");							 
							 

	 //////////////////////////////////////////////   LEVEL 1      ////////////////////////////////////////// 
	 $level_en_cours   = 1; 
	 $amount_aX        = round($amount_ht*0.09 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_1;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.09 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 1 pas comprise. ");

	 //////////////////////////////////////////////   LEVEL 2      ////////////////////////////////////////// 
	 $level_en_cours   = 2; 
	 $amount_aX        = round($amount_ht*0.03 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_2;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.03 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 2 pas comprise. ");

	 //////////////////////////////////////////////   LEVEL 3      ////////////////////////////////////////// 
	 $level_en_cours   = 3; 
	 $amount_aX        = round($amount_ht*0.03 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_3;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.03 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 3 pas comprise. ");
							 
	 //////////////////////////////////////////////   LEVEL 4      ////////////////////////////////////////// 
	 $level_en_cours   = 4; 
	 $amount_aX        = round($amount_ht*0.03 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_4;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.03 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 4 pas comprise. ");

	 //////////////////////////////////////////////   LEVEL 5      ////////////////////////////////////////// 
	 $level_en_cours   = 5; 
	 $amount_aX        = round($amount_ht*0.03 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_5;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.03 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)													 
					         ') or die("Requete recommandation_comptable : 5 pas comprise. ");

	 //////////////////////////////////////////////   LEVEL 6      ////////////////////////////////////////// 
	 $level_en_cours   = 6; 
	 $amount_aX        = round($amount_ht*0.03 , 2, PHP_ROUND_HALF_DOWN);
	 $aX_id_affiliate  = $id_parrain_niveau_6;
	 
	 mysql_query('insert into recommandation_comptable(id_comptable, id_recommandation, id_partner, amount_payed_ttc, amount_tva_percent, amount_payed_ht, aX_level, aX_amount_ht, aX_only_tva,  aX_id_affiliate, aX_payed, aX_payed_date, aX_ref , aX_note, creation_date  ) 
	                values ( "",
					         "'.$id_recommandation.'",
					         "'.$id_partner.'", 
					         "'.$amount_ttc.'",
							 "'.$tva_percent_to_pay.'",
					         "'.$amount_ht.'",
					         "'.$level_en_cours.'",
					         "'.$amount_aX.'",
							 "'.round($total_tva*0.03 , 2, PHP_ROUND_HALF_DOWN).'",
					         "'.$aX_id_affiliate.'",
					         "'.$aX_payed.'",
					         "",
					         "'.$aX_ref.'",
					         "'.$aX_note.'",
							 CURRENT_TIMESTAMP)												 
					         ') or die("Requete recommandation_comptable : 6 pas comprise. ");

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function SEND_EMAIL_RECOMMANDATION($connection_database2, $id_recommandation, $id_affiliate, $s_category, $s_sub_category, $cp, $ville, $commentaires, $connection,  $id_privileged_partner, $first_id_part_algo, $source_recommandation )
{		 
         $mail           = "contact@nosrezo.com";
		 //$owner_id       = owner_action_admin($id_affiliate);
         //$owner_name     = nom_prenom_id_parrain_affilie($connection_database2, $owner_id);
         $owner_name     =	"NosRezo";	 

         $reponse2       = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city, phone_number FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #3ZE2! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $a_zip_code     = $reponse2['zip_code'];		 
		 $a_phone_number = $reponse2['phone_number'];	
		 $s_category     = ucfirst($s_category);
		 
		 IF ($id_privileged_partner == 0) 
		     {  IF ($first_id_part_algo == 0) 
			     {      
				     $partner = "ACTION À TRAITER.";
				 }
				ELSE
                 {				
			         $partner = "Sélectionné par l'ALGORITHME.";
                 }				 
			 }
		 ELSE 
		     { 
			     $partner = "Sélectionné par l'AFFILIÉ."; 
			 }
		 
		 
	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#FFFFFF;'>
      <div style='width:auto height:auto; margin-top:0px; ' >
	    <img style='border-radius:0px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:0px; border-style: solid; border-color:#2375b0; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour <b> $owner_name</b>, <br />   
</p>
</div>                            
<div id='tab_partenaire_1' style='width:auto; height:auto; margin-top:5px; border-color:#e7e8e9; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Nouvelle recommandation :<br />
     <img src=$src_carre> <u>Service </u> :  <b> $s_sub_category </b> <br />
	 <img src=$src_carre> <u>Dossier </u> :  <b> R$id_recommandation </b> <br />
	 <img src=$src_carre> <u>Secteur </u> :  <b> $cp $ville </b> <br />
	 <img src=$src_carre> <u>Source </u> :  <b> $source_recommandation </b> <br />	 
	 <img src=$src_carre> <u>Commentaire </u> :  <b> $commentaires </b> <br />
<br />
Recommandation envoyée par l'affilié : <br />
	 <img src=$src_carre> <u>Nom </u> :  <b> $a_first_name $a_last_name [ID : $id_affiliate] </b> <br />
	 <img src=$src_carre> <u>Ville </u> :  <b> $a_zip_code $a_city </b> <br />
	 <img src=$src_carre> <u>Contact </u> :  <b> $a_phone_number </b> <br />
	 <img src=$src_carre> <u>Partenaire </u> :  <font color=#fa38a3><b> $partner </b> </font> <br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br /><br />
</p>
</div>


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Nouvelle recommandation d'affaire NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function UPDATE_PARTENAIRE_DOCUMENTS($id_partner, $p_contrat_recu, $p_kbis_recu, $p_assurance_recu) 
{
	 mysql_query("UPDATE partner_list 
	                     SET  p_contrat_recu   = '$p_contrat_recu',
						 p_kbis_recu           = '$p_kbis_recu',
						 p_assurance_recu      = '$p_assurance_recu'
					     WHERE id_partner      = '$id_partner'          ");            

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_PARTENAIRE_ENTREPRISE($id_partner, $SIRET, $TVA_INTRA, $mode_facturation) 
{
     $sql = "UPDATE partner_list 
	                     SET  SIRET            = \"$SIRET\"  , 
						 TVA_INTRA             = \"$TVA_INTRA\",
                         mode_facturation	   = '$mode_facturation'				 
					     WHERE id_partner      = '$id_partner'          ";
	 //echo $sql;					 
	 mysql_query($sql);            

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_AFFILIE_DETAILS_DATE_RELANCE_CONTACT($id_affiliate, $date_relance_contact) 
{ 
	 $sql = "UPDATE affiliate_details 
	                     SET  date_relance_contact = '$date_relance_contact'
					     WHERE id_affiliate        = '$id_affiliate'    ";
	 mysql_query($sql);            
}
?>


<?php  function update_affilie_details_able_to_develop($id_affiliate, $is_able_to_develop) 
{; 
	 mysql_query("UPDATE affiliate_details 
	                     SET  is_able_to_develop = '$is_able_to_develop'
					     WHERE id_affiliate      = '$id_affiliate' ");            
   	 return ("OK");
}
?>

<?php  function update_last_connection_date_affilie($id_affiliate) 
{
	 //date_default_timezone_set('Europe/Paris');
	 mysql_query("UPDATE affiliate 
	                     SET last_connection_date = CURRENT_TIMESTAMP 
					     WHERE id_affiliate = '$id_affiliate' ");            
   	return ("OK");
}
?>

<?php  function update_desactivation_parrain_nr($id_affiliate) 
{ 
	 mysql_query(" UPDATE affiliate 
	                     SET id_upline      = 10						 
					     WHERE id_affiliate = '$id_affiliate'   ");            
}
?>


<?php  function update_affilie_id_partenaire($id_affiliate, $id_partenaire) 
{
	 mysql_query("UPDATE affiliate  SET id_partenaire = '$id_partenaire'   WHERE id_affiliate = '$id_affiliate' ");            
}
?>


<?php  function update_last_connection_date_partenaire($id_partenaire) 
{
     include('config.php'); 
	 //date_default_timezone_set('Europe/Paris');
	 mysql_query("UPDATE partner_list 
	                     SET last_connection_date = CURRENT_TIMESTAMP 
					     WHERE id_partner         = '$id_partenaire' ");            
   	 return ("OK");
}
?>

<?php  function update_partner_list_rayon($id_partenaire, $nouveau_rayon) 
{
     include('config.php'); 
	 mysql_query("UPDATE partner_list 
	                     SET p_rayon      = '$nouveau_rayon'
					     WHERE id_partner = '$id_partenaire' ");            
   	 return ("OK");
}
?>

<?php  function update_partner_list_rayon_level_1($id_partenaire, $p_rayon_level1) 
{
     include('config.php'); 
	 mysql_query("UPDATE partner_list 
	                     SET p_rayon_level1 = '$p_rayon_level1'
					     WHERE id_partner   = '$id_partenaire' ");            
   	 return ("OK");
}
?>

<?php  function INSERT_ACTION_SUIVI_PARTENAIRE($action_prise_en_compte, $days, $etape_realisee, $action_category, $action_detail, $description, $id_recommandation, $id_partner, $id_affiliate, $montant_devis_ttc, $montant_tva_percent) 
{     
     //date_default_timezone_set('Europe/Paris');
	 $action_max_date = date('Y-m-d H:i:s',time()+$days*24*3600);// AVANCE de Xj

	 $montant_devis_ht = $montant_devis_ttc / (1 + $montant_tva_percent / 100);
	 
     include('config.php'); 
		  $sql ='insert into action_suivi_partenaire(id_action, action_creation_date, action_max_date, action_prise_en_compte, etape_realisee, action_category, action_detail, description, id_recommandation, id_partner, id_affiliate, montant_devis_ttc, montant_tva_percent, montant_devis_ht) 
				                             values (
											 "",
											 "'.date("Y-m-d H:i:s").'",
											 "'.$action_max_date.'",
											 "'.$action_prise_en_compte.'",
											 "'.$etape_realisee.'",
											 "'.$action_category.'",
											 "'.$action_detail.'",
											 "'.$description.'",
											 "'.$id_recommandation.'",
											 "'.$id_partner.'",
											 "'.$id_affiliate.'",
											 "'.$montant_devis_ttc.'",
											 "'.$montant_tva_percent.'",
											 "'.$montant_devis_ht.'") 
											 ';
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete insert_action_list pas comprise : #WXFDCD0");            
   			    return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function MAJ_SECTEUR_PARTENAIRE($id_partenaire, $p_zip_code, $ville_secteur, $p_adresse, $source_script, $source_pays_partenaire)
{ 	
				  
	 List ($latitude_secteur, $longitude_secteur) = GEO_LOCALISATION_ADRESSE($p_zip_code, $ville_secteur, $p_adresse, $source_script, $source_pays_partenaire);
	 $sql = " UPDATE partner_list SET 
	               p_zip_code       = '$p_zip_code', 
				   p_city           = \"$ville_secteur\"  ,
				   p_lat            = '$latitude_secteur' , 
				   p_long           = '$longitude_secteur'   
				   WHERE id_partner = '$id_partenaire'  "; 
				   
	  mysql_query($sql); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function MAJ_GRADE_PARTENAIRE($id_partenaire, $partenaire_grade)
{ 						  
	 $sql = " UPDATE partner_list SET 
				   partenaire_grade     = \"$partenaire_grade\"   
				   WHERE id_partner = '$id_partenaire'  "; 
				   
	  mysql_query($sql); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function reporting_nb_affiliate_nosrezo_full($param)
{ 						 
		 include('config.php'); 						 
		 $reponse_reporting      = mysql_fetch_array(mysql_query(" SELECT sum(nb_affiliate) as nb_affiliate 
		                                                           FROM  reporting_niveau_1   ")) or die("Requete pas comprise : #reporting_niveau_1 - nb_affiliate"); 
		 $nb_affiliate_nosrezo   = $reponse_reporting["nb_affiliate"];	

	     return ($nb_affiliate_nosrezo); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function reporting_date_maj($param)
{             
         $reponse_reporting      = mysql_fetch_array(mysql_query(" SELECT date_calcul FROM  reporting_niveau_1 limit 0,1  ")) or die("Requete pas comprise : azFaatrAsp - Oups"); 
		 $date_calcul            = $reponse_reporting["date_calcul"];	 
	     return ($date_calcul); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function send_password_partenaire($id_partner, $mode)
{
         	         mysql_query('SET NAMES utf8');	
					 $result = mysql_fetch_array(mysql_query("SELECT p_category, p_sub_category, p_company, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact , p_contact_phone, p_contact_mail, p_fonction, p_zip_code, p_secteur, p_city, p_rayon  FROM partner_list where id_partner =".$id_partner."   ")) or die("Requete pas comprise - #TR31! ");
                     $p_category      = $result['p_category'];
                     $p_sub_category  = $result['p_sub_category'];	
	                 $mail            = $result['p_contact_mail'];	
                     $first_name      = $result['p_contact'];		
	                 $p_company       = $result['p_company'];	
                     $p_contact_phone = $result['p_contact_phone'];
                     $p_secteur       = $result['p_secteur'];								   
                     $p_fonction      = $result['p_fonction'];
					 $p_zip_code      = $result['p_zip_code'];
					 $p_city          = $result['p_city'];
					 $p_rayon         = $result['p_rayon'];

		             $reponse4 = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as countifexist, id_affiliate, password FROM affiliate where id_partenaire =".$id_partner."   ")) or die("Requete pas comprise - #R323RFT: TEST !");
		             $mdp            = $reponse4['password'];
		             $id_affiliate   = $reponse4['id_affiliate'];
					 

	     
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";

if ($mode == "INSCRIPTION") 
{
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
$message_html = "
<html><head></head><body style='background-color:#FFFFFF;'>
      <div style='width:auto height:auto; margin-top:0px; ' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
<div style='width:auto; height:auto; margin-top:0px; border-style: solid; border-color:#2375b0; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bienvenue $first_name, <br />                               
<br />
D'après vos performances, vous venez d'être référencé en tant que partenaire <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a> : <br />
     <img src=$src_carre> <u>Votre domaine</u> :  <b> $p_sub_category </b> <br />
     <img src=$src_carre> <u>Votre société</u> : <b>  $p_company / $p_fonction </b> <br />
     <img src=$src_carre> <u>Votre téléphone</u> : <b>  $p_contact_phone </b> <br />
     <img src=$src_carre> <u>Votre secteur</u> : <b>  $p_zip_code $p_city - $p_rayon Km autour</b> <br />
</div>
<div style='width:auto; height:auto; margin-top:5px; border-style: solid; border-color:#2375b0; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Ci-après vos accés : <br />
     <img src=$src_carre> <u>Votre Identifiant </u> : <b>  $id_affiliate </b> <br />
     <img src=$src_carre> <u>Votre Mot de passe </u> : <b><font color=#fa38a3>  $mdp</font></b><br />
<br />
Merci  <b><font color=#fa38a3> IMPÉRATIVEMENT </font></b>de mettre à jour l'avancement de vos dossiers dans votre intranet <br /> <a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' > en cliquant ici</a>. <br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:5px; border-style: solid; border-color:#2375b0; border-radius:0px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Pour toute demande, merci de nous contacter à l'adresse : <a href='contact@nosrezo.com' target='_blank'><b>contact@nosrezo.com</b></a> <br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";}

else if ($mode == "OUBLIE") 
{
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 0px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $first_name, <br />                               
										   <br />
Vous venez de faire une demande afin de recevoir votre mot de passe d'accès à <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>  <br /><br />
     <img src=$src_carre> <u>Votre Login </u> : <b>  $id_affiliate </b> <br />
     <img src=$src_carre> <u>Votre Mot de passe</u> : <font color=#fa38a3><b>  $mdp </b></font> <br />
<br />
Pensez à changer votre mot de passe dans votre intranet.<br />
<br />
Si vous n'avez pas réalisé cette demande, merci de nous prévenir à l'adresse : <a href='contact@nosrezo.com' target='_blank'><b>contact@nosrezo.com</b></a> <br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
<br />
</p>
</div>

 </body></html>";} 
 
 
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Bienvenue chez NosRezo - Partenaire";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cci: karim.ouali@iadfrance.fr, contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
}
?>

 <?php function getXmlCoordsFromAdress($address)
{
          $coords=array();
          $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
          // ajouter &region=FR si ambiguité (lieu de la requete pris par défaut)
          $request_url = $base_url . "address=" . urlencode($address).'&sensor=false';
          $xml = simplexml_load_file($request_url) or die("url not loading");
          //print_r($xml);
          $coords['lat']= $coords['lon'] = '';
          $coords['status'] = $xml->status ;
          if($coords['status']=='OK')
          {
             $coords['lat'] = $xml->result->geometry->location->lat ;
             $coords['lon'] = $xml->result->geometry->location->lng ;
          }
		  return array($coords['lat'] , $coords['lon']);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


 <?php function LISTE_PARTENAIRE_DISTANCE_OK($latitude_ville, $longitude_ville, $latitude_partenaire, $longitude_partenaire, $p_rayon_level1, $source)
{
        $ENVOI_AU_PARRAIN_PRO   = 0;
		$ON_AFFICHE_PARTENAIRE  = 0;
		
		$distance = round(calcul_distance_km($latitude_ville, $longitude_ville, $latitude_partenaire, $longitude_partenaire) , 0, PHP_ROUND_HALF_DOWN);                                
        IF ( $distance == 0)  { $distance = 1; }
		
        IF ( ($distance >= 0) AND ($distance <= $p_rayon_level1) ) 						 
           {         $ENVOI_AU_PARRAIN_PRO   = 1;
				     $ON_AFFICHE_PARTENAIRE  = 1;
   		   }

		  return array($distance, $ENVOI_AU_PARRAIN_PRO, $ON_AFFICHE_PARTENAIRE );
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php function CALCUL_DISTANCE_KM($lat1, $lon1, $lat2, $lon2)
{     $r    = 6366;
      // $lat1 = 50.19473;            $lon1 = 6.83212;
      // $lat2 = 50.1948;             $lon2 = 6.83244;
      // echo $lat1; 		  echo $lon1; 		  echo $lat2; 		  echo $lon2;
          /**
          * Conversion des entrées en ° vers des Radians
          */
          $lat1 = deg2rad($lat1);
          $lon1 = deg2rad($lon1);
          $lat2 = deg2rad($lat2);
          $lon2 = deg2rad($lon2);
 
          /**
          * Formule simple
          */
          $ds= acos(sin($lat1)*sin($lat2)+cos($lat1)*cos($lat2)*cos($lon1-$lon2));
          $dsr = $ds * $r;
          //$dp = 2 * asin(
          //            sqrt(
          //                pow( sin(($lat1-$lat2)/2) , 2) + cos($lat1)*cos($lat2)* pow( sin(($lon1-$lon2)/2) , 2)
          //            )
          //               );
          //$dpr = $dp * $r;
 
          //echo "
          //Sorties :
          //ds:$ds
          //dsr:$dsr(km)
 
          //dp:$dp
          //dpr:$dpr(km)";
		  
		  	  return ($dsr);
 
//Entrées :
//lat1:50.19473
//lon1:6.83212
//
//lat2:50.1948
//lon2:6.83244
//
//Sorties :
//ds:3.7784067903909E-6
//dsr:0.024053337627628(km)
//
//dp:3.7784109830292E-6
//dpr:0.024053364317964(km)
}
?>

 <?php function MAJ_COORDONNEES_PARTENAIRES_A_0($categorie)
{
                 mysql_query('SET NAMES utf8');
				 if ($categorie == "PARTENAIRES") 
				 { $result = mysql_query(" SELECT id_partner, p_zip_code, p_city, p_lat, p_long, p_rayon, p_secteur, p_contact_mail 
				                           FROM partner_list 
										   WHERE p_lat = 0 
										   AND   p_long = 0  ")  or die(" Requete coordonnees : #MAJ_COORDONNEES_PARTENAIRES_A_0 pas comprise. ");	
				 }			
   			     echo "<b>1. Contrôle coordonnées géographique :</b> <br/>"; 
				 
				 $compteur = 0;
 				 WHILE ($reponse = mysql_fetch_array($result))
                        {  
                          $secteur     = $reponse["p_zip_code"]." ".$reponse["p_city"]." - ".$reponse["p_rayon"]." km";	
                          $id_partner  = $reponse["id_partner"];	
	                      
						  IF ($reponse["p_rayon"] == 0) 
						  {
		                     mysql_query(" UPDATE partner_list 
						     SET  p_rayon         = 10
						     WHERE id_partner     = '$id_partner'    ");
						     $secteur             = $reponse["p_zip_code"]." ".$reponse["p_city"]." - 10 km";	
						  }
						  
	                      IF ($reponse["p_lat"] == 0) 
						  {      
								 IF ( strstr($reponse["p_contact_mail"], "portugal") )    { $country       = "Portugal"; }
								 ELSE                                                     { $country       = "France";   }
								 
					             $compteur = $compteur + 1;
						         echo " >> Mise à jour ".$compteur." via Google MAP - P".$id_partner." pour la ville ".$reponse["p_zip_code"]." ".$reponse["p_city"]." ".$country." <br/>";
						         
								 $p_adresse     = "";
								 $source_script = "FULL"; // ET NON CRON 

								 List ($latitude, $longitude) = GEO_LOCALISATION_ADRESSE($reponse["p_zip_code"], $reponse["p_city"], $p_adresse, $source_script,  $country); 
	                             IF ($latitude <> 0) 
						        {
		                             mysql_query(" UPDATE partner_list 
						                           SET  p_lat           = '$latitude',
								                   p_long               = '$longitude',
								                   p_secteur            =  \"$secteur\"
						                           WHERE id_partner     = '$id_partner'    "); 
						        }
								ELSE
								{
								 echo " &nbsp &nbsp &nbsp <span class='badge badge-warning '>KO</span> : Ville inexistante pour le partenaire ".$reponse["p_contact_mail"]." - Latitude et Longitude = 0 <br/>";
								}
                           } 
						   ELSE //LATITUDE DIFFERENT DE 0
                            {
		                             mysql_query(" UPDATE partner_list 
						             SET  p_secteur       =  \"$secteur\"
						             WHERE id_partner     = '$id_partner'    ");
                            }
                         
						 echo " <br/>";
						 	
						} // FIN DE LA BOUCLE 
                         IF ($compteur == 0)
						         {
					                 echo " &nbsp &nbsp &nbsp <span class='badge badge-success '>OK</span> - Tous les partenaires sont déjà géo-localisés !  <br/>";
                                 }	
                return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function send_email_relance_partenaire($id_recommandation, $description_2, $serveur)
{

	 // REQUETTE DE REMPLISSAGE DU MAIL 
	     mysql_query('SET NAMES utf8');	 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #1ED2");
		 $reponse = mysql_fetch_array($result);
		 
		 $mail_parrain      = mail_parrain_affilie($reponse['id_affiliate']); 

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 $r_date                 = $reponse['r_creation_date'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];
		 
		 IF ( $description_2 == "HARD" ) { $description_2 = "Il vous reste 48h avant la désactivation de votre compte partenaire. <br/><br/>"; }
		 ELSE                            { $description_2 = ""; }

		 $reponse2 = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #ACP32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $a_zip_code     = $reponse2['zip_code'];
		 
         $reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."  limit 0,1   ")) or die("Requete pas comprise - #33-2! ");
		 $id_privileged_partner       = $reponse3['id_partner'];
		 $name_id_privileged_partner  = $reponse3['p_contact'];
		 $mail                        = $reponse3['p_contact_mail'];
		 
	     $reponse4 = mysql_fetch_array(mysql_query("SELECT count(*) as countrow, id_affiliate, password FROM affiliate where id_partenaire =".$id_privileged_partner."   ")) or die("Requete pas comprise - #PASSSCFS32! ");
		 $mdp                         = $reponse4['password'];
		 $id_affiliate_partenaire     = $reponse4['id_affiliate'];
		 
		 $rapport_activite = "&nbsp  R".$id_recommandation." - P".$id_privileged_partner." [".$name_id_privileged_partner." - ".$r_sub_category."]   ";

if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body>
      <div style='width:auto height:auto; margin-top:0px;' >
	    <img src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $name_id_privileged_partner, <br />                               
<br />
$description_2
Merci de nous faire <b>rapidement </b>un retour sur l'avancement du dossier dans <font color=#fa38a3><b>votre INTRANET </b></font>:<br />
<u>Merci de préciser </u>: <br />
     <img src=$src_carre> <font color=#1e0fbe><b>L'état actuel</b></font> du dossier<br />
     <img src=$src_carre> Une estimation de <font color=#fa38a3><b>la date de relance</b></font> <br />
     <img src=$src_carre> Le montant du <font color=#1e0fbe><b>devis/mandat TTC </b></font>si vous en avez connaissance<br />
<br />
Je vous rappelle que la communication est un élément-clé de notre collaboration. Si le dossier n'a <b>pas évolué</b>, merci de prolonger la date de relance.<br /> 
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
<br />
     <img src=$src_carre> <u>Recommandation </u> : <b> $r_date  </b> <br />
     <img src=$src_carre> <u>Projet </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Contact </u> :  <b> $r_last_name  $r_first_name </b> <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Coordonnées du contact </u> : <b>  $r_phone_number   </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
     <img src=$src_carre> <u>Dossier </u> : <b>  R$id_recommandation </b> <br />
     <img src=$src_carre> <u>Recommandé par </u> : <b>  $a_first_name $a_last_name - $a_city $a_zip_code </b> <br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Pour rappel :<br />
     <img src=$src_carre>  <u>Votre identifiant </u> : <font color=#fa38a3><b>$id_affiliate_partenaire</b></font><br />
     <img src=$src_carre>  <u>Votre mot de passe </u> : <b>$mdp</b>  
<br />
<a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate_partenaire&amp;token=$mdp' > Cliquez ici pour vous connecter directement.</a>
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>
<br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Relance : Recommandation NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc: contact@nosrezo.com, ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
	 
	 return($rapport_activite);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function send_email_affilie_complement($id_recommandation, $message_to_affilie)
{

	 // REQUETTE DE REMPLISSAGE DU MAIL 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #12");
		 $reponse = mysql_fetch_array($result);

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];

		 $reponse2 = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #VDMP32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $mail           = $reponse2['email'];

	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $a_first_name, <br />                               
<br />
En tant qu'affilié de la communauté <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>, vous avez réalisé une recommandation d'affaire.  <br /><br />
Nous venons vers vous pour la raison suivante :<br />
<b> $message_to_affilie </b> <br />
<br />
----------------------------------------------------------------------------------------------------<br />
<br />
Vous trouverez ci-après le détail de votre recommandation : <br />
     <img src=$src_carre> <u>Projet du contact </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Nom du contact </u> :  <b> $r_last_name </b> <br />
     <img src=$src_carre> <u>Prénom du contact </u> : <b>  $r_first_name </b> <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville du contact </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Coordonnées du contact </u> : <b>  $r_phone_number </b> <br />
	 <img src=$src_carre> <u>Dossier </u> : <b>  R$id_recommandation </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
<br />
Pour information, vous pouvez suivre ces éléments dans votre intranet pour chaque dossier.<br />
<br />
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
<br /><br />
</p>
</div><br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Statut - Recommandation d'affaire NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function SEND_EMAIL_PARTENAIRE_COMPLEMENT($id_recommandation, $message_to_affilie)
{

	 // REQUETTE DE REMPLISSAGE DU MAIL 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #12");
		 $reponse = mysql_fetch_array($result);

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];

		 $reponse2 = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #MMM32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $mail_a         = $reponse2['email'];
		 
		 $reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."   ")) or die("Requete pas comprise - #3334-1! ");
	     $mail                        = $reponse3['p_contact_mail'];
		 $name_id_privileged_partner  = $reponse3['p_contact'];

	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:0px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour $name_id_privileged_partner, <br />                               
<br />
En tant que partenaire <a href='www.NosRezo.com' target='_blank'><b>NosRezo.com</b></a>, vous êtes actuellement en charge d'une recommandation d'affaire.  <br /><br />
Merci de revenir vers nous dans votre Intranet sur le point suivant :<br />
<b> $message_to_affilie </b> <br />
<br />
 ----------------------------<br />
<br />
Vous trouverez ci-après le rappel de la recommandation : <br />
     <img src=$src_carre> <u>Projet du contact </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Nom du contact </u> :  <b> $r_last_name </b> <br />
     <img src=$src_carre> <u>Prénom du contact </u> : <b>  $r_first_name </b> <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville du contact </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Coordonnées du contact </u> : <b>  $r_phone_number </b> <br />
	 <img src=$src_carre> <u>Dossier </u> : <b>  $id_recommandation </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
<br />
Pour information, vous pouvez suivre ces eléments dans votre intranet pour chaque dossier.<br />
<br />
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
<br /><br />
</p>
</div><br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Statut - Recommandation d'affaire";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function SEND_FACTURE_PARTENAIRE($connection_database2, $id_recommandation, $mode, $path_nosrezo_racine, $serveur, $host_mail, $user_mail, $password )
{
	     // REQUETTE DE REMPLISSAGE DU MAIL 
		 $rapport_activite = "";
	     mysql_query('SET NAMES utf8');	 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, relance_paiement, filename_facture_reco 
		             FROM   recommandation_details 
					 WHERE  id_recommandation = ".$id_recommandation."   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #12B789");
		 $reponse = mysql_fetch_array($result);
		 
		 IF  ($mode == "RELANCE")  {$text_details = "<b>RELANCE PAIEMENT TRÈS URGENT</b> <br/><br/>"; $text_titre = "RELANCE - "; }
		 ELSE	                   {$text_details = "";  $text_titre = "";  }

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
         $id_service             = $reponse['r_sub_category_code'];		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = trim($reponse['r_commentary']);
		 $relance_paiement       = $reponse['relance_paiement']; // TRAITEMENT DES RELANCES MANUELLES AUX IAD QUI N'ONT PAS PAYÉS
		 $filename_facture_reco  = trim($reponse['filename_facture_reco']);

		 $reponse2        = mysql_fetch_array(mysql_query("SELECT first_name, last_name, zip_code, city, phone_number, email 
		                                                   FROM   affiliate_details 
														   WHERE  id_affiliate = ".$id_affiliate."   ")) or die("Requete pas comprise - #PCC32! ");
	     $a_first_name    = $reponse2['first_name'];
		 $a_last_name     = $reponse2['last_name'];
		 $a_city          = $reponse2['city'];
		 $zip_code        = $reponse2['zip_code'];
		 $a_phone_number  = $reponse2['phone_number'];
		 $a_email         = $reponse2['email'];
		 
		 $reponse3                      = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_mail 
		                                                                 FROM partner_list where id_partner =".$id_privileged_partner."   ")) or die("Requete pas comprise - #33ER3-1! ");
	     $mail_partenaire_resp          = $reponse3['p_contact_mail'];
		 $name_id_privileged_partner    = $reponse3['p_contact'];
		 //$mail_partenaire_resp        = 'benjamin.allais@gmail.com';
		 
	     $reponse4 = mysql_fetch_array(mysql_query("SELECT count(*) as countrow, id_affiliate, password FROM affiliate where id_partenaire =".$id_privileged_partner."   ")) or die("Requete pas comprise - #PASS32! ");
		 $mdp                         = $reponse4['password'];
		 $id_affiliate_partenaire     = $reponse4['id_affiliate'];

		 IF ( ( $id_service == 1 OR $id_service == 50 OR $id_service == 2 ) AND $relance_paiement == 0 ) // FACTURATION DIRECTEMENT À IAD ET NON AU PARTENAIRE EN DIRECT 
		 { 		 
		    $reponse_service              = mysql_fetch_array(mysql_query(" SELECT id_services, master_contact_name, master_contact_mail FROM services where id_services =".$id_service."    ")) or die("Requete pas comprise - #33rZZtwi! ");
	        $mail_partenaire_resp         = $reponse_service['master_contact_mail'];
		    $name_id_privileged_partner   = $reponse_service['master_contact_name'];
			$rapport_activite =  '&nbsp &nbsp &nbsp &nbsp >>. Pas d\'envoi R'.$id_recommandation.' - '.$name_id_privileged_partner.'  '.$mail_partenaire_resp.' - IAD - Traitement fermé <br/>';

             //=========== MISE A JOUR DE LA TABLE DE SUIVI DES ENVOIS
	         UPDATE_RECOMMANDATION_FACTURE_SENT($id_recommandation, "IAD", 1); 
			
		 } 
		 ELSE IF ( $id_service == 51 OR $id_service == 52 OR $id_service == 53 OR $id_service == 54) // FACTURATION DIRECTEMENT A JARVIS ET NON AU PARTENAIRE EN DIRECT 
		 { 		 
		    $reponse_service              = mysql_fetch_array(mysql_query(" SELECT id_services, master_contact_name, master_contact_mail FROM services where id_services =".$id_service."    ")) or die("Requete pas comprise - #33rZZtwi! ");
	        $mail_partenaire_resp         = $reponse_service['master_contact_mail'];
		    $name_id_privileged_partner   = $reponse_service['master_contact_name'];
			$rapport_activite =  '&nbsp &nbsp &nbsp &nbsp >>. Pas d\'envoi R'.$id_recommandation.' - '.$name_id_privileged_partner.'  '.$mail_partenaire_resp.' - JARVIS - Traitement fermé <br/>';

             //=========== MISE A JOUR DE LA TABLE DE SUIVI DES ENVOIS
	         UPDATE_RECOMMANDATION_FACTURE_SENT($id_recommandation, "JARVIS", 1); 
			
		 } 
		 ELSE 
		 {
		 $societe_cible = RETURN_IF_IS_SOCIETE($connection_database2, "TRIFORCE", $id_privileged_partner, $id_service);
		 IF ($societe_cible == "TRIFORCE" )
		 { 		 
		         $reponse4             = mysql_fetch_array(mysql_query("SELECT id_services, master_destinataire, master_contact_mail, master_contact_name FROM services where id_services = 34    ")) or die("Requete pas comprise - #33rtwi! ");
		         $mail_partenaire_resp         = $reponse4['master_contact_mail'];
		         $name_id_privileged_partner   = $reponse4['master_contact_name'];
		 }	 
	 

            UPDATE_PLUS_1($connection_database2, $id_recommandation);
	 
	        $rapport_activite = ' &nbsp &nbsp &nbsp &nbsp >> Envoi R'.$id_recommandation.' - '.$name_id_privileged_partner.'  '.$mail_partenaire_resp.' <br/>';
			require_once $path_nosrezo_racine."/phpmailer/class.phpmailer.php"; 
            $mail = new PHPmailer(); 
            $mail->IsMail(); 
            $mail->IsHTML(true); 
            $mail->Host       = $host_mail ; 
            $mail->Username   = $user_mail ;
            $mail->Password   = $password ;
            $mail->From       = 'contact@nosrezo.com'; 
            $mail->AddAddress($mail_partenaire_resp); 
            $mail->AddAddress('contact@nosrezo.com'); 
            $mail->AddAddress('benjamin.allais@nosrezo.com'); 
            IF  ($mode <> "RELANCE")           {  $mail->AddAddress('cy-florette@soregor.fr, em-bahirenne@soregor.fr');  }
            IF  ($societe_cible == "TRIFORCE") {  $mail->AddAddress('ecrame.bentayeb@tri-force.fr');  }
            $mail->AddReplyTo('contact@nosrezo.com');      
            $mail->Subject =$text_titre.'Facture NosRezo - R'.$id_recommandation; 

            //=====Déclaration des messages au format texte et au format HTML.
            $src          = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
            $src_carre    = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
            $src_facebook = 'http://www.nosrezo.com/fichiers/facebook.png';
            $src_twitter  = 'http://www.nosrezo.com/fichiers/twitter.png';

$mail->Body = "
<html><head></head><body>
     <div style='width:auto height:auto; margin-top:0px; ' >
	    <img src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:2px; margin-left:5px;'>
$name_id_privileged_partner, <br /> 
<br />
$text_details En tant que partenaire, vous avez traité une recommandation <a href='www.NosRezo.com' target='_blank'><b>NosRezo</b></a>.
Vous trouverez en pièce-jointe la <b><font color=#fa38a3>FACTURE </font></b> de ce dossier. <br /><br />
Merci de bien vouloir dès reception de ce mail, procéder au paiement de cette facture par virement bancaire.<br />
	 
</p>
</div>

<div style='width:auto; height:auto; margin-top:2px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:0px; margin-left:5px;'>
$text_details Vous trouverez ci-après le rappel de ce dossier : <br />
     &nbsp &nbsp  <img src=$src_carre> <u>Projet</u> :  <b> $r_sub_category / $r_type </b> <br />
     &nbsp &nbsp  <img src=$src_carre> <u>Nom</u> :  <b> $r_last_name $r_first_name  </b> <br />
     &nbsp &nbsp  <img src=$src_carre> <u>Ville</u> : <b>  $r_zip_code $r_city </b> <br />
     &nbsp &nbsp  <img src=$src_carre> <u>Coordonnées</u> : <b>  $r_phone_number  </b> <br />
     &nbsp &nbsp  <img src=$src_carre> <u>Référence</u> : <b>  R$id_recommandation  </b> <br />
<br />
L'équipe NosRezo vous souhaite de nouvelles opportunités d'affaires grâce à nos services.<br />
<br />
Julie de l'équipe NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>NosRezo.com</b></a><br />
<br />
</p>
</div>
 
 </body></html>	 ";

// Pièce jointe 1
$path         = $path_nosrezo_racine.'/pdf_creation/';
$file_name    = FILENAME_RECOMMANDATION_FACTURE($connection_database2, $id_recommandation, $filename_facture_reco);
	
         IF (file_exists($path.$file_name))
         {
            $mail->AddAttachment($path.$file_name); 
 
             IF ($serveur == 'PRODUCTION')
             { 
                 if(!$mail->Send()) { echo $mail->ErrorInfo;} 
                 else               { echo '>>. Mail envoyé avec succès <br/>'; } 
                 $mail->SmtpClose(); 
                 unset($mail); 			
	         }	
             //=========== MISE A JOUR DE LA TABLE DE SUIVI DES ENVOIS
	         UPDATE_RECOMMANDATION_FACTURE_SENT($id_recommandation, $file_name, 1); 
         }	
         ELSE 
         { 
             echo "&nbsp &nbsp  Le fichier ".$path.$file_name ." n'est pas encore cree sur le serveur.  <br/>";
         }	 
} // FIN #1EDF 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
return ($rapport_activite);
}
?>

<?php  function INSERT_RECOMMANDATION_DETAILS_DUPLICATE($connection_database2, $id_recommandation)
{
				mysql_query('SET NAMES utf8');	
			    $id_reco_max   = mysql_fetch_array(mysql_query(" SELECT IFNULL(max(id_recommandation)+1, 1) as id_recommandation FROM recommandation_details ")) or die("Requete pas comprise - #MAX! ");
			    $result        = mysql_fetch_array(mysql_query(" SELECT id_recommandation, id_affiliate, r_status, r_creation_date, r_category, r_sub_category, r_sub_category_code, id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_lat, r_long, r_first_name, r_last_name, r_phone_number, r_email, r_connection_with, r_details,   r_devis_ttc, montant_tva_percent, r_gain_ttc,    r_gain, r_commentary, r_managed_date, duplicate_id_recommandation,  choose_to_not_pay    FROM recommandation_details WHERE id_recommandation = ".$id_recommandation."    ")) or die("Requete pas comprise - Insert Recommandation dpxj");

				$sql = 'insert into recommandation_details(id_recommandation, id_affiliate, r_status, r_creation_date, r_category, r_sub_category, r_sub_category_code, id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_lat, r_long, r_first_name, r_last_name, r_phone_number, r_email, r_connection_with, r_details,  r_devis_ttc, montant_tva_percent, r_gain_ttc,    r_gain, r_commentary, r_managed_date, duplicate_id_recommandation, choose_to_not_pay ) 
				                             values (
											 "'.$id_reco_max['id_recommandation'].'", 
											 "'.$result['id_affiliate'].'", 
											 "2",
											 CURRENT_TIMESTAMP,
											 "'.$result['r_category'].'",
											 "'.$result['r_sub_category'].'",
											 "'.$result['r_sub_category_code'].'",
											 "0",
											 "'.$result['r_type'].'",
											 "'.$result['r_address'].'",
											 "'.$result['r_zip_code'].'",
											 "'.$result['r_city'].'",
											 "'.$result['r_lat'].'", 
											 "'.$result['r_long'].'",
											 "'.$result['r_first_name'].'",
											 "'.$result['r_last_name'].'",
											 "'.$result['r_phone_number'].'",	
											 "'.$result['r_email'].'",
											 "'.$result['r_connection_with'].'",
											 "'.$result['r_details'].'",
                                             "0",
											 "0",
											 "0",
											 "0",
											 "'.$result['r_commentary'].'",
											 CURRENT_TIMESTAMP, 
											 "'.$id_recommandation.'",
											 "'.$result['choose_to_not_pay'].'")												 
											 ';
					//echo $sql;
					IF(mysql_query($sql))
					{
						 //SI ÇA A FONCTIONNÉ, ON AFFICHE UNE CONFIRMATION 							 
                         $result_1       = mysql_fetch_array(mysql_query("SELECT first_name, last_name, phone_number, email, id_affiliate, zip_code, city FROM affiliate_details where id_affiliate = ".$result['id_affiliate']."   ")) or die("Requete pas comprise - #VGT31! ");

					     $details  = "- Service : ".$result['r_sub_category']." \n - Recommandation : ".$result['r_first_name']." ".$result['r_last_name']." ".$result['r_address']." ".$result['r_zip_code']." ".$result['r_city']." - ".$result['r_email']."  \n - Affilié : ".$result_1['first_name']	."  ".$result_1['last_name']."   ".$result_1['phone_number']."   ".$result_1['email']."  -  ".$result_1['zip_code']."  ".$result_1['city']."   ";
						 insert_action_list("Étape 1", 10, " Recommandation envoyée à NosRezo"    , $id_reco_max['id_recommandation'], 0, $result['id_affiliate'], "FERME", $details ,"Dossier initialisé", "Service Admin", 0, ""); 
						 insert_action_list("Étape 2", 11, " Affecter un partenaire"    , $id_reco_max['id_recommandation'], 0, $result['id_affiliate'], "OUVERT", $details ,"Laissez NosRezo choisir un partenaire", "Service Admin", 0, "");
 
						 SEND_EMAIL_RECOMMANDATION($connection_database2, $id_reco_max['id_recommandation'], $result['id_affiliate'], $result['r_category'], $result['r_sub_category'], $result['r_zip_code'], $result['r_city'], $result['r_commentary'], $result['r_connection_with'], 0 , 0, 0 );
						 echo '<body onLoad="alert(\'Prise en compte de la recommandation de votre contact.\')">'; 
                         echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}
					else
					{
	              		 echo '<body onLoad="alert(\'Prescription non prise en compte : merci de contacter le support (support@nosrezo.com).\')">'; 
                         echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function calcul_date_relance($id_recommandation, $action_id_category, $r_sub_category_code, $prochaine_echeance) 
{ // L'ETAPE DE LA RECOMMANDATION :  $action_id_category
  // LE SERVICE                   :  $r_sub_category_code

	 $date_relance    = $prochaine_echeance + 4 ;
     return ($date_relance );
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function statut_fonction_etape_et_service($etape, $service, $source, $r_sub_category_code) 
{ 
	     $statut = "";
         IF ($etape == 4)  //////////////////////////////////   "4 - RDV planifié pour un devis"
		     {
                      if ($service == "immobilier")  
					        {    if ($r_sub_category_code == 1)                           // Mise en vente de bien
							                         {  $statut = "RDV planifié avec le partenaire pour une estimation du projet de vente"; }
						    else if ($r_sub_category_code == 2)                           // Mise en location de bien													 
							                         {  $statut = "RDV planifié avec le partenaire pour une estimation du projet de location"; }
						    else if ($r_sub_category_code == 4)                           // Financement de projet immobilier												 
							                         {  $statut = "RDV planifié avec le partenaire pour un plan de financement du projet immobilier"; }													 
						    else                     {  $statut = "RDV planifié avec le partenaire pour un devis du projet immobilier"; }													 
						     }							 
                 else if ($service == "recrutement") {	$statut = "RDV planifié avec le partenaire pour une présentation de notre opportunité professionnelle immobilière"; }							 
                 else if ($service == "travaux")     {	$statut = "RDV planifié avec le partenaire pour un devis sur la nature des travaux à réaliser"; }							 
                 else if ($service == "autres")      {	$statut = "RDV planifié avec le partenaire pour un devis"; }							 
                 else                                {	$statut = "RDV planifié avec le partenaire pour un devis/mandat/proposition";  }							 
             }
         ELSE IF ($etape == 5) //////////////////////////////   "5 - Devis envoyé au contact"
		     {
                      if ($service == "immobilier")  
					        {    if ($r_sub_category_code == 1)                           // Mise en vente de bien
							                         {  $statut = "L'estimation a été réalisée par notre professionnel de confiance. Nous sommes dans l'attente de signature du mandat. N'hésitez pas à revenir vers nous si vous avez des retours."; }
						    else if ($r_sub_category_code == 2)                           // Mise en location de bien													 
							                         {  $statut = "RDV réalisée avec le partenaire pour une estimation du projet de location"; }
						    else if ($r_sub_category_code == 4)                           // Financement de projet immobilier												 
							                         {  $statut = "Une estimation de plan de financement a été réalisée par notre professionnel de confiance. N'hésitez pas à revenir vers nous si vous avez des retours."; }													 
						    else                     {  $statut = "L'estimation a été réalisée par notre professionnel de confiance. N'hésitez pas à revenir vers nous si vous avez des retours."; }													 
						     }	
                 else if ($service == "recrutement") {	$statut = "La présentation de notre opportunité professionnelle immobilière à eu lieu avec votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }							 
                 else if ($service == "travaux")     {	$statut = "Le devis des travaux a été envoyé à votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }							 
                 else if ($service == "autres")      {	$statut = "Le devis a été envoyé à votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }							 
                 else                                {	$statut = "Le devis a été envoyé à votre contact. N'hésitez pas à revenir vers nous si vous avez des retours.";  }							 
             }
         ELSE IF ($etape == 6) //////////////////////////////   "6 - Devis validé par le contact" 
		     {
                      if ($service == "immobilier")  
					        {    if ($r_sub_category_code == 1)                           // Mise en vente de bien
							                         {  $statut = "Le mandat de vente a été signé par notre professionnel de confiance. Les visites vont commencer. N'hésitez pas à revenir vers nous si vous avez des retours."; }
						    else if ($r_sub_category_code == 2)                           // Mise en location de bien													 
							                         {  $statut = "Le mandat de location a été signé par notre professionnel de confiance. N'hésitez pas à revenir vers nous si vous avez des retours."; }
						    else if ($r_sub_category_code == 4)                           // Financement de projet immobilier												 
							                         {  $statut = "Le plan de financement réalisé par notre professionnel de confiance a été accepté par votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }													 
						    else                     {  $statut = "Le devis est validé par votre contact. La vente n'est pas encore réalisée. N'hésitez pas à revenir vers nous si vous avez des retours."; }													 
						     }	
                 else if ($service == "recrutement") {	$statut = "Pour votre information, votre contact rejoint nos équipes immobilières. Nous reviendrons vers vous sur le suivi de son activité."; }							 
                 else if ($service == "travaux")     {	$statut = "Le devis des travaux a été validé par votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }							 
                 else if ($service == "autres")      {	$statut = "Le devis a été validé par votre contact. N'hésitez pas à revenir vers nous si vous avez des retours."; }							 
                 else                                {	$statut = "Le devis a été validé par votre contact. N'hésitez pas à revenir vers nous si vous avez des retours.";  }							 
             }			 
         ELSE IF ($etape == 7) //////////////////////////////   "7 - Vente réalisée" 
		     {
                      if ($service == "immobilier")  {	$statut = "Proposition validée par votre contact. La vente est réalisée par notre professionnel de confiance."; }							 
                 else if ($service == "recrutement") {	$statut = "Pour votre information, votre contact rejoint nos équipes immobilières. Nous reviendrons vers vous sur le suivi de son activité."; }							 
                 else if ($service == "travaux")     {	$statut = "Le devis des travaux a été signé par votre contact. La vente est réalisée."; }							 
                 else if ($service == "autres")      {	$statut = "Le devis des travaux a été signé par votre contact. La vente est réalisée."; }							 
                 else                                {	$statut = "Le devis des travaux a été signé par votre contact. La vente est réalisée.";  }							 
             }			 
         ELSE IF ($etape == 8) //////////////////////////////   "7 - Vente réalisée" 
		     {
                 $statut = "Le professionnel dit avoir réalisé le virement de la commission NosRezo. Merci de contrôler le compte."; 						 
              }	
         ELSE IF ($etape == 34) //////////////////////////////   "Partenaire Non disponible" 
		     {
                 $statut = "Le 1er partenaire est indisponible. Nous contactons un autre partenaire sélectionné sur ce secteur."; 						 
              }	
			  

     return ( addslashes($statut) );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php function valideNir($nir){
 
        /*
        #####################################################################################################################
        # Par GV le 21 / 01 / 2014. Dans la REGEX, chaque ligne représente un groupe de règles ci-dessous.                  #
        #####################################################################################################################
        # Position 1 : 1 pour un homme, 2 pour une femme, 3 pour pour les personnes étrangère en cours d'imatriculation,    #
        # 7 et 8 pour les numéros provisoir                                                                                 #
        #####################################################################################################################
        # Position 2 et 3 : Les deux derniers chiffres de l'année de naissance, de 00 à 99                                  #
        #####################################################################################################################
        # Position 4 et 5 : Mois de naissance, de 01 (janvier) à 12 (décembre), de 20 à 30 et de 50 à 99 pour les           #
        # personnes dont la pièce d'état civil ne précise pas le mois de naissance, de 31 à 42 pour celle dont la pièce     #                
        # d'état civile est incomplète mais précise quand même le mois de naissance                                         #
        #####################################################################################################################
        # Position 6 à 10 : Trois cas de figures                                                                            #
        # CAS 1 :                                                                                                           # 
        # Position 6 et 7 : Département de naissance métropolitain, de 01 à 95 (plus 2A ou 2B pour la Corse)                #
        # Dans des cas exceptionnels, il est possible de trouver le numéro 96 qui correspondais à la Tunisie avant 1956.    #
        # Position 8, 9 et 10 : Numéro d'ordre de naissance dans le département, de 001 à 989 ou 990                        #
        # CAS 2 :                                                                                                           #
        # Position 6, 7 et 8 : Département de naissance Outre-mer, de 970 à 989                                             #
        # Position 9 et 10 : Numéro d'odre de naissance dans le département, de 01 à 89, ou 90                              #
        # CAS 3 :                                                                                                           #
        # Position 6 et 7 : Naissance hors de France, une seule valeur : 99                                                 #
        # Position 8, 9 et 10 : Identifiant du pays de naissance, de 001 à 989, ou 990                                      #
        #####################################################################################################################
        # Position 11, 12 et 13 : Numéro d'ordre de l'acte de naissance dans le mois et la commune (ou pays) de 001 à 999   #
        #####################################################################################################################
        # Position 14 et 15 : Clé de contrôle, de 01 à 97 (Non cotrôlé dans ce cas)                                         #
        #####################################################################################################################
        */
 
        $regexp = "/^
        ([1-37-8])
        ([0-9]{2})
        (0[0-9]|[2-35-9][0-9]|[14][0-2])
        ((0[1-9]|[1-8][0-9]|9[0-69]|2[abAB])(00[1-9]|0[1-9][0-9]|[1-8][0-9]{2}|9[0-8][0-9]|990)|(9[78][0-9])(0[1-9]|[1-8][0-9]|90))
        ([0-9]{3})
        ?([0-8][0-9]|9[0-7])
        /x";        
 
        return preg_match($regexp, $nir, $match);
}
?>


<?php  function send_email_creer_facture_partenaire($id_recommandation, $description_2, $serveur)
{

	 // REQUETE DE REMPLISSAGE DU MAIL 
	     mysql_query('SET NAMES utf8');	 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #1ED2");
		 $reponse = mysql_fetch_array($result);
		 
		 $mail_parrain      = mail_parrain_affilie($reponse['id_affiliate']); 

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 $r_date                 = $reponse['r_creation_date'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];

		 $reponse2 = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #QSQS32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $a_zip_code     = $reponse2['zip_code'];
		 
         $reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."  limit 0,1   ")) or die("Requete pas comprise - #33-2! ");
		 $id_privileged_partner       = $reponse3['id_partner'];
		 $name_id_privileged_partner  = $reponse3['p_contact'];
		 $mail                        = "contact@nosrezo.com";

	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour Benjamin Allais, <br />                               
<br />
Merci de réaliser <b>rapidement </b><font color=#fa38a3><b>la FACTURE client</b></font>.<br />
<br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Recommandation d'affaire :  <br />
     <img src=$src_carre> <u>Date de la recommandation </u> : <b> $r_date  </b> <br />
     <img src=$src_carre> <u>Projet du contact </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Nom du contact </u> :  <b> $r_last_name </b> <br />
     <img src=$src_carre> <u>Prénom du contact </u> : <b>  $r_first_name </b> <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville du contact </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Coordonnées du contact </u> : <b>  $r_phone_number  </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
     <img src=$src_carre> <u>Dossier </u> : <b>  $id_recommandation </b> <br />
     <img src=$src_carre> <u>Recommandé par </u> : <b>  $a_first_name $a_last_name - $a_city $a_zip_code </b> <br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>
<br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Facture à créer par le siège NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function RETURN_LIST_AFFILIATE_LEVEL($id_parrain, $level) 
{
		 mysql_query('SET NAMES utf8');	
		 $value = 0;
         $sql_master_1 = " SELECT id_affiliate, first_name, last_name, email , 1 as niveau
		                   FROM affiliate_details 
			    	       WHERE id_affiliate in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline = ".$id_parrain."   )  ";

         $sql_master_2 = $sql_master_1." UNION
                   		   SELECT id_affiliate, first_name, last_name, email , 2 as niveau
		                   FROM affiliate_details 
			    	       WHERE id_affiliate in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_parrain." )) ";

         $sql_master_3 = $sql_master_2." UNION
                   		   SELECT id_affiliate, first_name, last_name, email , 3 as niveau
		                   FROM affiliate_details 
			    	       WHERE id_affiliate in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_parrain." )  ))  ";
						   
         $sql_master_4 = $sql_master_3." UNION
                   		   SELECT id_affiliate, first_name, last_name, email , 4 as niveau
		                   FROM affiliate_details 
			    	       WHERE id_affiliate in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_parrain." ) )  ))  ";
												   
         $sql_master_5 = $sql_master_4." UNION
                   		   SELECT id_affiliate, first_name, last_name, email , 5 as niveau
		                   FROM affiliate_details 
			    	       WHERE id_affiliate in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline in (SELECT id_affiliate FROM affiliate where is_activated = 1 and id_upline=".$id_parrain." ) ) )  ))  ";
												   
						 						      
						   
	     IF ($level <= 1)           {   $sql_master = $sql_master_1;	   }
		 ELSE IF ($level == 2)      {   $sql_master = $sql_master_2;	   }
		 ELSE IF ($level == 3)      {   $sql_master = $sql_master_3;	   }		 	 
		 ELSE IF ($level == 4)      {   $sql_master = $sql_master_4;	   }	
		 ELSE IF ($level == 5)      {   $sql_master = $sql_master_5;	   }	
				 
	     return array ($sql_master, $value);
	 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function display_all_stars_hollywood($id_note) 
{
	     IF ($id_note == 0)  { echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> '; echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> '; }
	ELSE IF ($id_note == 1)  { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';}
	ELSE IF ($id_note == 2)  { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';}
	ELSE IF ($id_note == 3)  { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';  echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';}
	ELSE IF ($id_note == 4)  { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star-o" style="color:#FFCE2D;"></i> ';}
	ELSE IF ($id_note == 5)  { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';}
	ELSE                     { echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';   echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';    echo '<i class="fa fa-star" style="color:#FFCE2D;"></i> ';}
	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_AFFILIATE_CHALLENGE($id_affiliate, $debut_challenge, $fin_challenge, $challenge_niveau, $nb_reco_L1_points, $nb_filleuls_L2_points, $nb_filleuls_L3_points) 
{
		        mysql_query('SET NAMES utf8');	
			    $result            = mysql_fetch_array(mysql_query("SELECT IFNULL(max(id)+1, 1) as id_challenge FROM affiliate_challenge ")) or die("Requete pas comprise - #MAAA34X! ");
                $id_challenge      = $result['id_challenge'];
	 
				$sql ='insert into affiliate_challenge(id, id_affiliate, creation_date, debut_challenge, fin_challenge, challenge_niveau, nb_reco_L1_points, nb_filleuls_L2_points, nb_filleuls_L3_points ) 
				                             values (
											 "'.$id_challenge.'",
											 "'.$id_affiliate.'",
											 CURRENT_TIMESTAMP,
											 "'.$debut_challenge.'",
											 "'.$fin_challenge.'",
											 "'.$challenge_niveau.'",
											 "'.$nb_reco_L1_points.'",
											 "'.$nb_filleuls_L2_points.'",
											 "'.$nb_filleuls_L3_points.'"  )'; 

                $result = mysql_query($sql) or die("Requete pas comprise INSERT_AFFILIATE_CHALLENGE - function.php ");  
				return ($id_challenge);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function update_rib_banque($id_affiliate, $nom_banque, $code_banque, $code_guichet, $numero_compte, $cle_rib, $iban, $BIC_CLIENT) 
{
		        mysql_query('SET NAMES utf8');
			    $sql = "SELECT * FROM affiliate_iban where id_affiliate = ".$id_affiliate."  ";  
                IF (mysql_num_rows(mysql_query($sql)) == 0) // PAS DE LIGNE DANS LA TABLE : INSERT
                     { 				
				$sql ='insert into affiliate_iban(id_affiliate, code_banque, code_guichet, numero_compte, cle_rib, IBAN, BIC_CLIENT, iban_creation_date, nom_banque ) 
				                             values (
											 "'.$id_affiliate.'",
											 "'.$code_banque.'",
											 "'.$code_guichet.'",
											 "'.$numero_compte.'",
											 "'.$cle_rib.'",
											 "'.$iban.'",
											 "'.$BIC_CLIENT.'",
											 CURRENT_TIMESTAMP,
											 "'.$nom_banque.'")
											 ';
                      $result = mysql_query($sql) or die("Requete pas comprise insert_into_rib - function.php ");  
				     }
				ELSE
				     {
					  $sql = " UPDATE affiliate_iban 
					           SET code_banque        = '$code_banque', 
							       nom_banque         = '$nom_banque', 
								   code_guichet       = '$code_guichet', 
								   numero_compte      = '$numero_compte', 
								   cle_rib            = '$cle_rib', 
								   IBAN               = '$iban', 
								   BIC_CLIENT         = '$BIC_CLIENT',
								   iban_creation_date = CURRENT_TIMESTAMP 
								   WHERE id_affiliate = '$id_affiliate'  "; 
				      mysql_query($sql); 
					  //echo $sql;
					  
   			         }
				return ("OK");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function ASK_FOR_BEING_PAYED($connection_database2, $id_affiliate, $aX_payed, $entreprise, $name_facture_to_save, $country ) 
{ // AFFILLIÉ SOUHAITE ÊTRE PAYÉ : ATTENTION IL PEUT ENCAISSER PLUSIEURS RECOMMANDATIONS EN UNE SEULE FOIS
         IF    ( $aX_payed      == 0)       /// DEMANDE DE PAIEMENT DES LIGNES A 0
	           { $next_aX_payed = 5; }      /// LIGNES PASSENT DE 0 A EN COURS DE PAIEMENT
		 ELSE  { $next_aX_payed = 1; }      /// LIGNES PASSENT EN COURS DE PAIEMENT A PAYE
		 
				 $num                = 0;
				 $ref                = randomPassword();    // CLÉ UNIQUE SUR CHAQUE PAIEMENT AFIN DE POUVOIR LES REGROUPER EN CAS DE PROBLÈME
				 $ref2               = "C";
				 $somme_a_payer_brut = 0;
				 //date_default_timezone_set('Europe/Paris');
		         mysql_query('SET NAMES utf8');
                 $result = mysql_query(" SELECT id_comptable, id_recommandation, aX_id_affiliate, aX_amount_ht 
				                         FROM recommandation_comptable 
									     WHERE aX_id_affiliate = ".$id_affiliate." 
										 AND aX_payed          = ".$aX_payed."     ") or die("Requete pas comprise : ask for_being_payed ");	
										
   			     WHILE ($reponse = mysql_fetch_array($result))
                        {  				
                             $ref2                =  $ref2.'-'.$reponse["id_comptable"];
							 $somme_a_payer_brut  =  $somme_a_payer_brut + $reponse["aX_amount_ht"];                           	
				             $id_comptable        =  $reponse["id_comptable"];
							 IF ($entreprise == 0)
							 {
				             mysql_query(" UPDATE recommandation_comptable 
							               SET aX_payed ='$next_aX_payed', 
										   aX_ref  ='$ref'  , 
										   aX_note ='$ref2' ,
                                           name_facture = '$name_facture_to_save' ,										   
										   aX_asked_payed_date   = CURRENT_TIMESTAMP 
										   WHERE aX_id_affiliate ='$id_affiliate' 
										   AND  id_comptable = '$id_comptable'          ");
                             }
							 ELSE
							 {
				             mysql_query(" UPDATE recommandation_comptable 
							               SET aX_payed ='$next_aX_payed', 
										   aX_ref  ='$ref'  , 
										   aX_note ='$ref2' , 
										   facture_entreprise = 1 ,
                                           name_facture = '$name_facture_to_save' ,										   
										   aX_asked_payed_date   = CURRENT_TIMESTAMP 
										   WHERE aX_id_affiliate ='$id_affiliate' 
										   AND  id_comptable = '$id_comptable'          ");
                             }

										   
   			            }

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							 $nom = NOM_PRENOM_AFFILIATE($id_affiliate);
							 $nom  = str_replace("\"", "", $nom);
							 IF ($entreprise == 0)
							 {						
                                      
									  IF ( $country == "FRANCE" ) 
									  {
									  //1. ON HISTORISE L'ACTION D'ENVOI AU COMPTABLE
                                       INSERT_ACTION_LIST("Étape 9.3", 23, "Payer Affilié A".$id_affiliate."  sur sa demande. Montant Comptable en cours.", "Merci de procéder au virement de : ".$somme_a_payer_brut ." € BRUT - Référence comptable :".$ref2."  ", 0, $id_affiliate, "FERME", "Afin de clore le dossier - Merci de procéder au virement de : ".$somme_a_payer_brut ." € BRUT. Référence comptable :".$ref2.". Pour clore la recommandation une fois le paiement réalisé, cliquer sur Étape 10. " ,$ref, "Service Admin", 1, "");
                                       INSERT_ACTION_LIST("CALCUL CHARGES VDI", 25, "Rémunération VDI à déterminer - Référence comptable : ".$ref2." ", "Montant de ".$somme_a_payer_brut ." € BRUT - Référence comptable : ".$ref2."  ", 0, $id_affiliate, "OUVERT", "Determiner les charges à payer : ".$somme_a_payer_brut ." € BRUT. Référence comptable :".$ref2 ,$ref, "COMPTABLE", 1, "");

				                      //2. LES DONNÉES SONT RENSEIGNÉES DONC ON ENVOI AU COMPTABLE POUR CONNAITRE LE MONTANT
					                  include('email/comptable_paiement_mail.php'); 
					                  SEND_EMAIL_COMPTABLE1($connection_database2, $id_affiliate, 0, $ref );
					               
					                  //3. ON INSÉRE L'ACTION POUR LE PAIEMENT DE L'AFFILIÉ SUITE AU RETOUR DU COMPTABLE
					                  INSERT_ACTION_LIST("Étape 10", 19, "En attente du montant validé par le comptable, pour ".$nom, 0, 0, $id_affiliate, "OUVERT", " Un mail a été envoyé au comptable pour connaître le montant exact. \n Proceder au paiement pour clotûrer cette recommandation. " , $ref, "Service Admin",2, "");
							          }
									  ELSE
									  {
					                  INSERT_ACTION_LIST("Étape 10", 19, "Paiement au Portugal pour ".$nom, 0, 0, $id_affiliate, "OUVERT", "Proceder au paiement pour clotûrer cette recommandation.<br/>Karim ne souhaite pas payer les charges sociales. <br/>Il dit que tout est OK. " , $ref, "Service Admin",2, "");										
									  }
							 
							 }
							 ELSE // MODE ENTREPRISE
							 {							 							   
							   INSERT_ACTION_LIST("Étape 9.4", 24, " Nous avons recu la facture de l\'affilié ".$nom." - A".$id_affiliate." <br/>Facture : ".$name_facture_to_save, "Procéder au virement de Référence comptable  ", 0, $id_affiliate, "OUVERT", "Cliquer sur le boutton. " ,$ref, "Service Admin", 1, "");
                             }

				return ("OK");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function DISPLAY_IBAN($iban, $char_espace)  // FONCTION QUI RETOURNE L'ÂGE
{ // AJOUTER BLANC TOUS LES 4 CHAR
    
	$iban_1      = substr(trim($iban), 0                                                                                      , $char_espace);
	$iban_2      = substr(trim($iban), $char_espace                                                                           , $char_espace);
	$iban_3      = substr(trim($iban), $char_espace + $char_espace                                                            , $char_espace);
	$iban_4      = substr(trim($iban), $char_espace + $char_espace + $char_espace                                             , $char_espace);
	$iban_5      = substr(trim($iban), $char_espace + $char_espace + $char_espace + $char_espace                              , $char_espace);
	$iban_6      = substr(trim($iban), $char_espace + $char_espace + $char_espace + $char_espace + $char_espace               , $char_espace);
	$iban_7      = substr(trim($iban), $char_espace + $char_espace + $char_espace + $char_espace + $char_espace + $char_espace, $char_espace);
	
	$iban        = $iban_1.' '.$iban_2.' '.$iban_3.' '.$iban_4.' '.$iban_5.' '.$iban_6.' '.$iban_7  ;
	
    return ($iban);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function CALCUL_AGE($naiss)  // FONCTION QUI RETOURNE L'ÂGE
{ // FPRMAT CORRECT : 15/07/1979
    $naiss = str_replace("-", "/", $naiss);
    $naiss = str_replace(".", "/", $naiss);
    $naiss = str_replace(" ", "/", $naiss);
    // DÉCOUPER LA DATE DANS UN TABLEAU ASSOCIATIF

    IF ( is_num(substr(trim($naiss), 0, 2)) == 0 ) { return 0; }
    ELSE IF ( substr(trim($naiss), 2, 1) <> "/" )       { return 0; }
    ELSE IF ( substr(trim($naiss), 5, 1) <> "/" )       { return 0; }
	ELSE
	{

    list($jour, $mois, $annee) = explode('/', $naiss);
	
	If (    is_num($jour)  == 0 
        OR  is_num($mois)  == 0 
        OR  is_num($annee) == 0
		OR  $jour >31
        OR  strlen($annee) < 4 		
		)
		{	// PB DE FORMAT	
			 return 0;
		}
	ELSE
	{
         //date_default_timezone_set('Europe/Paris');
		 // RÉCUPÉRER LA DATE ACTUELLE DANS DES VARIABLES
         $today['mois']  = date('n');
         $today['jour']  = date('j');
         $today['annee'] = date('Y');
         
	     // CALCULER LE NOMBRE D'ANNÉES ENTRE L'ANNÉE DE NAISSANCE ET L'ANNÉE EN COURS
         $annees = $today['annee'] - $annee;
         
         // SI LE MOIS EN COURS EST INFÉRIEUR AU MOIS D'ANNIVERSAIRE, ENLEVER UN AN
         if ($today['mois'] < $mois) 
	     {
         $annees--;
         }
         
	     // PAREIL SI ON EST DANS LE BON MOIS MAIS QUE LE JOUR N'EST PAS ENCORE VENU
         if ($mois == $today['mois'] && $jour> $today['jour']) 
	     {
         $annees--;
         }
	     return $annees;
	}
	}

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function nosrezo_nb_partner($id_param)
{ // 
     include('config.php');
	 $result         = mysql_fetch_array(mysql_query("SELECT max(id_partner) AS nb_partner FROM partner_list   ")) or die("Requete pas comprise - #3QQA0912! ");
     $nb_partner     = $result['nb_partner'];	
	 
     return ($nb_partner); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function DISPLAY_PROFILE_PICTURE_PARTENAIRE($id_affiliate)
{ // 
     $path     = "fichiers/partenaires/photos/images_resize/partenaire_".$id_affiliate."_profile.png";
     IF (!file_exists($path)) 
	    {  
         $path     = "fichiers/partenaires/photos/profil/partenaire_X_profile.png";  
		} 

     return ($path); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DISPLAY_PROFILE_PICTURE_AFFILIE($id_affiliate, $param1, $param2)
{ // 
     $path     = "fichiers/affilies/photos/images_resize/affilie_".$id_affiliate."_profile.png";
     IF (!file_exists($path)) 
	    {  
         $path     = "fichiers/partenaires/photos/profil/partenaire_X_profile.png";  
		} 

     return ($path); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function check_if_facture_generated($id_recommandation)
{ // 
     include('config.php');
	 $reponse    = mysql_fetch_array(mysql_query("SELECT count(*) as facture_ok FROM action_list where id_recommandation =".$id_recommandation." and action_id_category = 21 ")) or die("Requete pas comprise du statut action_list - #31TRJ3-3   ");
	 $facture_ok = $reponse['facture_ok']; 	 
	 
     return ($facture_ok); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php  function calcul_commission_mlm($connection_database2, $id_recommandation, $r_sub_category_code, $montant_devis_ttc, $montant_tva_facture, $mode, $param2) 
{ 
    IF ($montant_devis_ttc == 0)
	    { 
		     	 return(0);
		}	
    ELSE
	    {
         include('config.php');            
         $reponse  = mysql_fetch_array(mysql_query(" SELECT com_nosrezo_percent, com_nosrezo_forfait, tva_percent_to_pay  
		                                             FROM  services  
													 WHERE id_services = ".$r_sub_category_code."    ")) or die("Site Partenaire en maintenance #5R5- contact@nosrezo.com ");
	     $com_nosrezo_percent = $reponse["com_nosrezo_percent"];
	     $com_nosrezo_forfait = $reponse["com_nosrezo_forfait"];
	     $tva_percent_to_pay  = $reponse["tva_percent_to_pay"];
		 
	     IF ($com_nosrezo_forfait <> 0) 
	         { 
		     	 return($com_nosrezo_forfait);
		     }
         ELSE //////////////////////////////////////////////////////////////////////////////////////// CALCUL A REALISER 
             {  IF ($r_sub_category_code == 4)                                                      // FINANCEMENT DE PROJET IMMOBILIER
			     { $commission_mlm = $montant_devis_ttc /1.2 * 0.2 / 100;                           // TVA POUR LES FINANCEMENTS
			        IF ($commission_mlm > 625) {$commission_mlm = 625;}                             // CF. INTRANET_SIMULATION.PHP POUR SIMIULATION

                        // REGLES POUR LE FINANCEMENT : LEVEL 1 RECOIT 0,12% DU MONTANT TTC DU CRÉDIT
						// DONC POUR LE MLM TOTAL LE CHIFFRE EST 0,20% [PS: 0,20% * 0,60% = 0,12%]						
						// LE PLAFOND EST 1500€ / 0,5% SOIT 300 000€ DE PRET : soit * 0,2% = 600 € mais cadeau à 625€ pour ne pas embeter Karim !

					
			     }
		        ELSE // TOUS LES AUTRES SERVICES
			     { 
			       $montant_devis_ht  = $montant_devis_ttc / (1 + $tva_percent_to_pay/100);
			       $commission_mlm    = $montant_devis_ht * $com_nosrezo_percent/100;
			       if ($montant_devis_ttc > 300000)         { $commission_mlm = 0;}
			     }			
			
			     return($commission_mlm);
		     }
	}	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function insert_into_planning_nr_reservation($id_action_planning , $id_affiliate, $action) 
{
 		        IF(get_magic_quotes_gpc()) 
				     { 
				         $id_action_planning = stripslashes($id_action_planning); 
						 $id_affiliate       = stripslashes($id_affiliate); 
				    }
					    $id_action_planning  = trim(mysql_real_escape_string($id_action_planning));
			            $id_affiliate        = trim(mysql_real_escape_string($id_affiliate));	

                include('config.php'); 
				//date_default_timezone_set('Europe/Paris');
				
				$sql ='DELETE FROM planning_nr_reservation WHERE id_action_planning='.$id_action_planning.'  and id_affiliate = '.$id_affiliate.' '; 						
		        mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete pas comprise ~ZQSQSQS");
				
				IF ($action == 1) 
				{ $sql ='insert into planning_nr_reservation(id_action_planning , id_affiliate, creation_date) 
				                             values (
											 "'.$id_action_planning.'",
											 "'.$id_affiliate.'",
											 CURRENT_TIMESTAMP)
											 ';

				mysql_query('SET NAMES utf8');
                $result = mysql_query($sql) or die("Requete pas comprise ~QSQSQSQS");
		        }
            
                // ON COMPTE LES NOUVEAUX PARTICIPANTS
				 $result2       = mysql_query("SELECT * FROM planning_nr_reservation where id_action_planning = ".$id_action_planning."     ") or die("Site en Maintenance - contact@nosrezo.com #3");
                 $nb_inscrits   = mysql_num_rows($result2);
				 $sql2 = "UPDATE planning_nr 
				                     SET place_reservees ='$nb_inscrits'
									 WHERE id_action_planning='$id_action_planning' "; 
				 mysql_query($sql2) or die("Requete pas comprise #AZ8ZZJJ9");	
				 return ("OK");
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function delete_planning_event($id_action_planning) 
{
  		        IF(get_magic_quotes_gpc()) 
				     { 
				         $id_action_planning = stripslashes($id_action_planning); 
				    }
					    $id_action_planning  = trim(mysql_real_escape_string($id_action_planning));

		 $sql ='DELETE FROM planning_nr_reservation WHERE id_action_planning='.$id_action_planning.'    '; 	
         $result = mysql_query($sql) or die("Requete pas comprise #ZER345");
		 
		 $sql ='DELETE FROM planning_nr WHERE id_action_planning='.$id_action_planning.'    '; 	
         $result = mysql_query($sql) or die("Requete pas comprise #ZER345");		  
		  
		 return ("OK");
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function update_planning_nr($id_action_planning, $planning_time, $evenement, $details, $id_affiliate, $presentateur, $endroit, $endroit_complement, $adresse, $place_disponible) 
{
 
 		        IF(get_magic_quotes_gpc()) 
				     { 
				         $id_action_planning = stripslashes($id_action_planning); 
						 $evenement          = stripslashes($evenement); 
				         $details            = stripslashes($details); 
						 $presentateur       = stripslashes($presentateur); 
						 $endroit            = stripslashes($endroit); 
						 $adresse            = stripslashes($adresse); 
						 $place_disponible   = stripslashes($place_disponible); 
						 $endroit_complement = stripslashes($endroit_complement); 
				    }
					    $id_action_planning  = trim(mysql_real_escape_string($id_action_planning));
			            $evenement           = trim(mysql_real_escape_string($evenement));	
				        $details             = trim(mysql_real_escape_string($details));
						$presentateur        = trim(mysql_real_escape_string($presentateur));
						$endroit             = trim(mysql_real_escape_string($endroit));
						$adresse             = trim(mysql_real_escape_string($adresse));
						$place_disponible    = trim(mysql_real_escape_string($place_disponible));
						$endroit_complement  = trim(mysql_real_escape_string($endroit_complement));
 
                 IF ($id_action_planning > 0)
				 { 
				 $sql2 = "UPDATE planning_nr 
				                     SET     evenement            = '$evenement',
									         details              = '$details',
											 endroit              = '$endroit',
											 endroit_complement   = '$endroit_complement',
											 adresse              = '$adresse',
											 place_disponible     = '$place_disponible',
											 planning_time        = '$planning_time'
									 WHERE id_action_planning     = '$id_action_planning' "; 
				 mysql_query($sql2) or die("Requete pas comprise #AZ8AAJJ9");	
				 }
				 return ("OK");
	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function insert_into_planning_nr_event($planning_time, $evenement, $details, $id_affiliate, $presentateur, $endroit, $adresse, $endroit_complement, $place_disponible) 
{
 		        IF(get_magic_quotes_gpc()) 
				     { 
						 $evenement          = stripslashes($evenement); 
				         $details            = stripslashes($details); 
						 $presentateur       = stripslashes($presentateur); 
						 $endroit            = stripslashes($endroit); 
						 $adresse            = stripslashes($adresse); 
						 $place_disponible   = stripslashes($place_disponible); 
						 $endroit_complement = stripslashes($endroit_complement); 
				    }
			            $evenement           = trim(mysql_real_escape_string($evenement));	
				        $details             = trim(mysql_real_escape_string($details));
						$presentateur        = trim(mysql_real_escape_string($presentateur));
						$endroit             = trim(mysql_real_escape_string($endroit));
						$adresse             = trim(mysql_real_escape_string($adresse));
						$place_disponible    = trim(mysql_real_escape_string($place_disponible));
						$endroit_complement  = trim(mysql_real_escape_string($endroit_complement));

				//date_default_timezone_set('Europe/Paris');
                $sql ='insert into planning_nr( id_action_planning , planning_time, evenement, details, id_affiliate, presentateur, endroit, endroit_complement, adresse, place_disponible, place_reservees, creation_date) 
				                             values (
											 "",
											 "'.$planning_time.'",
											 "'.$evenement.'",
											 "'.$details.'",
											 "'.$id_affiliate.'",
											 "'.$presentateur.'",
											 "'.$endroit.'",
											 "'.$endroit_complement.'",
											 "'.$adresse.'",
											 "'.$place_disponible.'",
											 0,
											 CURRENT_TIMESTAMP)
											 ';
				 mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise #12POLLL");  
				 return ("OK");	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php  function INSERT_INTO_RECOMMANDATION_REFUSE_PARTENAIRE($connection_database2, $id_recommandation, $id_partenaire, $id_affiliate, $motif, $detail) 
{
 		        IF(get_magic_quotes_gpc()) 
				     { 
						 $id_recommandation   = stripslashes($id_recommandation); 
				         $id_affiliate        = stripslashes($id_affiliate); // AFFILIÉ QUI A FAIT LA RECO
						 $motif               = stripslashes($motif); 
						 $detail              = stripslashes($detail); 
						 $id_partenaire       = stripslashes($id_partenaire); 
				    }
			            $id_recommandation    = trim(mysql_real_escape_string($id_recommandation));	
				        $id_affiliate         = trim(mysql_real_escape_string($id_affiliate));
						$motif                = trim(mysql_real_escape_string($motif));
						$detail               = trim(mysql_real_escape_string($detail));
						$id_partenaire        = trim(mysql_real_escape_string($id_partenaire));	
				
				//date_default_timezone_set('Europe/Paris');
                $sql ='insert into recommandation_refuse_partenaire( id_refuse, id_recommandation, id_partenaire, id_affiliate, r_creation_date, r_motif, r_detail) 
				                             values (
											 "",
											 "'.$id_recommandation.'",
											 "'.$id_partenaire.'",
											 "'.$id_affiliate.'",
											 CURRENT_TIMESTAMP,
											 "'.$motif.'",
											 "'.$detail.'")
											 ';
				 mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise #12POZLLL");  
				 return ("OK");	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function affiliate_permission_access($id_affiliate, $champs) 
{
	$sql    = "SELECT COUNT(id_affiliate) AS id_affiliate FROM users_permissions where id_affiliate = ".$id_affiliate."    ";            
    $result = mysql_fetch_array(mysql_query($sql)) or die("Site Partenaire en maintenance #TY- contact@nosrezo.com ");
	IF ($result['id_affiliate'] == 0) 
	     { 
	     return (1);    
		 }
	ELSE 
         {
	     $sql        = "SELECT  ".$champs." AS champs FROM users_permissions where id_affiliate = ".$id_affiliate."    ";            
         $result     = mysql_fetch_array(mysql_query($sql)) or die("Site Partenaire en maintenance #TY- contact@nosrezo.com ");
         $permission = $result['champs'];		 
		 return ($permission );   
		 }

}
?>	

<?php  function insert_into_table_boite_a_idee($id_affiliate, $idee) 
{

                include('config.php'); 				
				//date_default_timezone_set('Europe/Paris');
                $sql ='insert into table_boite_a_idee( ID_idee , creation_date, id_affiliate, idee, commentaire_nosrezo, pris_en_compte ) 
				                             values (
											 "",
											 CURRENT_TIMESTAMP,
											 "'.$id_affiliate.'",
											 "'.$idee.'",
											 "En cours de traitement",
                                             "")
											 ';
				 mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise #14PZLLL");  
				 return ("OK");	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>



<?php  function send_email_boite_a_idee($id_affiliate, $idee)
{
		 $reponse2 = mysql_fetch_array(mysql_query("SELECT first_name, last_name, zip_code, city, phone_number, email FROM affiliate_details where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #BVMPW32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $a_phone_number = $reponse2['phone_number'];
		 $a_email        = $reponse2['email'];
		 
	     $mail                        = "contact@nosrezo.com";
	 	 	
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#FFFFFF;'>
      <div style='width:auto height:auto; margin-top:5px; ' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour Nosrezo, <br />
										   <br />
Nous venons de recevoir une idée  :  <br />
     <img src=$src_carre>  <b> $idee  </b> <br /><br />
<br />
Cette idée nous est proposée par un affilié de NosRezo :<br />
     <img src=$src_carre> <u>Nom de l'affilié </u> :  <b> $a_last_name </b> <br />
     <img src=$src_carre> <u>Prénom de l'affilié  </u> : <b>  $a_first_name </b> <br />
     <img src=$src_carre> <u>ID de l'affilié  </u> : <b>  $id_affiliate </b> <br />
	 <img src=$src_carre> <u>Ville de l'affilié </u> : <b>  $zip_code $a_city </b> <br />
	 <img src=$src_carre> <u>Contact de l'affilié pour plus de détails</u> : <b>  $a_phone_number $a_email </b> <br />

</div>

<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:0px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Boîte à idée NosRezo";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function SEND_EMAIL_INFO_COMPLEMENT_RECO_AFFILIE($id_affiliate, $id_recommandation, $commentaire_affilie, $mode_envoi_destinataire, $connection_database2)
{
		 $src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
		 $src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';

         List ($id_affiliate, $id_partenaire, $first_name_p, $last_name_p, $email_p, $phone_number_p, $address_p, $zip_code_p, $city_p ) = RETURN_INFO_AFFILIATE($id_affiliate);		 
	     $mail           = "contact@nosrezo.com";
		 
		 List ($r_sub_category_code, $id_affiliate, $id_privileged_partner, $r_lat, $r_long, $r_last_name,  $r_first_name, $r_sub_category, $r_city, $r_zip_code, $r_address, $r_type, $r_phone_number, $r_email, $r_connection_with, $r_commentary, $r_creation_date, $r_status, $r_category, $r_devis_ttc, $montant_tva_percent, $r_gain_TTC, $r_gain, $duplicate_id_recommandation, $choose_to_not_pay ) = return_info_recommandation($id_recommandation); 
         
		 $info_partenaire        = "";
		 $envoi_aussi_partenaire = "";
		 IF ($id_privileged_partner > 0)
		 {
			     List($id_affiliate_partenaire, $id_ppartenaire, $first_name_ap, $last_name_ap, $email_ap, $phone_number_ap )= RETURN_INFO_AFFILIATE_FROM_ID_PARTENAIRE( $connection_database2, $id_privileged_partner);
				 $info_partenaire = "Partenaire NosRezo :<br />
                                     <img src=$src_carre> <u>Nom du partenaire </u> :  <b> $last_name_ap </b> <br />
                                     <img src=$src_carre> <u>Prénom du partenaire  </u> : <b>  $first_name_ap </b> <br />
	                                 <img src=$src_carre> <u>Contact du partenaire pour plus de détails</u> : <b>  $phone_number_ap $email_ap </b> <br />";
									 
				IF ($mode_envoi_destinataire == 2) { $envoi_aussi_partenaire = $email_ap;}					 
		 }
		 
	 	 	
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour Nosrezo, <br />
										   <br />
Un affilié apporte des informations sur la R$id_recommandation  :  <br />
     <img src=$src_carre>  <b> $commentaire_affilie  </b> <br />
<br />
Recommandation : <br />
     <img src=$src_carre> <u>Projet </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Adresse </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Dossier </u> : <b>  $id_recommandation </b> <br />
     <img src=$src_carre> <u>Coordonnées  </u> : <b>  $r_phone_number  </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
<br />
Affilié NosRezo :<br />
     <img src=$src_carre> <u>Nom de l'affilié </u> :  <b> $last_name_p </b> <br />
     <img src=$src_carre> <u>Prénom de l'affilié  </u> : <b>  $first_name_p </b> <br />
     <img src=$src_carre> <u>ID de l'affilié  </u> : <b>  $id_affiliate </b> <br />
	 <img src=$src_carre> <u>Ville de l'affilié </u> : <b>  $zip_code_p $city_p </b> <br />
	 <img src=$src_carre> <u>Contact de l'affilié pour plus de détails</u> : <b>  $phone_number_p $email_p </b> <br />
<br />
$info_partenaire
<br />
</div>

<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Complement d'information : R$id_recommandation";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc: eric.nosrezo@gmail.com, julie.nosrezo@gmail.com, ".$envoi_aussi_partenaire." ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>



<?php  function update_affilie_details_latitude_longitude($id_affiliate, $latitude, $longitude) 
{
     include('config.php'); 
	 mysql_query("UPDATE affiliate_details 
	                     SET  affiliate_latitude = '$latitude',
						     affiliate_longitude = '$longitude'
					     WHERE id_affiliate      = '$id_affiliate' ");            
   	 return ("OK");
}
?>



<?php  function send_email_mauvais_mail($mail_parrain, $mail_filleul)
{
	     $mail  = $mail_parrain;		
		 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Bonjour, <br />
										   <br />
Pour votre information, le mail de votre filleul ci-dessous est incorrect :  <br />
     <img src=$src_carre> <u>Mail </u> : <b>  <font color=#fa38a3> $mail_filleul </font> </b> <br />
<br />
N'hésitez pas à revenir vers nous avec le bon mail afin que nous prenions en compte cette information.<br />
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
Toute l'équipe NosRezo vous souhaite de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo.<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>
<br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Mail incorrect de votre filleul";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     include('config.php'); 
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function display_documents_partenaires($id_services)
{ // 
     IF (      ($id_services == 1)  	// MISE EN VENTE DE BIEN  
	      OR   ($id_services == 2)  	// MISE EN LOCATION DE BIEN
	      OR   ($id_services == 4)  	// FINANCEMENT DE PROJET IMMOBILIER
	      OR   ($id_services == 7)  	// RECHERCHE DE BIEN IMMOBILIER
	      OR   ($id_services == 8)  	// RECRUTEMENT IMMOBILIER
	      OR   ($id_services == 22) 	// ARCHITECTE DIPLÔMÉ
	      OR   ($id_services == 30)  	// AUTRES
	      OR   ($id_services == 32)  	// GARAGISTE - RÉPARATION VOITURE
	      OR   ($id_services == 56)  	// RECRUTEMENT IMMOBILIER		  
	    ) 
	    {  return (0);   } 				// ON N'AFFICHE PAS LES ONGLETS OU LES DOCUMENTS
	 ELSE 
 	     { return (1);   } 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_NOTIFICATION_AFFILIE_OUVERTE($id_affiliate) 
{
     $result       =  mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as notification 
	                                                  FROM action_notification 
													  WHERE id_affiliate =".$id_affiliate."  
													  AND notification_status = 1 
													  AND notification_read = 0 ")) or die("Requete pas comprise - COUNT_NOTIFICATION_AFFILIE_OUVERTE ");
     $notification =  $result['notification'];
     return ($notification); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_NOTIFICATION_AFFILIE_OUVERTE_NOTIFICATION($id_affiliate) 
{
     $result       =  mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as notification 
	                                                  FROM action_notification 
													  WHERE id_affiliate =".$id_affiliate."  
													  AND notification_status = 1 
													  AND notification_code = 2
													  AND notification_read = 0 ")) or die("Requete pas comprise - COUNT_NOTIFICATION_AFFILIE_OUVERTE ");
     $notification =  $result['notification'];
     return ($notification); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_NOTIFICATION_CALENDAR_OUVERTE($param1, $param2) 
{
     $result       =  mysql_fetch_array(mysql_query(" SELECT count(id_action_planning) as notification 
						                              FROM planning_nr plnr 
						                              WHERE PLANNING_TIME > DATE_SUB( CURDATE(),  INTERVAL 0 DAY) ")) or die("Requete pas comprise - COUNT_NOTIFICATION_AFFILIE_OUVERTE ");
     $notification =  $result['notification'] + 1;
     return ($notification); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affiliate)
{ // 
             
			 $path     = "fichiers/partenaires/photos/images_resize/partenaire_".$id_affiliate."_profile.png";
             IF (!file_exists($path)) 
                {           $path     = "fichiers/affilies/photos/profil/affilie_".$id_affiliate."_profile.png";
                            IF (!file_exists($path)) 
                               {   $path     = "fichiers/partenaires/photos/profil/partenaire_X_profile.png";  }
             	} 

     return ($path); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_P_LIST_COMPETENCE($id_affiliate, $id_partenaire, $id_competence, $nb_competence) 
{
     $id_affilie_qui_recommande1 = 0;
	 $id_affilie_qui_recommande2 = 0;
	 $id_affilie_qui_recommande3 = 0;
	 
	 IF ( $nb_competence > 0)
	 {
             $result       =  mysql_query(" SELECT id_affilie_qui_recommande 
                                            FROM partner_list_competencer 
             							    WHERE id_partner_cible = ".$id_partenaire."
                                            AND   is_activated     = 1													  
             							    AND   id_competence    = ".$id_competence."   ");;
             $compteur      = 0;
             
             WHILE ($reponse = mysql_fetch_array($result) AND $compteur < 4)
             {
                 $compteur      = $compteur + 1;
                 IF ( $compteur == 1)  { $id_affilie_qui_recommande1 = $reponse["id_affilie_qui_recommande"]; }
                 IF ( $compteur == 2)  { $id_affilie_qui_recommande2 = $reponse["id_affilie_qui_recommande"]; }
             	 IF ( $compteur == 3)  { $id_affilie_qui_recommande3 = $reponse["id_affilie_qui_recommande"]; }
             }
             
     
            // SI 1 SEUL PARTENAIRE QUI RECOMMANDE
	        IF ( $nb_competence == 1)
	        {
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande1).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 8%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';

			}
            // SI 2 AFFILIÉS QUI RECOMMANDENT
	        ELSE IF ( $nb_competence == 2)
	        {
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande1).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 4%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande2).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 12%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';
			}
            // SI 3 AFFILIÉS QUI RECOMMANDENT
	        ELSE IF ( $nb_competence > 2)
	        {
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande1).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 0%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande2).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 8%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';
              echo '<img src="'.DISPLAY_PROFILE_PICTURE_PARTENAIRE_COMPETENCE($id_affilie_qui_recommande3).'" style="position:absolute;z-index:3; width: 60px ; margin-left: 16%; border-radius: 50%; border-style: solid; border-color: #FFF; border-width:3px; margin-top:0px"; /> ';

			}

             
	 }
	 
     return array( $id_affilie_qui_recommande1, $id_affilie_qui_recommande2, $id_affilie_qui_recommande3 ); 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php  function DROPDOWN_NOTIFICATIONS_LIST($id_affiliate) 
{ 
     mysql_query('SET NAMES utf8');	
	 $result = mysql_query(" SELECT id_action_notification, category_message, message, page_link FROM action_notification WHERE id_affiliate = ".$id_affiliate."  AND notification_status = 1  ORDER BY id_action_notification desc  ") or die("Requete pas comprise - #AHCAAA30912! "); 		
	 echo'<ul class="dropdown-menu">';
	 while ($reponse = mysql_fetch_array($result))
             {
				    $category_message = $reponse['category_message']; 
				    $message          = $reponse['message'];					
				    $page_link        = $reponse['page_link'];					

                     echo'<li><a href="'.$page_link.'">';
                     echo'<span class="details">';
                     echo'<span class="label label-sm label-icon label-info"><i class="'.$category_message.'"></i></span>  '.$message.'  </span> ';
 					 echo'</a></li>';
	         }
	 echo'</ul>';

     return ("OK"); 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DROPDOWN_CALENDAR_NOTIFICATIONS_LIST($lien_webinar, $param2) 
{ 

	 echo'<ul class="dropdown-menu">';
	 
     //echo'<li><a href="'.$lien_webinar.'"  target="_blank" >';
     //echo'<span class="details">';
     //echo'<span class="label label-sm label-icon label-danger"> <i class="fa fa-bell"></i> </span> &nbsp  Webinar Lundi à 21h - <b>Cliquez ici</b></span>';
 	 //echo'</a></li>';
     //echo'<li><hr/></li>';
	
     mysql_query('SET NAMES utf8');	
	 $result = mysql_query(" SELECT planning_time, DATE_FORMAT(planning_time, '%Y-%m-%d') as planning_day, substring(planning_time,12,5) as planning_heure, 
			                 DATE_FORMAT(planning_time, '%w') as planning_jour_semaine, DATE_FORMAT(planning_time, '%m') as planning_mois_de_annee, 
							 DATE_FORMAT(planning_time, '%e') as jour_du_mois,  evenement, details, presentateur, endroit, endroit_complement, 
							 adresse, place_disponible, place_reservees
						     FROM planning_nr plnr 
						     where PLANNING_TIME > DATE_SUB( CURDATE(),  INTERVAL 0 DAY)   ORDER  by planning_time    ") or die("Requete pas comprise - #DROPDOWN_CALENDAR_NOTIFICATIONS_LIST "); 		

	 while ($reponse = mysql_fetch_array($result))
             { 
				    List($jour, $mois, $annee, $jour_de_la_semaine, $timestamp, $heure, $minute, $seconde, $mois_a_afficher, $mois_a_afficher2 ) = RETURN_INFO_SUR_LA_DATE($reponse['planning_time']) ; 
					//$message          = $reponse['evenement'].' le '.$reponse['jour_du_mois'].'/'.$reponse['planning_mois_de_annee'];					
					$message          = $reponse['evenement'].' - '.$jour_de_la_semaine.' '.$jour.' '.$mois_a_afficher2;
				    $page_link        = "Intranet_planning_nr.php";					

                     echo'<li><a href="'.$page_link.'">';
                     echo'<span class="details">';
                     echo'<span class="label label-sm label-icon label-info"> <i class="fa fa-bolt"></i></span>  '.$message.'  </span> ';
 					 echo'</a></li>';
	         }
	 echo'</ul>';

     return ("OK"); 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_RECOMMANDATION_COMPTABLE_PAYED($id_affiliate, $id_cles_unique, $montant_vdi, $montant_charges_patro , $montant_paiement_net, $aX_payed, $montant_tva_a_payer, $salaire_vdi_comptable ) 
{
	 // aX_payed  = 1 PAYED
	 //date_default_timezone_set('Europe/Paris');
	 mysql_query(" UPDATE recommandation_comptable 
	               SET aX_payed_date            =  CURRENT_TIMESTAMP, 
	                   charges_vdi              = '$montant_vdi',
	                   charges_patronales       = '$montant_charges_patro',
	                   amount_net_payed         = '$montant_paiement_net',
					   tva_entreprise_payer     = '$montant_tva_a_payer',
                       aX_payed                 = '$aX_payed'							 
				   WHERE aX_id_affiliate        = '$id_affiliate' 
				   AND   aX_ref                 = \"$id_cles_unique\"
                   AND   aX_payed               = 5	                                        ");            
   	return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_P_PRESENTATION($id_partner, $p_presentation) 
{
    $p_presentation = stripslashes($p_presentation);
	$p_presentation = addslashes($p_presentation);
	
	$sql = "UPDATE partner_list 
	             SET    p_presentation	= \"$p_presentation\" 						 
				 WHERE  id_partner      = '$id_partner'         "; //echo $sql;
	 mysql_query($sql);            
   	 return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_CV($id_ligne, $id_affiliate, $entreprise, $titre_job, $description_mission, $duree_mission, $submit_descendre) 
{
    $description_mission = stripslashes($description_mission);
	$description_mission = addslashes($description_mission);

    $entreprise = stripslashes($entreprise);
	$entreprise = addslashes($entreprise);

    $titre_job = stripslashes($titre_job);
	$titre_job = addslashes($titre_job);
	
    $duree_mission = stripslashes($duree_mission);
	$duree_mission = addslashes($duree_mission);
	
	IF ( $submit_descendre == 0 )
	{
	            $sql = "UPDATE affiliate_details_cv 
	                         SET    description_mission	= \"$description_mission\",
	            			        entreprise    	    = \"$entreprise\",
	            					titre_job    	    = \"$titre_job\",
	            					duree_mission    	= \"$duree_mission\",
                                    creation_date	    = CURRENT_TIMESTAMP			 
	            			 WHERE  id_ligne            = '$id_ligne'         ";
	             mysql_query($sql);  
	}	
    ELSE
    {
			    $result                = mysql_fetch_array(mysql_query("SELECT max(id_ligne)+1 as id_ligne FROM affiliate_details_cv")) or die("Requete pas affiliate_details_cv - #MAX! ");				
                $id_ligne_max           = $result['id_ligne'];	
				
	            $sql = "UPDATE affiliate_details_cv 
	                         SET    description_mission	= \"$description_mission\",
	            			        entreprise    	    = \"$entreprise\",
	            					titre_job    	    = \"$titre_job\",
	            					duree_mission    	= \"$duree_mission\",
									id_ligne    	    = \"$id_ligne_max\",
                                    creation_date	    = CURRENT_TIMESTAMP			 
	            			 WHERE  id_ligne            = '$id_ligne'         ";
	             mysql_query($sql);
	}
   	 return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_INTO_CV($id_affiliate, $entreprise, $titre_job, $description_mission, $duree_mission, $order_affichage) 
{
    $description_mission = stripslashes($description_mission);
	$description_mission = addslashes($description_mission);

    $entreprise = stripslashes($entreprise);
	$entreprise = addslashes($entreprise);

    $titre_job = stripslashes($titre_job);
	$titre_job = addslashes($titre_job);
	
    $duree_mission = stripslashes($duree_mission);
	$duree_mission = addslashes($duree_mission);
	
	$sql = 'INSERT into affiliate_details_cv(id_ligne, id_affiliate, creation_date, order_affichage, entreprise, titre_job, description_mission, duree_mission ) 
                                 VALUES(
								 "",
								 "'.$id_affiliate.'",
								 CURRENT_TIMESTAMP,
								 "'.$order_affichage.'",
								 "'.$entreprise.'",
								 "'.$titre_job.'",
                                 "'.$description_mission.'",
								 "'.$duree_mission.'" ) ';   //echo $sql;
	
	 mysql_query($sql);            
   	 return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DELETE_CV($id_ligne) 
{

		 $sql ='DELETE FROM affiliate_details_cv WHERE id_ligne='.$id_ligne.'    '; 	
         $result = mysql_query($sql) or die("Requete pas DELETE_CV #ZER345");
		  
		 return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function COUNT_PARTNER_LIST_COMPETENCER_IDS($id_partner_cible, $id_affilie_qui_recommande, $id_competence)
{ 
     $result            = mysql_fetch_array(mysql_query(" SELECT count(id_partner_cible) as  is_already_exist    
	                                                      FROM partner_list_competencer  
														  WHERE id_partner_cible           =".$id_partner_cible ." 
                                                          AND   id_affilie_qui_recommande  =".$id_affilie_qui_recommande ."   
                                                          AND   id_competence              =".$id_competence ."     ")) or die("Requete pas comprise - #COUNT_PARTNER_LIST_COMPETENCER_IDS! ");
     $is_already_exist = $result['is_already_exist'];	

     return ($is_already_exist); 
}
?>

<?php  function INSERT_INTO_PARTNER_LIST_COMPETENCER($is_activated, $id_partner_cible, $id_affilie_qui_recommande, $id_competence, $commentaires) 
{
    $commentaires = stripslashes($commentaires);
	$commentaires = addslashes($commentaires);
	
	$sql = 'INSERT into partner_list_competencer(id_ligne, is_activated, id_partner_cible, id_affilie_qui_recommande, id_competence, commentaires, date_creation ) 
                                 VALUES(
								 "",
								 "'.$is_activated.'",
								 "'.$id_partner_cible.'",
								 "'.$id_affilie_qui_recommande.'",
								 "'.$id_competence.'",
								 "'.$commentaires.'",
								 CURRENT_TIMESTAMP ) ';   //echo $sql;
	
	 mysql_query($sql);            
   	 return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function ID_AFFILIATE_IS_ASSOCIATION($id_affilie) 
{
				$req3             = mysql_query(' SELECT count(*)as is_exist, afd.numero_de_pack
				                                  FROM affiliate_details afd
											      WHERE afd.id_affiliate = "'.$id_affilie.'"  ') or die("Module de sécurité activé. Accès bloqué ID_AFFILIATE_IS_ASSOCIATION. #3987");
		        $dn3              = mysql_fetch_array($req3);
				
				$numero_de_pack = $dn3['numero_de_pack'];
				
                return ( $numero_de_pack );
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function ID_PARTENAIRE_REMPLACANT_VACANCES($connection_database2, $id_service, $id_partner ) 
{
	$the_same_partner = 1;
	$id_partner       = str_replace(";", "", $id_partner);
	IF ( $id_service == 1 AND IS_num($id_partner) > 0) // ON CHERCHE UN REMPLAÇANT UNIQUEMENT SI IMMOBILIER
	{
		        
				$sql = " SELECT count(pl.id_partner) as is_exist, piad.email_remplacant, piad.id_part_nr_replacant 
		                                FROM   partner_list pl, partner_iad piad
		                                WHERE  pl.id_services            = 1
										AND    pl.id_partner             = $id_partner 
								        AND    piad.id_part_nr_replacant > 0
                                        AND    pl.date_debut_conges      > 0
								        AND    trim(piad.iad_email)      = trim(pl.p_contact_mail) 
								        AND    pl.is_activated           = 1           ";
				
				$result = mysql_query($sql)  or die(" Requete : #ID_PARTENAIRE_REMPLACANT VACANCES pas comprise. $sql ");	
		        $dn3              = mysql_fetch_array($result);
				
				IF ( $dn3['is_exist'] > 0 )      
				    {  
				         IF ( $dn3['id_part_nr_replacant'] <> $id_partner )         
						    {  
						         $the_same_partner = 0; 
							}
					     IF ( RETURN_ID_PARTNER_ACTIF($connection_database2, $dn3['email_remplacant'] ) > 0 ) 
							{
				                 $id_partner = $dn3['id_part_nr_replacant'];  
                            }						 
				    }
	}
    
	return array( $id_partner, $the_same_partner  );		
				
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function RETURN_RESULT_RECHERCHE_PARTENAIRE($connection_database2, $id_partner, $id_service, $service_de_l_affilie ) 
{
	         $filtre_requete_pour_renvoyer_rien = " ";
			 IF ( $service_de_l_affilie == 1 AND $id_service == 50 ) // JE SUIS AGENT IMMOBILIER ET JE SOUHAITE FAIRE UNE RECO RECHERCHE
			                                                         // JE FAIS UNE RÈGLE POUR ACCEPTER LE FAIT QUE CELA NE ME PROPOSE PAS FORCEMENT MON PARRAIN
			 {
                 $filtre_requete_pour_renvoyer_rien = "AND 1 = 2";
             }		 
			    
				
				$sql_2    = " SELECT pl.id_partner, CONCAT( p_last_name, ' ', p_first_name) AS p_contact, p_secteur, p_lat, p_long, p_rayon, p_rayon_level1, p_zip_code, p_city  
							  FROM partner_list pl, partner_list_services pls
							  WHERE pl.is_activated = 1
							  AND   pl.id_partner   = ".$id_partner." 
                              AND   pls.id_service  = ".$id_service."  
                              AND   pl.id_partner   = pls.id_partner  $filtre_requete_pour_renvoyer_rien ";
											   
				$result_2 = mysql_query($sql_2) or die("Requete pas comprise : Choix du partenaire exclusif #RETURN RESULT_RECHERCHE_PARTENAIRE! ");
				$row2     = mysql_fetch_array($result_2);
				$temp     = "";
				
                return array ( $result_2, $row2 , $temp );
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function RETURN_PARTENAIRE_PLUS_PROCHE_IAD($connection_database2, $id_upline) 
{
     // 1. CHECK LE PARRAIN LE PLUS PROCHE QUI EST CHEZ IAD FRANCE
	 $niveau_de_profondeur     = 0;
	 $id_partenaire_du_parrain = 0;
	 
	 WHILE ( $id_partenaire_du_parrain <=0 AND $niveau_de_profondeur < 8 )
        {
		 $niveau_de_profondeur = $niveau_de_profondeur + 1;
		 List( $id_partenaire_du_parrain, $service_du_parrain, $id_affiliate_parrain, $partenaire_nom) = PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $id_upline , $niveau_de_profondeur, 1 );		
                 IF ( $service_du_parrain <> 1 ) // ON CONTINU A CHERCHER CAR LE PARRAIN N'EST PAS CHEZ IAD FRANCE
		         {
		  	       $id_partenaire_du_parrain = 0;
		         }
		}
	 
    return array( $id_partenaire_du_parrain, $service_du_parrain, $id_affiliate_parrain, $partenaire_nom );	  
	 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $id_upline, $niveau_upline, $is_manager_iad ) 
{
            // CE CHAMPS $is_manager_iad sert à savoir si le manager est habilité à recruter un filleul

		    mysql_query('SET NAMES utf8');
            IF ( $niveau_upline == 1 ) ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl
											      WHERE aa.id_partenaire = pl.id_partner 
												  AND   pl.is_activated = 1
												  AND   aa.is_activated = 1
											      AND   aa.id_affiliate = $id_upline  ") or die("Module de sécurité activé. Accès bloqué temporairement. #3987");
		        $dn3              = mysql_fetch_array($req3);
				
                IF ( ID_AFFILIATE_IS_ASSOCIATION( $id_upline ) == 1 AND $dn3['id_partenaire'] == 0 ) // C'EST UNE ASSOCIATION DONC ON MONTE D'UN CRAN CAR N'EXISTE PAS
				     { 			
					     $niveau_upline = 2; 
                     }				 
			}
            
			IF ( $niveau_upline == 2 ) ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services , aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1 
												  AND   aa.is_activated = 1
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																	   	    WHERE bb.id_affiliate = $id_upline 
																			AND bb.is_activated = 1 )     ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDF56");
		        $dn3              = mysql_fetch_array($req3); 
                IF ( ID_AFFILIATE_IS_ASSOCIATION( return_id_parrain($id_upline) ) == 1 ) // C'EST UNE ASSOCIATION DONC ON MONTE D'UN CRAN CAR N'EXISTE PAS
				     { 			
					     $niveau_upline = 3; 
                     }	
			}
            
			IF ( $niveau_upline == 3 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE  cc.is_activated = 1 
																									   AND cc.id_affiliate = $id_upline ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}


			IF ( $niveau_upline == 4 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = $id_upline  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}

			IF ( $niveau_upline == 5 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                               WHERE cc.is_activated = 1 
																									                                                   AND cc.id_affiliate = $id_upline  
																															                          )   
																															  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}

			IF ( $niveau_upline == 6 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                               WHERE cc.is_activated = 1 
																									                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                       WHERE cc.is_activated = 1 
																									                                                                           AND cc.id_affiliate = $id_upline  
																															                                                   )   
																															                          )   
																															  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}	

			IF ( $niveau_upline == 7 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                               WHERE cc.is_activated = 1 
																									                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                       WHERE cc.is_activated = 1 
																									                                                                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                               WHERE cc.is_activated = 1 
																									                                                                                                   AND cc.id_affiliate = $id_upline  
																															                                                                           )   
																															                                                   )   
																															                          )   
																															  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}	

			IF ( $niveau_upline == 8 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                               WHERE cc.is_activated = 1 
																									                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                       WHERE cc.is_activated = 1 
																									                                                                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                               WHERE cc.is_activated = 1 
																									                                                                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                                                       WHERE cc.is_activated = 1 
																									                                                                                                                           AND cc.id_affiliate = $id_upline  
																															                                                                                                   )    
																															                                                                           )   
																															                                                   )   
																															                          )   
																															  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}			

			IF ( $niveau_upline == 9 ) //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			{				
				$req3             = mysql_query(" SELECT count(*)as is_service_actif, aa.id_partenaire, pl.id_services, aa.id_affiliate, CONCAT( p_last_name, ' ', p_first_name) AS p_contact
				                                  FROM affiliate aa, partner_list pl 
											      WHERE aa.id_partenaire = pl.id_partner												  
											      AND   pl.is_activated = 1
                                                  AND   aa.is_activated = 1												  
											      AND   aa.id_affiliate = ( SELECT bb.ID_UPLINE FROM affiliate bb 
																		    WHERE bb.id_affiliate =  ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                               WHERE cc.is_activated = 1 
																									   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                       WHERE cc.is_activated = 1 
																									                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                               WHERE cc.is_activated = 1 
																									                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                       WHERE cc.is_activated = 1 
																									                                                                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                               WHERE cc.is_activated = 1 
																									                                                                                                   AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                                                       WHERE cc.is_activated = 1 
																									                                                                                                                           AND cc.id_affiliate = ( SELECT cc.ID_UPLINE FROM affiliate cc 
																		                                                                                                                                                                               WHERE cc.is_activated = 1 
																									                                                                                                                                                   AND cc.id_affiliate = $id_upline  
																															                                                                                                                           )   
																															                                                                                                   )    
																															                                                                           )   
																															                                                   )   
																															                          )   
																															  ) 
																									  ) 
																		 )   ") or die("Module de sécurité activé. Accès bloqué temporairement. #FSDFTR56");
		        $dn3              = mysql_fetch_array($req3); 
				
			}
			
				$is_service_actif      = $dn3['is_service_actif']; 
				$id_partenaire_parrain = $dn3['id_partenaire'];
                $id_service_du_parrain = $dn3['id_services'];
				$id_affiliate_parrain  = $dn3['id_affiliate'];
				$partenaire_nom        = $dn3['p_contact']." - Upline de Niveau ".$niveau_upline ;

                If ( $is_service_actif == 0) 
                {
				$id_partenaire_parrain = 0;
                $id_service_du_parrain = 0;					
				}					

         return array( $id_partenaire_parrain, $id_service_du_parrain , $id_affiliate_parrain, $partenaire_nom  );			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} 
?>

<?php  function RETURN_SESSION_FROM_ID_AFFILIATE($connection_database2, $id_affiliate) 
{ // USED ONLY BY APPS MOBILE

		 $parrain_is_iad       = 0; 
		 $id_parrain_is_iad    = 0;
		 $parrain_2_is_iad     = 0;
		 $id_parrain_2_is_iad  = 0;
		 $service_de_l_affilie = 0;
		 mysql_query('SET CHARACTER SET utf8');
		 
		 //// 1. DÉFINIR LES INFORMATIONS DE BASES DE L'AFFILIÉ /////////////////////////////////////////////////////////////////////////////////////////////////////////
				 $req     = mysql_query(' SELECT ad.id_affiliate, aa.password, ad.first_name, ad.last_name, ad.email, aa.id_partenaire, aa.id_upline, ad.phone_number, ad.address, ad.zip_code, ad.city, ad.birth_date, ad.birth_place, ad.nationality, ad.id_securite_sociale, ad.logement_affiliate, ad.statut_logement, 	numero_de_pack  
				                          FROM   affiliate_details ad, affiliate aa 
										  WHERE  ad.id_affiliate = aa.id_affiliate 
										  AND    aa.is_activated = 1 
										  AND    (ad.id_affiliate ="'.$id_affiliate.'"  OR trim(ad.email) = \''.trim($id_affiliate).'\' )  limit 0,1   ');
		         $dn      = mysql_fetch_array($req);
				 $numero_de_pack = $dn['numero_de_pack'];
                 $photo_profil = DISPLAY_PROFILE_PICTURE_AFFILIE_MOBILE( $dn['id_affiliate'] , $dn['id_partenaire'] , 0);				 

		 //// 2. L'AFFILIÉ EST AUSSI UN PARTENAIRE ? ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 $id_partenaire_is_iad  = 0; 
		         IF ($dn['id_partenaire'] > 0)    
		             { 
                         $req2 = mysql_query(' SELECT count(id_services) as row_exist, id_services  
		  	      	                           FROM  partner_list 
		  	      						       WHERE id_partner = "'.$dn['id_partenaire'].'" 
		  	      						       AND   is_access_intranet = 1
                                               AND   is_activated       = 1 	         ');
                         $dn2  = mysql_fetch_array($req2);
						 $service_de_l_affilie = $dn2['id_services'];
						 IF      ( $dn2['row_exist'] == 0 )                                                                        {   $dn['id_partenaire']   = 0; } 
		  	      	     ELSE IF ( $dn2['row_exist'] > 0 AND ( $dn2['id_services'] == 1 OR $dn2['id_services'] == 50 ) )           {   $id_partenaire_is_iad  = 1; } 
		             }

         //// 3. AJOUTER DES PARAMÊTRES DE SESSION CONCERNANT LES PARRAINS	/////////////////////////////////////////////////////////////////////////////////////////////
		             // 3.1 ÉTUDE DU PARRAIN DE NIVEAU 1                    /////////////////////////////////////////////////////////////////////////////////////////////
					 List( $id_partenaire_du_parrain_1, $service_du_parrain_1 ) = PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $dn['id_upline'], 1, 0 ); 
					 List( $id_partenaire_du_parrain_2, $service_du_parrain_2 ) = PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $dn['id_upline'], 2, 0 );
		             
					 IF ( $service_du_parrain_1 == 1 OR $service_du_parrain_1 == 50 )
		                {
		                  $parrain_is_iad    = $service_du_parrain_1;
		            	  $id_parrain_is_iad = $id_partenaire_du_parrain_1;
		            	}		 
					 
					 IF ( $parrain_is_iad == 0) // LE PARRAIN NIVEAU 1 N'EST PAS CHEZ IAD, VÉRIFIONS SI LE PARRAIN N2 EST CHEZ IAD ?
					     {   
							         IF ( $service_du_parrain_2 == 1 OR $service_du_parrain_2 == 50 )
					                    {
					                      $parrain_2_is_iad    = $service_du_parrain_2;
					                 	  $id_parrain_2_is_iad = $id_partenaire_du_parrain_2;
					                 	}
						 }

		return array( $dn['first_name'], $dn['id_affiliate'], $dn['id_partenaire'], $dn['email'], $dn['id_upline'], $id_partenaire_is_iad,  "MOBILE", $parrain_is_iad, $id_parrain_is_iad, $id_parrain_2_is_iad, $dn['last_name'], $dn['phone_number'], $dn['address'], $dn['zip_code'], $dn['city'], $dn['birth_date'], $dn['birth_place'], $dn['nationality'], $dn['id_securite_sociale'], $dn['logement_affiliate'], $dn['statut_logement'], $photo_profil, $id_partenaire_du_parrain_1, $service_du_parrain_1, $parrain_2_is_iad, $id_partenaire_du_parrain_2, $service_du_parrain_2, $numero_de_pack, $service_de_l_affilie   );

}
?>


<?php  function GESTION_PARAMETRES_SESSION($connection_database2, $first_name, $id_affiliate, $id_partenaire, $email, $id_upline, $param1, $param2, $param3, $provenance)
{ //////////////////////// MODULE IMPORTANT DE GESTION DES SESSIONS 
			    $_SESSION['first_name']                                = utf8_encode($first_name);       // STOCKAGE DE LA VARIABLE : PRÉNOM  
			    $_SESSION['id_affiliate']                              = $id_affiliate ;                 // STOCKAGE DE LA VARIABLE : ID_AFFILIATE  
			    $_SESSION['email_affiliate']                           = trim($email);                   // STOCKAGE DE LA VARIABLE : MAIL AFFILIATE
			    $_SESSION['id_partenaire']                             = $id_partenaire;                 // STOCKAGE DE LA VARIABLE : ID_PARTENAIRE : SOUVENT VIDE
			    $_SESSION['id_partenaire_is_iad']                      = 0;                              // STOCKAGE DE LA VARIABLE : ID_PARTENAIRE SI PARTENAIRE IS IAD (FRANCE OU PORTUGAL)
			    $_SESSION['id_part_is_iad_FRANCE']                     = 0;                              // STOCKAGE DE LA VARIABLE : ID_PARTENAIRE SI PARTENAIRE IS IAD FRANCE
			    $_SESSION['id_part_is_iad_PORTUGAL']                   = 0;                              // STOCKAGE DE LA VARIABLE : ID_PARTENAIRE SI PARTENAIRE IS IAD PORTUGAL
				$_SESSION['id_upline']                                 = $id_upline;                     // STOCKAGE DE LA VARIABLE : ID_PARRAIN 
				$_SESSION['display_docs_part']                         = 0;                              // STOCKAGE DE LA VARIABLE : DISPLAY_DOCS_PART   
			    $_SESSION['parrain_is_iad']                            = 0;                              // STOCKAGE POUR SAVOIR SI PARRAIN IS_IAD
			    $_SESSION['id_parrain_is_iad']                         = 0;                              // STOCKAGE POUR CONNAÎTRE ID_PARRAIN QUI EST CHEZ IAD
			    $_SESSION['parrain_2_is_iad']                          = 0;                              // STOCKAGE POUR SAVOIR SI LE PARRAIN DU PARRAIN IS_IAD
			    $_SESSION['id_parrain_2_is_iad']                       = 0;                              // STOCKAGE POUR CONNAITRE ID_PARRAIN DU PARRAIN QUI EST CHEZ IAD
			    $_SESSION['parrain_is_association']                    = 0;                              // STOCKAGE POUR CONNAITRE SI PARRAIN EST ASSOCIATION				 
				$_SESSION['service_de_l_affilie']                      = 0;                              // STOCKAGE POUR CONNAITRE LE SERVICE DE L'AFFILIÉ
				$_SESSION['service_du_parrain_1']                      = 0;                              // STOCKAGE POUR CONNAITRE LE SERVICE DU PARRAIN			 
			    $_SESSION['id_partenaire_du_parrain_1']                = 0;                              // STOCKAGE POUR CONNAITRE L'ID DU PARTENAIRE QUI EST PARRAIN				
			    $_SESSION['service_du_parrain_2']                      = 0;                              // STOCKAGE POUR CONNAITRE LE SERVICE DU PARRAIN 2		 
			    $_SESSION['id_partenaire_du_parrain_2']                = 0;                              // STOCKAGE POUR CONNAITRE L'ID DU PARTENAIRE QUI EST PARRAIN 2
				
				
				UPDATE_LAST_CONNECTION_DATE_AFFILIE($id_affiliate);                                      // MISE À JOUR DU TIMESTAMP DE CONNECTION
	            
			             IF ($_SESSION['id_upline'] > 0)        { //////////////////////////////// ALLONS DÉFINIR SI LE PARRAIN EST CHEZ IAD
																 List( $_SESSION['id_partenaire_du_parrain_1'], $_SESSION['service_du_parrain_1'] ) = PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $id_upline, 1, 0 ); 
																
																 IF ( $_SESSION['service_du_parrain_1'] == 1 OR $_SESSION['service_du_parrain_1'] == 50 )
																    {
																      $_SESSION['parrain_is_iad']    = $_SESSION['service_du_parrain_1'];
																	  $_SESSION['id_parrain_is_iad'] = $_SESSION['id_partenaire_du_parrain_1'];
																	}
																
																 IF ( $_SESSION['parrain_is_iad'] == 0) // LE PARRAIN NIVEAU 1 N'EST PAS CHEZ IAD, VÉRIFIONS SI LE PARRAIN N2 EST CHEZ IAD ?
																     {   
						 	                                             
                                                                         List( $_SESSION['id_partenaire_du_parrain_2'], $_SESSION['service_du_parrain_2'] ) = PARRAIN_CATEGORIE_ID_SERVICE_NIVEAU_PARRAIN($connection_database2, $id_upline, 2, 0 ); 
																         
																		 IF ( $_SESSION['service_du_parrain_2'] == 1 OR $_SESSION['service_du_parrain_2'] == 50 )
																            {
																              $_SESSION['parrain_2_is_iad']    = $_SESSION['service_du_parrain_2'];
																         	  $_SESSION['id_parrain_2_is_iad'] = $_SESSION['id_partenaire_du_parrain_2'];
																         	}
																	 }	
                                                                 
																 // ALLONS DÉFINIR SI LE PARRAIN EST UNE ASSOCIATION
                                                                 $req_4            = mysql_query(' SELECT count(*)as IS_ASSO, ad.numero_de_pack
						                                                                           FROM   affiliate aa, affiliate_details ad 
						                                                                           WHERE  aa.id_affiliate   = ad.id_affiliate 
						                                                                           AND    aa.id_affiliate   = "'.$id_upline.'"
                                                                                                   AND 	  ad.numero_de_pack = 1  ') or die("Module de sécurité activé. Accès bloqué temporairment.");

	                                                             $dn4              = mysql_fetch_array($req_4); 
																 $_SESSION['parrain_is_association']        = $dn4['numero_de_pack'];
																  
														        } 
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////								  
                         IF ($_SESSION['id_partenaire'] > 0 AND $_SESSION['id_affiliate'] > 10)    { 
						                                         // 1. UN PARTENAIRE EST DÉFINI - ALLONS DÉFINIR SON SERVICE AFIN DE FILTRER L'AFFICHAGE
						 	                                      $req2 = mysql_query(' SELECT count(id_services) as row_exist, id_services, p_contact_mail, p_contry , is_activated , qcm_iad
																                        FROM   partner_list 
																						WHERE  id_partner = "'.$_SESSION['id_partenaire'].'" 
																						AND    is_access_intranet = 1 ');
		                                                          $dn2  = mysql_fetch_array($req2);
																  IF ($dn2['row_exist'] == 0) // UN PARTENAIRE PEUT ETRE DEFINI MAIS INTERDIT D'ACCEDER A L'INTRANET
																     {   $_SESSION['display_docs_part']  = 0;
																	     $_SESSION['statut']             = "AFFILIE";
																		 
																		 IF     ( $provenance == "MOBILE") { return 100; }
                                                                         ELSE   { echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; }
																		 
																	 }
																  ELSE
                                                                     {   $_SESSION['display_docs_part']    = display_documents_partenaires( $dn2['id_services'] );
						                                                 $_SESSION['statut']               = "AFFILIE_ET_PARTENAIRE";
																		 $_SESSION['service_de_l_affilie'] = $dn2['id_services'];

                                                                          // ALLONS DÉFINIR SI LE PARTENAIRE EST CHEZ IAD POUR AFFICHAGE SPÉCIFIQUE DES FILTRES
                                                                         IF ( $dn2['id_services'] == 1 )                                                       { $_SESSION['id_partenaire_is_iad']     = 1; }
						 	                                             IF ( $dn2['id_services'] == 1 AND strstr($dn2['p_contact_mail'], "@iadfrance")    )   { $_SESSION['id_part_is_iad_FRANCE']    = 1; }
																		 IF ( $dn2['id_services'] == 1 AND strstr($dn2['p_contact_mail'], "@iadportugal")  )   { $_SESSION['id_part_is_iad_PORTUGAL']  = 1; }
																		 
																		 // ALLONS DÉFINIR LA PAGE A AFFICHER : SI RECO EN COURS ALORS ON AFFICHE LA PAGE PARTENAIRE
																         IF (COUNT_PRESCRIPTION_POUR_PARTENAIRE( $id_partenaire ) > 0 ) 
																		     { 
																		             IF    ( $provenance == "MOBILE") { return 100; }
                                                                                     ELSE  { 	echo '<meta http-equiv="refresh" content="0;URL=../Intranet_partenaire_2.php">'; }
																			 }
																		 ELSE
                                                                             { 
																		              IF     ( $provenance == "MOBILE") { return 100; }
                                                                                      ELSE  IF ( $_SESSION['id_part_is_iad_FRANCE'] == 1 AND $dn2['is_activated'] == 3 AND $dn2['qcm_iad'] == 0) // QCM NON VALIDÉ
																						     { echo '<meta http-equiv="refresh" content="0;URL=../Intranet_qcm_IAD.php">'; }
																					  ELSE   { echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; }
																		     }																		 

																	 }
																}										  
			             ELSE    IF ($id_affiliate >=11)        {
  	                      						                     $_SESSION['statut'] = "AFFILIE";
																	 IF     ( $provenance == "MOBILE") { return 100; }
                                                                     ELSE   { echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; }
						 
						                                        }			 
			             ELSE                                   { 
               														 IF     ( $provenance == "MOBILE") 
																	        { return 100; }
                                                                     ELSE IF ($id_affiliate ==9) { $_SESSION['statut'] = "COMPTABLE";  echo '<meta http-equiv="refresh" content="0;URL=../NosRezo12345678911_6.php">'; }
																	 ELSE                        { $_SESSION['statut'] = "A.D.M.I.N";  echo '<meta http-equiv="refresh" content="0;URL=../NosRezo12345678912.php">'; }
																}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function DISPLAY_SESSION_VALUE($param) 
{
     echo "<br/>- first_name : ".$_SESSION['first_name'] ;                             	
     echo "<br/>- id_affiliate : ".$_SESSION['id_affiliate']    ;                        
     echo "<br/>- email_affiliate : ".$_SESSION['email_affiliate']  ;                       
	 echo "<br/>- id_partenaire : ".$_SESSION['id_partenaire']     ;                      
	 echo "<br/>- id_partenaire_is_iad : ".$_SESSION['id_partenaire_is_iad'] ;                   			
     echo "<br/>- id_upline : ".$_SESSION['id_upline']                     ;          
     echo "<br/>- display_docs_part: ".$_SESSION['display_docs_part']      ;                 
     echo "<br/>- parrain_is_iad : ".$_SESSION['parrain_is_iad']            ;              
     echo "<br/>- id_parrain_is_iad : ".$_SESSION['id_parrain_is_iad']       ;                
     echo "<br/>- parrain_2_is_iad : ".$_SESSION['parrain_2_is_iad']          ;              
     echo "<br/>- id_parrain_2_is_iad : ".$_SESSION['id_parrain_2_is_iad']     ;                
     echo "<br/>- parrain_is_association : ".$_SESSION['parrain_is_association'];                      
     echo "<br/>- service_du_parrain : ".$_SESSION['service_du_parrain_1'] ;                 
     echo "<br/>- id_partenaire_du_parrain : ".$_SESSION['id_partenaire_du_parrain_1']        ;       
     echo "<br/>- service_du_parrain_2 : ".$_SESSION['service_du_parrain_2'] ;                 
     echo "<br/>- id_partenaire_du_parrain_2 : ".$_SESSION['id_partenaire_du_parrain_2']        ; 							
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php  function DISPLAY_INSTEADOF_ZERO($valeur)
{ 
     IF    ($valeur > 0)  { return ($valeur." €");   }
	 ELSE                 { return (" - ");     } 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function DISPLAY_INSTEADOF_ZERO_PLUS($valeur, $affiche_euro)
{ 
     IF    ($valeur == 0)   { return (" - ");     } 
	 ELSE     {  
	        IF ( $affiche_euro == 1) { $valeur_a_afficher = number_format( trim($valeur) , 0, ',', ' ') ." €"; }  
	        ELSE                     { $valeur_a_afficher = number_format( trim($valeur) , 0, ',', ' ') ;   }
		      }
	    
        return ($valeur_a_afficher);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function S_SUB_CATEGORY_FROM_S_SUB_CATEGORY_CODE($s_sub_category_code) 
{
                mysql_query('SET NAMES utf8');				
			    $result                 = mysql_fetch_array(mysql_query("SELECT s_sub_category FROM services WHERE id_services =".$s_sub_category_code." limit 0,1")) or die("Requete pas comprise - Insert Recommandation zsmp");
                $s_sub_category         = $result['s_sub_category'];				
				return ($s_sub_category);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


<?php  function INSERT_INTO_PARTNER_NOTATION( $id_partner, $nb_reco, $percent_satisfaction, $id_image, $points_nosrezo) 
{
	
	$sql    = " SELECT  count(id_partner_notation) as id_partner
	            FROM    partner_notation 
	            WHERE   id_partner_notation       = ".$id_partner."  					";
										
    $result = mysql_fetch_array(mysql_query($sql)) or die("Requete update_partner_notation : #AZED433 pas comprise. ");
	
    IF ( $result['id_partner'] == 0 )
	{		

				$sql = 'INSERT into partner_notation(id_partner_notation, nb_interventions, percent_satisfaction, Total_points_algo , points_nosrezo, id_image, update_time) 
                                 VALUES(
								 "'.$id_partner.'",
								 "'.$nb_reco.'",
								 "'.$percent_satisfaction.'",
                                 "'.$points_nosrezo.'",
								 "'.$points_nosrezo.'",								 
								 "'.$id_image.'", 
								 CURRENT_TIMESTAMP) ';  //echo $sql;
                mysql_query($sql) or die("Requete update_partner_notation : #AZED44 pas comprise. ");	

	}				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function INSERT_INTO_CP_AUTOCOMPLETE($VILLE, $CP, $COUNTRY, $LATITUDE, $LONGITUDE) 
{
	
			    $VILLE = stripslashes($VILLE);
				$VILLE = addslashes($VILLE);  

			    $COUNTRY = stripslashes($COUNTRY);
				$COUNTRY = addslashes($COUNTRY);  				
	
				$sql = 'INSERT into cp_autocomplete(ligne, VILLE, CP, country, LATITUDE, LONGITUDE) 
                                 VALUES(
								 "",
								 "'.$VILLE.'",
								 "'.$CP.'",
								 "'.$COUNTRY.'",
								 "'.$LATITUDE.'",
                                 "'.$LONGITUDE.'"   ) ';
                mysql_query($sql) or die("Requete cp_autocomplete : #AAAACED44 pas comprise. ");			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>



<?php  function RETURN_PAYS_AFFILIATE( $id_affiliate ) 
{		
	// 1. LANCEMENT DE LA REQUETE
	$result = mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as count_id, id_affiliate, affiliate_latitude, affiliate_longitude 
	                                          FROM   affiliate_details 
											  WHERE  id_affiliate = $id_affiliate    ")) or die("Requete pas comprise - #RETURN_PAYS_AFFILIATE! ");
    
	// 2. DETERMINONS LE PAYS DE L'AFFILIÉ 	
        IF ( $result['affiliate_latitude']  <= 42 ) 
		     { 
		         $country = "PORTUGAL"; 
			     $is_protected_pays = 1;
                 $minimum_ca_pour_encaisser = 50;				 
			 }
        ELSE     	
		     { 
		         $country = "FRANCE"; 
			     $is_protected_pays = 0;
                 $minimum_ca_pour_encaisser = 200;				 
			 }
		
	 return array( $country, $is_protected_pays, $minimum_ca_pour_encaisser);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function ID_PARTNER_MAX_FROM_PARTNER_LIST($param1) 
{
				$result                = mysql_fetch_array(mysql_query("SELECT max(id_partner)+1 as id_partner FROM partner_list")) or die("Requete pas comprise - #MAX! ");				
                $id_part_max           = $result['id_partner'];				
				return ($id_part_max);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function GEO_LOCALISATION_ADRESSE($cp, $ville, $adresse, $source, $country) 
{		
         $latitude_secteur        = 0;
		 $longitude_secteur       = 0;
		 $la_ville_existe_en_base = 0;
		 
		 $cp       = trim($cp);
		 $ville    = trim($ville);
		 $adresse  = trim($adresse);
		 
		 IF (trim($cp) <> "" )        
		     {	 $sql           = " SELECT count(VILLE) as row_exist, VILLE, CP, LATITUDE, LONGITUDE 
			                        FROM cp_autocomplete 
									WHERE trim(CP)    = ".$cp." 
									AND trim(VILLE)  like  \"$ville\" 
									Limit 0,1   ";
                 $result_cp     = mysql_fetch_array(mysql_query($sql));
				 
				 IF ($result_cp['row_exist'] == 0) // PAS DE MATCHING ALORS ON LANCE GOOGLE API        
				        {			           						   
						   $address   = $cp." ".$ville." ".$country." ";
					       IF ($source == "CRON") // PAS D'APPEL API EXTERNE CAR ERREUR
						     { 
							     //mail('benjamin.allais@gmail.com','CP VILLE INEXISTANTE', $address." - - - ".$sql  ); 
							 }
							ELSE
							 {
						         List ($latitude_secteur, $longitude_secteur) = getXmlCoordsFromAdress($address);	// APPEL LIMITÉ À L'API POUR PERFORMANCE ET LIMITATION GOOGLE	
                                 
								 //AJOUTER UN MODULE POUR INSERTION AUTOMATIQUE
						         //IF ($latitude_secteur > 0)  { insert_into_cp_autocomplete($VILLE, $CP, $latitude_secteur, $longitude_secteur); }						
                             }
						}
				 ELSE   {  
				           $latitude_secteur        = $result_cp['LATITUDE'];	
                           $longitude_secteur       = $result_cp['LONGITUDE'];
						   $la_ville_existe_en_base = 1; //LA LIGNE EXISTE DEJA
						}				 
             }
                settype($latitude_secteur,  "float");  
		        settype($longitude_secteur, "float"); 
				
	 return array($latitude_secteur, $longitude_secteur, $la_ville_existe_en_base );
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>

<?php  function INSERT_INTO_PARTNER_LIST_MASTER($connection_database, $gender, $id_partner_max, $p_category, $s_sub_category, $s_sub_category_code, $nom_entreprise, $first_name, $last_name, $mobile, $email, $site_web, $p_adresse, $cp, $ville, $latitude, $longitude, $p_rayon, $p_rayon_level1, $p_secteur, $fonction, $is_activated, $com_nr_contrat_percent, $recommanded_by, $why_recommand, $cp_secteur, $ville_secteur, $date_naissance, $lieu_naissance, $id_securite_sociale, $is_access_intranet, $source_script, $serveur, $pays_partenaire)  
{
	     //////////////////////////////////////////////// GÉOLOCALISATION DU PARTENAIRE AVANT INSERTION DANS LA BASE	 
                List ($latitude_secteur, $longitude_secteur) = GEO_LOCALISATION_ADRESSE($cp_secteur, $ville_secteur, $p_adresse, $source_script, $pays_partenaire); 
				
		 //////////////////////////////////////////////////////////////////////////////////////////////////////////////	
                $sql = 'insert into partner_list(id_partner, p_category, p_sub_category, id_services, p_company, p_first_name, p_last_name, p_contact_phone, p_contact_mail, site_web, p_adresse, p_zip_code, p_city, p_lat, p_long, p_rayon, p_rayon_level1, p_secteur, p_fonction, is_activated, is_access_intranet, com_nr_contrat_percent, recommanded_by, why_recommand, p_creation_date) 
				                             VALUES (
											 "'.$id_partner_max.'", 
											 "'.$p_category.'", 
											 "'.$s_sub_category.'",
											 "'.$s_sub_category_code.'",
											 "'.$nom_entreprise.'",
											 "'.$first_name.'",
											 "'.$last_name.'",
											 "'.$mobile.'",	
											 "'.$email.'",
											 "'.$site_web.'",
											 "'.$p_adresse.'",
											 "'.$cp_secteur.'",
											 "'.$ville_secteur.'",
											 "'.$latitude_secteur.'",
											 "'.$longitude_secteur.'",
											 "'.$p_rayon.'",
											 "'.$p_rayon_level1.'",
											 "-",
											 "'.$fonction.'",
											 "'.$is_activated.'", 
											 "'.$is_access_intranet.'", 
											 "'.$com_nr_contrat_percent.'", 											 
											 "'.$recommanded_by.'", 
											 "'.$why_recommand.'",
											 CURRENT_TIMESTAMP)';
		         mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise insert_into_partner_list - function.php ");

  				///////////////////// INSERTION DANS LA TABLE DES AUTRES SERVICES PARTENAIRES POUR LE MULTI-SERVICES
				         INSERT_INTO_PARTNER_LIST_SERVICES($id_partner_max, $s_sub_category_code);
						 IF ( $s_sub_category_code == 1 )      { INSERT_INTO_PARTNER_LIST_SERVICES($id_partner_max, 50); } // ON AJOUTE LE SERVICE RECHERCHE DE BIEN IMMOBILIER
						 IF ( $s_sub_category_code == 34 )     { INSERT_INTO_PARTNER_LIST_SERVICES($id_partner_max, 37); } 
						 IF ( $s_sub_category_code == 37 )     { INSERT_INTO_PARTNER_LIST_SERVICES($id_partner_max, 34); }
						 
  				///////////////////// INSERTION DANS LA TABLE DES NOTATIONS DES PARTENAIRES POUR LE CALCUL DU CLASSEMENT
				         INSERT_INTO_PARTNER_NOTATION( $id_partner_max, 0, 100, 5, 30 );

				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				/////////////////////  MODULE D'INSERTION DE L'AFFILIÉ CORRESPONDANT AU PARTENAIRE
						 List ($affiliate_already_exist, $id_partenaire, $id_upline, $email_p, $first_name_p, $last_name_p ) = CHECK_IF_FULL_NOSREZO_EXIST($email, $mobile, $first_name, $last_name, $recommanded_by); 
					     //echo "Affiliate : $affiliate_already_exist - Partenaire : $id_partenaire - Parrain : $id_upline - $email_p - $first_name  $last_name";
						 					 
						 IF ($affiliate_already_exist == 0 )    // L'AFFILIÉ N'EXISTE PAS DANS LA BASE
                                 { 	         $affiliate_already_exist  = ID_AFFILIATE_MAXIMUM($connection_database, 0);
								             $id_parrain               = $recommanded_by;
		                                     INSERT_INTO_AFFILIATE_DETAILS($connection_database, $id_parrain, $affiliate_already_exist, $id_partner_max, "En cours", $gender, $first_name, $last_name, $p_adresse, $cp, $ville, $mobile, $email, "", "", $date_naissance, $lieu_naissance, "FR", 0, 1, $latitude_secteur, $longitude_secteur);
										     
											 IF ( $pays_partenaire == "france" )
											 {
											 require_once('email/Inscription_email_partenaire.php');
											 SEND_EMAIL_INSCRIPTION_NOUVEAU_AFFILIE_PARTENAIRE($connection_database, $affiliate_already_exist, $id_partner_max, $s_sub_category_code, $s_sub_category, $serveur, $pays_partenaire );
											 }
											 ELSE IF ( $pays_partenaire == "portugal" )
											 {
                    		        		 require_once('email/Inscription_email_3_portugal.php'); 
                    		        		 SEND_EMAIL_INSCRIPTION_NOUVEAU_PORTUGAL( $connection_database, $affiliate_already_exist, $serveur);
											 }

								 }
                         ELSE                                   // L'AFFILIÉ EXISTE DANS LA BASE : LE MATCHING EST AUTOMATIQUE
                            {
                             update_affilie_id_partenaire($affiliate_already_exist, $id_partner_max);							 
							 insert_action_list("Partenaire qui match", 60, "Matching", 0, $id_partner_max, $affiliate_already_exist, "FERME", "MATCHING : ".$email,"", "Service Admin", 1, "");
                            }
							
  				///////////////////// INSERTION DANS LA TABLE DE LA TIMELINE						 
						 insert_timeline( 1, 2, $s_sub_category_code , $ville_secteur, "", $gender, $affiliate_already_exist,"", 0, "", ""  );
						 
		return ($affiliate_already_exist);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function UPDATE_PARTNER_IAD($connection_database2, $ligne, $is_managed) 
{
	 mysql_query(" UPDATE partner_iad SET is_managed= $is_managed   WHERE ligne = $ligne     "); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<?php function VACANCES_TOUS_PARTENAIRES_SAUF_IAD($connection_database2, $NosRezo_racine)
{    // FONCTION LAUNCH BY CRON
	     
		 //date_default_timezone_set('Europe/Paris');
		 $nb_days_a_ajouter       = 0;
		 $date_jour               = date('Y-m-d ',time() + $nb_days_a_ajouter * 60*60*24 );
		 $rapport_attribution     = "&nbsp 8. VACANCES TOUS PARTENAIRES SAUF IAD <br/>";	
		 		 
         // 1. ON DÉSACTIVE TEMPORAIREMENT LES PARTENAIRES 
         $sql    = " SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, date_debut_conges, date_fin_conges
		                         FROM partner_list pl 
		                         WHERE pl.id_services <> 1
								 AND   IS_ACTIVATED <> 0
								 AND   IS_ACTIVATED <> 9
								 AND   IS_ACTIVATED <> 8
								 AND   IS_ACTIVATED <> 7
								 AND   date_fin_conges >= date_debut_conges
								 AND   \"".$date_jour."\" >= date_debut_conges
								 AND   \"".$date_jour."\" <= date_fin_conges  
								 AND   date_debut_conges > '0000-00-00'     ";																 
		 $result = mysql_query($sql)  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		
		 WHILE ($reponse = mysql_fetch_array($result))
             { 			     
                      $id_partner        = $reponse['id_partner'];
                 
				      mysql_query(" UPDATE partner_list  SET  is_activated =  8	WHERE id_partner  = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." - EN VACANCES ! <br/> ";
			 }
			 
		 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
         // 2. ON REACTIVE LES PARTENAIRES 
		 $rapport_attribution = $rapport_attribution."<br/><br/>";
         $sql2    = " SELECT pl.id_partner, pl.p_contact_mail, pl.is_activated, pl.is_access_intranet, date_debut_conges, date_fin_conges
		                         FROM partner_list pl
		                         WHERE pl.id_services <> 1
								 AND   IS_ACTIVATED = 8
								 AND   date_fin_conges >= date_debut_conges
								 AND   \"".$date_jour."\" >= date_fin_conges   ";															 
		 $result = mysql_query($sql2)  or die(" Requete coordonnees : #PPTXPA pas comprise. ");				
		
		 WHILE ($reponse = mysql_fetch_array($result))
             { 			     
                 $id_partner = $reponse['id_partner'];
                 
				      mysql_query(" UPDATE partner_list SET is_activated = 1 WHERE id_partner = $id_partner     "); 
				      $rapport_attribution = $rapport_attribution." >> P$id_partner - ".$reponse['p_contact_mail']." - RETOUR DE VACANCES ! <br/> ";
			 }			 

	     return ($rapport_attribution);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function return_points_distance_algorithme($distance, $points_algorithme) 
{
				 IF ($points_algorithme == "")        {$points_algorithme = 0; }
                 $points_distance = 0;

                 IF      ( $distance <= 1 )           { $points_distance = 185; }
				 ELSE IF ( $distance <= 2 )           { $points_distance = 152; }
				 ELSE IF ( $distance <= 3 )           { $points_distance = 131; }
				 ELSE IF ( $distance <= 4 )           { $points_distance = 105; }
				 ELSE IF ( $distance <= 5 )           { $points_distance = 83; }
				 ELSE IF ( $distance <= 6 )           { $points_distance = 77; }
				 ELSE IF ( $distance <= 7 )           { $points_distance = 68; }
				 ELSE IF ( $distance <= 8 )           { $points_distance = 52; }
				 ELSE IF ( $distance <= 9 )           { $points_distance = 47; }
				 ELSE IF ( $distance <= 10 )          { $points_distance = 40; }
				 ELSE IF ( $distance <= 15 )          { $points_distance = 27; }
				 ELSE IF ( $distance <= 25)           { $points_distance = 25; }
				 ELSE IF ( $distance <= 30)           { $points_distance = 20; }
				 ELSE IF ( $distance <= 50)           { $points_distance = 10; }
				 ELSE                                 { $points_distance = 0;  }

			     $points_total  = $points_distance + $points_algorithme;
				 return array($points_distance, $points_total);	
				 
}
?>

<?php  function UPDATE_PARTNER_NOTATION_DATA($id_partner, $iad_compromis, $iad_last_compromis_date, $iad_date_debut_iad, $connection_database2) 
{                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                 //////////////// ALGORITHME DE CALCUL DU CLASSEMENT DES PARTENAIRES : PARTNER_NOTATION   ///////////////
				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 
				 $rapport_activite = "ALGORITHME DE CLASSEMENT PARTENAIRE - P$id_partner <br/>";
				 
				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 //1. POINTS DERNIER COMPROMIS
				 ////////////////////////////////////////////////////////////////////////////////////////////////////////

				 IF ( trim($iad_last_compromis_date) == "") 
				 { 
				 $points_last_compromis = 0; 
				 $rapport_activite = $rapport_activite."&nbsp &nbsp - 1. Pas de compromis signé = $points_last_compromis point <br/>";				 
				 }
				 ELSE IF ( trim($iad_compromis) == 0) 
				 { 
				 $points_last_compromis = 0; 
				 $rapport_activite = $rapport_activite."&nbsp &nbsp - 1. Pas de compromis signé = $points_last_compromis point <br/>";				 
				 }
				 ELSE //////
				 {
				 //date_default_timezone_set('Europe/Paris');
				 $iad_last_compromis_date       = str_replace("/", "-", $iad_last_compromis_date);
				 //list($jour,$mois,$annee)       = explode('-',$iad_last_compromis_date);
                 //$iad_last_compromis_date       = $annee.'-'.$mois.'-'.$jour;				 
				 $nb_jour_last_compromis        = round( (( strtotime(date('Y-m-d H:i:s',time())) -  strtotime( $iad_last_compromis_date ) )/(60*60*24)) ); 
				 
                 IF      ( $nb_jour_last_compromis <= 35 )          { $points_last_compromis = 30; }
				 ELSE IF ( $nb_jour_last_compromis <= 70 )          { $points_last_compromis = 25; }
				 ELSE IF ( $nb_jour_last_compromis <= 95 )          { $points_last_compromis = 20; }
				 ELSE IF ( $nb_jour_last_compromis <= 120 )         { $points_last_compromis = 15; }
				 ELSE IF ( $nb_jour_last_compromis <= 155)          { $points_last_compromis = 10; }
				 ELSE                                               { $points_last_compromis = 0;  }

				 $rapport_activite = $rapport_activite."&nbsp &nbsp - 1. Dernier compromis le $iad_last_compromis_date soit il y a $nb_jour_last_compromis jours = $points_last_compromis points <br/>";
                 }
				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 //2. POINTS COMPROMIS SUR 12 DERNIERS MOIS
				 //////////////////////////////////////////////////////////////////////////////////////////////////////
				 
				 //date_default_timezone_set('Europe/Paris');
				 $iad_date_debut_iad       = str_replace("/", "-", $iad_date_debut_iad);
				 //list($jour,$mois,$annee)  = explode('-',$iad_date_debut_iad);
                 //$iad_date_debut_iad       = $annee.'-'.$mois.'-'.$jour;
				 $nb_mois_iad              = round( (( strtotime(date('Y-m-d H:i:s',time())) -  strtotime( $iad_date_debut_iad ) )/(60*60*24)) /31); 
				 $points_last_compromis_12 = 0;
				
				 IF ($nb_mois_iad >= 12) 
				     {      IF ( $iad_compromis >= 12 )          { $points_last_compromis_12 = 30; }
					   ELSE IF ( $iad_compromis >= 10 )          { $points_last_compromis_12 = 25; }
					   ELSE IF ( $iad_compromis >= 8 )           { $points_last_compromis_12 = 20; }
					   ELSE IF ( $iad_compromis >= 6 )           { $points_last_compromis_12 = 15; }
					   ELSE IF ( $iad_compromis >= 3 )           { $points_last_compromis_12 = 10; }
					 }
				 ELSE
				     {      IF ($nb_mois_iad <= 2) { $nb_mois_iad = 3; }
					        $iad_compromis2 = ($iad_compromis / ($nb_mois_iad - 2) ) * 12;
    					    IF ( $iad_compromis2 >= 12 )          { $points_last_compromis_12 = 30; }
					   ELSE IF ( $iad_compromis2 >= 10 )          { $points_last_compromis_12 = 25; }
					   ELSE IF ( $iad_compromis2 >= 8 )           { $points_last_compromis_12 = 20; }
					   ELSE IF ( $iad_compromis2 >= 6 )           { $points_last_compromis_12 = 15; }
					   ELSE IF ( $iad_compromis2 >= 3 )           { $points_last_compromis_12 = 10; }
					 }

				 $rapport_activite = $rapport_activite."&nbsp &nbsp - 2. NB compromis 12 dernier mois. Début iad : $iad_date_debut_iad soit $nb_mois_iad mois = $points_last_compromis_12 points car $iad_compromis compromis. <br/>";

				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 ////// 3. POINTS NB AFFILIATE NIVEAU 1
				 //////////////////////////////////////////////////////////////////////////////////////////////////////

	             //$result20 = mysql_query(" SELECT affiliate_L1 
				 //                          FROM reporting_affiliate_1 ra, affiliate aa 
				//		                   WHERE ra.id_affiliate  = aa.id_affiliate
				//					       AND   aa.id_partenaire = ".$id_partner."    ") or die(" A - Requete pas comprise #1AA22"); 
			     //$reponse20         = mysql_fetch_array($result20);	
				 //$affiliate_L1      = $reponse20["affiliate_L1"];
				 
				 
                 List($id_affiliate, $id_partenaire, $first_name_a, $last_name_a) = RETURN_INFO_AFFILIATE_FROM_ID_PARTENAIRE($connection_database2, $id_partner);	
				 $affiliate_L1 =  COUNT_FILLEUL_LEVEL($id_affiliate, 1);

                 IF      ( $affiliate_L1 < 20 )          { $points_affiliate_L1 = 0; }
				 ELSE IF ( $affiliate_L1 < 40 )          { $points_affiliate_L1 = 10; }
				 ELSE IF ( $affiliate_L1 < 50 )          { $points_affiliate_L1 = 20; }
				 ELSE IF ( $affiliate_L1 < 70 )          { $points_affiliate_L1 = 30; }
				 ELSE IF ( $affiliate_L1 < 100 )         { $points_affiliate_L1 = 35; }
				 ELSE                                    { $points_affiliate_L1 = 40; }						 

				 $rapport_activite = $rapport_activite."&nbsp &nbsp - 3. [NB affiliate L1 : $affiliate_L1] = $points_affiliate_L1 points <br/> ";

				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 ////// MISE A JOUR DE LA SOMME DES POINTS POUR OPTIMISER LES PERFORMANCES EN LECTURE
				 ////////////////////////////////////////////////////////////////////////////////////////////////////////
				 
				 $sql = ("UPDATE partner_notation SET 
				              Total_points_algo         = points_nosrezo + '$points_affiliate_L1' + '$points_last_compromis' + '$points_last_compromis_12',
							  points_affiliate_niveau1  = '$points_affiliate_L1',
							  points_last_compromis     = '$points_last_compromis', 
							  date_entree_iad           = '$iad_date_debut_iad', 
							  points_last_compromis_12  = '$points_last_compromis_12', 
							  update_time               =  CURRENT_TIMESTAMP,
                              Explication               =  '$rapport_activite'						  
							  WHERE id_partner_notation = '$id_partner'        "); 
				//echo $sql."<br/>";
                mysql_query($sql);							  
							  
   			    return ($rapport_activite);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php  function insert_into_promotion_suivi($id_affiliate, $motif_promo, $notification_code, $level_concerned, $amount_promo_brut, $duree_promo_jours, $commentaire, $source_promotion) 
{	
			
				//date_default_timezone_set('Europe/Paris');
				$date_fin_promo    = date('Y-m-d H:i:s',time()+$duree_promo_jours*24*3600);     // AVANCE de Xj
                $sql ='insert into promotion_suivi( ligne_promo, id_affiliate, date_promo, motif_promo, notification_code, level_concerned, amount_promo_brut, is_activated, duree_promo_jours, date_fin_promo, commentaire ) 
				                             values (
											 "",
											 "'.$id_affiliate.'",
											 CURRENT_TIMESTAMP,
											 "'.$motif_promo.'", 
											 "'.$notification_code.'",
											 "'.$level_concerned.'",
											 "'.$amount_promo_brut.'",
											 1,
											 "'.$duree_promo_jours.'",
											 "'.$date_fin_promo.'",
											 "'.$commentaire.'"
											 )
											 ';
				 //echo $sql;
				 mysql_query('SET NAMES utf8');
                 $result = mysql_query($sql) or die("Requete pas comprise #WM4PAAZLZL");
                
				insert_action_notification($id_affiliate, $notification_code, 1, 0, "icon-info", "100 € pour votre Anniversaire", "Intranet_ma_remuneration.php"); 				 

				return ("OK");	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php  function INSERT_INTO_PARTNER_LIST_SERVICES($id_partner, $id_service) 
{				
                $sql ='insert into partner_list_services( id_ligne, id_partner, id_service, date_creation) 
				                             values (
											 "",
											 "'.$id_partner.'",
											 "'.$id_service.'",
											 CURRENT_TIMESTAMP
											 )
											 ';
                 $result = mysql_query($sql) or die("Requete pas comprise #WM4PQQZQQL");  
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function INSERT_INTO_PARTNER_LIST_SERVICES_VIAP($id_partenaire, $id_service, $action) 
{    // $ACTION = 1 EST INSERT 
     // $ACTION = 0 EST DELETE

				//date_default_timezone_set('Europe/Paris');
			    $sql = "SELECT * FROM partner_list_services 
				        WHERE id_partner = ".$id_partenaire."  
						AND id_service = ".$id_service."  ";  
						
                IF (($action == 1) AND  mysql_num_rows(mysql_query($sql)) == 0) // PAS DE LIGNE DANS LA TABLE : INSERT
                     { 				
				      $sql ='insert into partner_list_services(id_ligne, id_partner, id_service, date_creation  ) 
				                             values (
											 "",
											 "'.$id_partenaire.'",
											 "'.$id_service.'",
											 CURRENT_TIMESTAMP
											 )
											 ';
                      $result = mysql_query($sql) or die("Requete pas comprise partner_list_services - function.php ");  
				     }
				IF ($action == 0) 
				     {
					  $sql = "DELETE FROM partner_list_services  WHERE id_partner ='$id_partenaire' AND id_service = ".$id_service."   "; 
				      mysql_query($sql); 
					  //echo $sql;
					  
   			         }
				return ("OK");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  function amount_promotion_suivi_affiliate($id_affiliate)
{ // 2 VARIABLES DE RETOUR
     $result            = mysql_fetch_array(mysql_query(" SELECT count(id_affiliate) as nb_promo, IFNULL(amount_promo_brut, 0) as amount_promo_brut, IFNULL(date_fin_promo, 0) as  date_fin_promo    FROM promotion_suivi  WHERE id_affiliate  =".$id_affiliate ."  AND is_activated = 1 AND date_fin_promo > NOW( )    ")) or die("Requete pas comprise - #3Q0912! ");
     $amount_promo_brut = $result['amount_promo_brut'];	
     $date_fin_promo    = $result['date_fin_promo'];	

     return array($amount_promo_brut, $date_fin_promo); 
}
?>

<?php  function insert_action_notification($id_affiliate, $notification_code, $notification_status, $notification_read, $category_message, $message, $page_link) 
{   
     // NOTIFICATIONS CODE :
     // --------------------
     // 1. ANNIVERSAIRE                 happy_B_day.php
     // 2. NOTER PARTENAIRE             Intranet_Dossiers.php   
     // 3. DEMANDE PAIEMENT             Intranet_ma_remuneration.php   
	 // 4. VALIDER COMPETENCE           Intranet_partenaire_profil_master.php 
	 
     //date_default_timezone_set('Europe/Paris');
	 mysql_query('SET NAMES utf8');
	 $sql ='insert into action_notification( id_action_notification, id_affiliate, notification_code, notification_status, notification_read, category_message, message, page_link, creation_date) 
				                             values (
											 "",
											 "'.$id_affiliate.'", 
											 "'.$notification_code.'",
											 "'.$notification_status.'",
											 "'.$notification_read.'",
											 "'.$category_message.'",
											 "'.$message.'",
											 "'.$page_link.'",
											 "'.date("Y-m-d H:i:s").'"
											 ) 
											 ';
     $result = mysql_query($sql) or die("Requete action_notification pas comprise : #WX80");            
     return ("OK");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function INSERT_TIMELINE( $statut, $id_event, $id_service, $info_location, $info_event, $info_sexe, $id_affiliate, $link_page_php, $param_1, $param_2, $param_3 ) 
{   
     // TIMELINE      ID_EVENT :
     // -----------------------
     // 1.  AFFILIATE					:  insert into_affiliate_details
     // 2.  PARTENAIRE					:  insert_into_partner_list_master  / NosRezo12345678911_01.php page
     // 3.  RECOMMANDATION				:  insert_prescription.php script
	 // 4.  PRESENTATION NR             :  ADMIN
	 // 5.  FACEBOOK                    :  ADMIN
	 // 6.  CV MIS A JOUR               :  LE PARTENAIRE MET A JOUR SON CV
	 // 7.  NOTE COMPETENCE VALIDÉE     :  LE PARTENAIRE VALIDE LA COMPÉTÉNCE
	 
	 $ligne_deja_inseree = 0;
	 
	 IF ( $id_event == 6 ) // ON INSERE PAS DANS LA TIMELINE TOUTES LES MODIFICATIONS 
     {	 
			
     $result       =  mysql_fetch_array(mysql_query(" SELECT count(id_ligne) as ligne_deja_inseree
						                              FROM timeline  
						                              WHERE creation_date > DATE_SUB( CURDATE(),  INTERVAL 1 HOUR) 
													  AND id_event           = ". $id_event ."    
													  AND id_affiliate       = ". $id_affiliate."      ")) or die("Requete pas comprise - INSERT_TIMELINE123 ");
     $ligne_deja_inseree =  $result['ligne_deja_inseree'];
		
	 }
	 
	 IF ( $ligne_deja_inseree == 0)
	 {
               //date_default_timezone_set('Europe/Paris');
	           mysql_query('SET NAMES utf8');
	           $sql ='insert into timeline( id_ligne, statut, creation_date, id_event, id_service, info_location, info_event, info_sexe, id_affiliate, link_page_php, param_1, param_2, param_3 ) 
	  	        		                             values (
	  	        									 "",
	  	        									 "'.$statut.'", 
	  	        									 "'.date("Y-m-d H:i:s").'",
	  	        									 "'.$id_event.'",
	  	        									 "'.$id_service.'",
	  	        									 "'.$info_location.'",
	  	        									 "'.$info_event.'",
	  	        									 "'.$info_sexe.'",
	  	        									 "'.$id_affiliate.'",
	  	        									 "'.$link_page_php.'",
	  	        									 "'.$param_1.'",
	  	        									 "'.$param_2.'",
	  	        									 "'.$param_3.'"
	  	        									 ) 
	  	        									 ';
               $result = mysql_query($sql) or die("Requete pas comprise : #insert_timeline");   
     }	 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php function UPDATE_ACTION_NOTIFICATION_STATUS($id_affiliate, $notification_code)
{   /// NOTIFICATION_STATUS  = 0 = LA NOTIFICATION EST FERMÉE					 
							mysql_query(" UPDATE action_notification 
							              SET notification_status  = 0
										  WHERE notification_code   = '$notification_code' 
										  AND   id_affiliate        = '$id_affiliate'
										  AND   notification_status = 1   ");  
                            
							$rapport_activite = " &nbsp &nbsp >> Notification close pour A".$id_affiliate." <br/>"; 										  
                            return ($rapport_activite);			
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<?php  function CALENDAR_JOUR_MOIS($date_a_analyser) 
{
	          //date_default_timezone_set('Europe/Paris');
			  $jour_de_la_semaine = 0;
			  list( $annee, $mois, $jour)       = explode('-',$date_a_analyser);
                   IF ($jour_de_la_semaine == 1) {$jour_semaine = "Lun";}
              ELSE IF ($jour_de_la_semaine == 2) {$jour_semaine = "Mar";}
              ELSE IF ($jour_de_la_semaine == 3) {$jour_semaine = "Mer";}
              ELSE IF ($jour_de_la_semaine == 4) {$jour_semaine = "Jeu";}
              ELSE IF ($jour_de_la_semaine == 5) {$jour_semaine = "Ven";}
              ELSE IF ($jour_de_la_semaine == 6) {$jour_semaine = "Sam";}
              ELSE IF ($jour_de_la_semaine == 0) {$jour_semaine = "Dim";}			  
			  
                   IF ($mois == 1)  { $mois_a_afficher = "Jan";  }
              ELSE IF ($mois == 2)  { $mois_a_afficher = "Fév";  }			  
              ELSE IF ($mois == 3)  { $mois_a_afficher = "Mars"; }	
              ELSE IF ($mois == 4)  { $mois_a_afficher = "Avr";  }	
              ELSE IF ($mois == 5)  { $mois_a_afficher = "Mai";  }	
              ELSE IF ($mois == 6)  { $mois_a_afficher = "Juin"; }	
              ELSE IF ($mois == 7)  { $mois_a_afficher = "Jui";  }	
              ELSE IF ($mois == 8)  { $mois_a_afficher = "Aout"; }	
              ELSE IF ($mois == 9)  { $mois_a_afficher = "Sept"; }	
              ELSE IF ($mois == 10) { $mois_a_afficher = "Oct";  }	
              ELSE IF ($mois == 11) { $mois_a_afficher = "Nov";  }	
              ELSE IF ($mois == 12) { $mois_a_afficher = "Déc";  }	

              return array($jour_semaine, $jour, $mois_a_afficher, $annee );	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////  OPTIMISATION DU CODE  //////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<?php  function RETURN_INFO_DUPLICATE_ID_RECOMMANDATION($id_recommandation_origine)
{    ///////////////////////////////////////////////////// #3333
			
		 mysql_query('SET NAMES utf8');
		 $sql_1 = "    SELECT r_creation_date, id_recommandation , r_status, id_privileged_partner, duplicate_id_recommandation, r_managed_date                   
                       FROM recommandation_details rd1                                                            
                       WHERE rd1.id_recommandation      = ".$id_recommandation_origine." 
                       OR duplicate_id_recommandation   = ".$id_recommandation_origine." 
                       OR rd1.id_recommandation in (select duplicate_id_recommandation from recommandation_details  where id_recommandation  = ".$id_recommandation_origine." )					   "; 
		 //echo $sql_1;			           
		 $result          = mysql_query($sql_1) or die("Requete pas comprise - #3EFP0912! ");               
         $reco_duplicate  = mysql_num_rows($result);
				   
				   IF ($reco_duplicate == 1 )
				   {  						   
        			       echo '<div class="col-md-12 margin-top-0 note note-info ">';  
                           echo '<h5> Pour information, cette recommandation <b>n\'a pas</b> été dupliquée.  </h5>';
                           echo '</div>';
                   }
			       ELSE
				   {
				   
			               echo '<div class="col-md-12 margin-top-0 note note-info ">';  
                           echo '<h5> Le tableau ci-après présente les recommandations liées à la même recommandation :  </h5>';
                           echo '<button class="btn blue " style="margin-left:3px;" name="submit_plus_1"  type="submit" > Cette recommandation existe :  <span class="badge badge-info badge-roundless">'.$reco_duplicate.' fois </span>   </button>';
                           echo '</div>';				
			
			
                        ////////////// ENCADREMENT DU TABLEAU POUR POUVOIR LE MANIPULER  ////////////////////////////////////////////////////////////////////

				           echo '<div class="portlet-body col-md-12" >';
				           echo '<div class="table-responsive portlet " >';               
				           ////////////// PREMIERE LIGNE DU TABLEAU ON AFFICHE UN EN-TETE DIFFERENT  //////////////////////////////////
 				           echo '<table class="table table-striped table-bordered table-advance table-hover ">'."\n";
				           $background_color = '#4b8df8';
				           $font_color = '#FFFFFF';
				           echo '<thead>';
                           echo '<tr>';
              	           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >R#</th>';
              	           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " ><i class="fa fa-calendar"></i> Date Création</th>';
				           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >Statut</th>';
				           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >Duplication</th>';
				           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >Partenaires en charge de cette recommandation</th>';
				           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >Partenaires qui ont refusés</th>';
                           echo '</tr>'."\n";
				           echo '</thead>';
                           
                           ////////////// REMPLISSAGE DU TABLEAU  //////////////////////////////////////	   		   
      			            WHILE (		 $reponse = mysql_fetch_array($result))
				            {
				            			 ///////////////////////////////////////////////////////////////////
				            			 //date_default_timezone_set('Europe/Paris');
				            	         $date_max              = round(( strtotime(date('Y-m-d H:i:s',time())) -  strtotime($reponse["r_creation_date"]) )/(60*60*24) - 1);
				            			 IF ($date_max >1)          {$date_max=$date_max.' jours'; } 
				            			 ELSE IF ($date_max <2)     {$date_max=' Environ 1 jour'; }
                                         ELSE                       {$date_max=$date_max.' jour'; }										 
										 
				            			  echo '<tr>'; 					    
				            			  echo '<td style="text-align:center; " >R'.$reponse["id_recommandation"].' </td>'; 
				            			  echo '<td style="text-align:center; " >'.$reponse["r_creation_date"].' <br/><b>'.$date_max.'</b></td>';                                                                                            
				            			  echo '<td style="text-align:center; " >Étape '.$reponse["r_status"].' </td>';
				            			  echo '<td style="text-align:center; " >'; IF($reponse["duplicate_id_recommandation"] == 0) {echo '<b>SOURCE</b>';} else { echo 'R'.$reponse["duplicate_id_recommandation"];}   ' </td>';
				            			  echo '<td style="text-align:center; " >'; IF($reponse["r_status"] == 2) {echo ' - ';} else { echo 'P'.$reponse["id_privileged_partner"];}   ' </td>';	


                                            $result_refus   = mysql_fetch_array(mysql_query(" 
		                                                     SELECT count(id_partenaire) as nb_refus, id_partenaire, r_motif, p_first_name, p_last_name, p_contact_phone 
		                                                     FROM recommandation_refuse_partenaire , partner_list pl
		                                                     WHERE pl.id_partner  = id_partenaire
				            								 and id_recommandation    = ".$reponse["id_recommandation"]."   limit 0,5       ")) or die("Requete pas comprise - #3EFP0912! ");               
															 
				            			  echo '<td style="text-align:center; " >'; IF($result_refus["nb_refus"] == 0) { echo " - ";} else {echo 'P'.$result_refus["id_partenaire"].' <br/> '.$result_refus["p_first_name"].' '.$result_refus["p_last_name"]; }   ' </td>';						  
				            			  echo '</tr>'."\n";
				            	}
				            		  
                               echo"</table>";
				            echo '</div> ';
				            echo '</div> ';
				
				    }
				
                 $result_2   = (mysql_query(" 
		             SELECT rrp.id_partenaire, rrp.r_creation_date, p_first_name, p_last_name, p_contact_phone, rrp.id_recommandation 
		             FROM  recommandation_refuse_partenaire rrp, partner_list pl
		             WHERE pl.id_partner          = rrp.id_partenaire
		             AND   ( rrp.id_recommandation  = ".$id_recommandation_origine." 
                             OR rrp.id_recommandation  in (select duplicate_id_recommandation from recommandation_details  where id_recommandation  = ".$id_recommandation_origine." )	)
                     ORDER BY id_recommandation DESC							 ")) or die("Requete pas comprise - #3EFP0912! "); 					
                  
				  $reco_REFUS  = mysql_num_rows($result_2);
				   IF ($reco_REFUS > 0 )
				   {
				   
        			       echo '<div class="col-md-12 margin-top-0 note note-info ">';  
                           echo '<h5> Pour information, cette recommandation <b>a été refusée </b> par :  </h5>';
                           echo '</div>';	
                      ////////////// ENCADREMENT DU TABLEAU POUR POUVOIR LE MANIPULER  ////////////////////////////////////////////////////////////////////

				           echo '<div class="portlet-body col-md-12" >';
				           echo '<div class="table-responsive portlet " >';               
				           ////////////// PREMIERE LIGNE DU TABLEAU ON AFFICHE UN EN-TETE DIFFERENT  //////////////////////////////////
 				           echo '<table class="table table-striped table-bordered table-advance table-hover ">'."\n";
				           $background_color = '#4b8df8';
				           $font_color = '#FFFFFF';
				           echo '<thead>';
                           echo '<tr>';
              	           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >  R#</th>';
              	           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " ><i class="fa fa-calendar"></i> Date Refus</th>';
				           echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " >Partenaires qui ont refusés</th>';
                           echo '</tr>'."\n";
				           echo '</thead>';
                           
                           
                           ////////////// REMPLISSAGE DU TABLEAU  //////////////////////////////////////	   			   
      			            WHILE (		 $reponse2 = mysql_fetch_array($result_2))
				            {
				            			 ///////////////////////////////////////////////////////////////////
				             
				            			  echo '<tr>'; 
				            			  echo '<td style="text-align:center; " >R'.$reponse2["id_recommandation"].' </td>'; 										  
				            			  echo '<td style="text-align:center; " >'.$reponse2["r_creation_date"].' </td>';                                                                                            
				            			  echo '<td style="text-align:center; " > P'.$reponse2["id_partenaire"].' - '.$reponse2["p_first_name"].' '.$reponse2["p_last_name"].'  </td>';						  
				            			  echo '</tr>'."\n";
				            	}
				            		  
                               echo"</table>";
				            echo '</div> ';
				            echo '</div> ';				   
				   
				   
				   

                   }
                    ELSE
                    {
				   
        			       echo '<div class="col-md-12 margin-top-0 note note-info ">';  
                           echo '<h5> Pour information, cette recommandation <b>n\'a pas</b> été refusée.  </h5>';
                           echo '</div>';	
                     }						   


}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<?php function VERIFIER_DATE($value) 
{   ////////////////////////////////// VERIFIER SI LA DATE EST UN LUNDI OU DIMANCHE ////////////////////////////////

     preg_match(' /([0-9]+)\/([0-9]+)\/([0-9]+)/ ', $value , $match );
     $date = date("l", mktime(0, 0, 0, $match[2], $match[1], $match[3]));
     $date = trim($date);
	 
     IF (strstr($date,"Sunday") || strstr($date,"Monday") || strstr($date,"Saturday ") )
	 {
         return 1;
     }
     else{
         return 0;
     }

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php
////////////////////////////////Popup notification////////////////////////////////////////////////////////////

function notification($msg, $title, $type, $position, $url) {

    //Verifier la validité de l'url
    //if (preg_match('#^(http|https)://[\w-]+[\w.-]+\.[a-zA-Z]{2,6}#i', $url)) {
        $msg = urlclick($url,$msg);
    //} 
    
                               
    echo "<link rel='stylesheet' type='text/css' href='assets/global/plugins/bootstrap-toastr/toastr.min.css'/>";

    echo "<input type='hidden' name='msg_notification' id ='msg_notification' value='$msg'>";
    echo "<input type='hidden' name='title_notification' id ='title_notification' value='$title'>";
    echo "<input type='hidden' name='type_notification' id ='type_notification' value='$type'>"; // type = success , info , warning , error
    echo "<input type='hidden' name='position_notification' id ='position_notification' value='$position'>"; // position = toast-bottom-right , toast-top-right

    echo "<script src='scripts/js/popup_notification.js'></script>";

    echo "<script src='assets/global/plugins/jquery.min.js' type='text/javascript'></script>";
    echo "<script src='assets/global/plugins/jquery-migrate.min.js' type='text/javascript'></script>";
    echo "<script src='assets/global/plugins/bootstrap-toastr/toastr.min.js'></script>";
    echo "<script>
    jQuery(document).ready(function () {
        // initiate layout and plugins
        Metronic.init(); // init metronic core components
        UIToastr.init();
    });
</script>";
}
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php

///////////////////// Url cliquable ////////////////////////////////////////////////////////////////////////

function urlclick($url,$msg){ 
$url=preg_replace('`(((https?|ftp)://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})*(.*/*/*))`','<a href="$1" target="_blank">'.$msg.'</a>',$url);

return $url; 
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php
///////////////////////////////////// Visuel des statistiques /////////////////////////////////////////////

function visuel_statistique($titre_stat, $valeur_stat, $couleur_stat, $url_stat){
    
    // Valeur des couleurs : rouge --> "number bounce" ; vert --> "number visits" ; jaune --> "number transactions"
    // URL de type : https://www.exemple.com
    
    //Verifier la validité de l'url
    if (!preg_match('#^(http|https)://[\w-]+[\w.-]+\.[a-zA-Z]{2,6}#i', $url_stat)) {
        $url_stat ='';
    }
    
    echo "<div class='portlet light '>";
    echo "<div class='portlet-body'>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<div class='easy-pie-chart'>";
    echo "<div class='$couleur_stat' data-percent='$valeur_stat'>";
    echo "<span>+$valeur_stat </span>%";
    echo "</div>";
    echo "<a class='title'  href='$url_stat'>$titre_stat</a>";
    echo "</div></div></div></div></div>";

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php
////////////////////////////////////// FONCTION QUI RETOURNE UNE LISTE DE PARTENAIRE SELON DES PARAMETRES ////////////////////////
//Liste des paramètres:
///

//function list_partner($sub_category) {
//    $sql = "SELECT * FROM partner_list WHERE p_sub_category='".$sub_category."'";
//    mysql_query("SET NAMES 'utf8'");
//    $result = mysql_query($sql);
//    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
//        echo $row['p_first_name']. "<br>";
//    }
//}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////// ROGNER IMAGE /////////////////////////////////////////////////////////////////////
// Cette fonction permet de rogner une image de tel sorte qu'on aura comme dimension: largeur = hauteur et la copier dans un dossier donné
// Paramètres :
// $urlphoto : chemin absolu de l'image
// $fichier : nom de l'image
// $urldest : dosssier de ou sera copiée l'image après l'avoir rogner
function ROGNER_IMAGE($urlphoto, $fichier, $urldest) {

    if (!file_exists($urlphoto)) {
        return 0;
    }
    if (!file_exists($urlphoto . "/" . $fichier)) {
        return 0;
    }
    if (!file_exists($urldest)) {
        return 0;
    }


    if ($fichier != "." && $fichier != "..") {

        // Récupérer les dimension de l'image 
        $chemin = $urlphoto . "/" . $fichier;
        $size = getimagesize($chemin);
        $width = $size[0];
        $height = $size[1];
		//echo  $chemin."<br/>";

        //Calculer les nouvelles dimensions de l'image

        $dest_x = 0; // On colle l'image sur l'autre a 0 en abscisse
        $dest_y = 0; // On colle l'image sur l'autre a 0 en ordonnee

        if ($width > $height) {

            $src_departx = ceil(($width - $height) / 2); // on part de 50 en largeur
            $src_departy = 0;  // on part de 20 en hauteur
            $src_largeur = $height; // on copie de 50 en largeur
            $src_hauteur = $height; // on copie de 20 en hauteur
        } else
        if ($width < $height) {

            $src_departx = 0;
            $src_departy = ceil(($height - $width) / 2);
            $src_largeur = $width;
            $src_hauteur = $width;
        } else {
            $src_departx = 0;
            $src_departy = 0;
            $src_largeur = $width;
            $src_hauteur = $height;
        }


        $destination = imagecreatetruecolor($src_largeur, $src_hauteur); // on creer une image de la taille du cadre à copier
        $sourcejpeg = @imagecreatefromjpeg($urlphoto . '/' . $fichier); // celle qui sera copiée
        $sourcepng = @imagecreatefrompng($urlphoto . '/' . $fichier); // celle qui sera copiée


        if ($sourcejpeg) {
            imagecopy($destination, $sourcejpeg, $dest_x, $dest_y, $src_departx, $src_departy, $src_largeur, $src_hauteur);
            imagepng($destination, $urldest . $fichier);
            return 1;
        } else if ($sourcepng) {
            imagecopy($destination, $sourcepng, $dest_x, $dest_y, $src_departx, $src_departy, $src_largeur, $src_hauteur);
            imagepng($destination, $urldest . $fichier);
            return 1;
        } else {

            return 0;
        }
    } else {
        return 0;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>



<?php

/////////////////////////// Fonction pour rogner les images d'un dossier en une seul fois////////////////////////////////

// NB : Avant d'exécuter cette fonction veuiller augumenter la mémoire à 512Mo ou plus  en modifiant memory_limit = 512M dans le fichier php.ini

function ROGNER_IMAGES_DOSSIER($urldossier, $urldest) {

    //set_time_limit(0); // On augumente le temps d'exécution 

    if (file_exists($urldossier)) {
        $dossier = opendir($urldossier);
        $i = 0 ;
        while ($fichier = readdir($dossier)) 
		{

            if (!file_exists($urldest . $fichier)) 
			{
			    echo "<br/>File exist <br/>";
                $extension = pathinfo($fichier, PATHINFO_EXTENSION);

                if ($extension == 'PNG' || $extension == 'png' || $extension == 'JPG' || $extension == 'jpg') {

					echo "<br/>".$fichier."<br/>";
                    $test = rogner_image($urldossier, $fichier, $urldest);

                    
                    $i++;  
                }
            } 
            if ($i == 5) {
			   exit();
            }
        }
    }
   
}
////////////////////Expemple d'utilisation////////////////////////
//
//$urldossier = "fichiers/partenaires/photos/profil";
//$urldest = "fichiers/partenaires/photos/images_resize/";
//rogner_images_dossier($urldossier, $urldest);
//
//////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php  

/////////////////////////////////////// EDIT SIGNATURE CONTRAT PARTENAIRE//////////////////////////////////////////////////////

function signature_partenaire($id_partner, $id_statut) {
    
    mysql_query(" UPDATE partner_list SET p_contrat_recu  = '$id_statut' WHERE id_partner   = '$id_partner'    ");
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>





    
<?php

//////////////////////////// FONCTION POUR DESSINER UN GRAPHE POUR PRESENTER DES STATISTIQUES ////////////////////////////////////////
// Liste des paramètres : 
// $data : tableau multidimensionnnel conenant les données à affichier sur le graphe. Exp : $data = array('JAN' => 1000, 'FEV' => 900 , 'MAR' => 500)
// $stat_unit : Unité de calcul des stistique ; exp: $ , KM , Nombre de visite , ...
// $titre : titre du graphe
// $sous_titre : sous titre du graphe
// $couleur : couleur du graphe ; Couleur par défaut = #A9D0F5
// $id_graphe : id du graphe ; Util lorsqu'on veut afficher plusieurs graphes dans la même page, il est unique pour chaque graphe

function graphe_statistique2($data, $stat_unit, $titre, $sous_titre,$couleur,$id_graphe) {
    if($couleur == ''){
        $couleur = '#A9D0F5';
    }
    ?>
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $titre; ?></span>
                <span class="caption-helper"><?php echo $sous_titre; ?></span>
            </div>

        </div>
        <div class="portlet-body">
            <div id="graphe_loading2">
                <img src="assets/admin/layout/img/loading.gif" alt="loading"/>
            </div>
            <div id="<?php echo $id_graphe."_content"; ?>" class="display-none">
                <div id="<?php echo $id_graphe; ?>" style="height: 228px;">
                </div>
            </div>
        </div>
    </div>

    <script language="javascript">
        var stat_unit2 = '<?php echo $stat_unit ?>';
        var couleur2 = '<?php echo $couleur ?>';
        var id_graphe2 = '<?php echo '#'.$id_graphe ?>';
        var graphe_content2 = '<?php echo '#'.$id_graphe."_content" ?>';
    </script>
    <?php
// On passe le tableau au fichier JS
    echo '<script language="javascript">';
    echo 'data2 = new Object();';
    echo 'data2 = ' . json_encode($data) . ';';
    echo '</script>';
    ?>    

    <?php
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
    
    

<?php

//////////////////////////// FONCTION POUR DESSINER UN GRAPHE POUR PRESENTER DES STATISTIQUES ////////////////////////////////////////
// Liste des paramètres : 
// $data : tableau multidimensionnnel conenant les données à affichier sur le graphe. Exp : $data = array('JAN' => 1000, 'FEV' => 900 , 'MAR' => 500)
// $stat_unit : Unité de calcul des stistique ; exp: $ , KM , Nombre de visite , ...
// $titre : titre du graphe
// $sous_titre : sous titre du graphe
// $couleur : couleur du graphe ; Couleur par défaut = #A9D0F5
// $id_graphe : id du graphe ; Util lorsqu'on veut afficher plusieurs graphes dans la même page, il est unique pour chaque graphe

function graphe_statistique($data, $stat_unit, $titre, $sous_titre,$couleur,$id_graphe) {
    if($couleur == ''){
        $couleur = '#A9D0F5';
    }
    ?>
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $titre; ?></span>
                <span class="caption-helper"><?php echo $sous_titre; ?></span>
            </div>

        </div>
        <div class="portlet-body">
            <div id="graphe_loading">
                <img src="assets/admin/layout/img/loading.gif" alt="loading"/>
            </div>
            <div id="<?php echo $id_graphe."_content"; ?>" class="display-none">
                <div id="<?php echo $id_graphe; ?>" style="height: 228px;">
                </div>
            </div>
        </div>
    </div>

    <script language="javascript">
        var stat_unit = '<?php echo $stat_unit ?>';
        var couleur = '<?php echo $couleur ?>';
        var id_graphe = '<?php echo '#'.$id_graphe ?>';
        var graphe_content = '<?php echo '#'.$id_graphe."_content" ?>';
    </script>
    <?php
// On passe le tableau au fichier JS
    echo '<script language="javascript">';
    echo 'data = new Object();';
    echo 'data = ' . json_encode($data) . ';';
    echo '</script>';
    ?>    

    <?php
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

    
    
<?php

//////////////////////////// FONCTION POUR DESSINER UN GRAPHE POUR PRESENTER DES STATISTIQUES ////////////////////////////////////////
// Liste des paramètres : 
// $data_multiple : tableau multidimensionnnel conenant les données à affichier sur le graphe. Exp : $data = array('JAN' => 1000, 'FEV' => 900 , 'MAR' => 500)
// $stat_unit : Unité de calcul des stistique ; exp: $ , KM , Nombre de visite , ...
// $titre : titre du graphe
// $sous_titre : sous titre du graphe
// $couleur : couleur du graphe ; Couleur par défaut = #A9D0F5
// $id_graphe : id du graphe ; Util lorsqu'on veut afficher plusieurs graphes dans la même page, il est unique pour chaque graphe

// $data_multiple2 : tableau multidimensionnnel conenant les données à affichier sur le graphe. Exp : $data = array('JAN' => 1000, 'FEV' => 900 , 'MAR' => 500)
// $couleur2 : couleur du graphe ; Couleur par défaut = #F78181

// $label1 : label du graphe 1 
// $label2 : label du graphe 2 

function graphe_multiple($data,$data2, $stat_unit, $titre, $sous_titre,$couleur,$couleur2,$id_graphe,$label1,$label2) {
    if($couleur == ''){
        $couleur = '#A9D0F5';
    }
    if($couleur2 == ''){
        $couleur2 = '#F78181';
    }
    ?>
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-red-sunglo hide"></i>
                <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $titre; ?></span>
                <span class="caption-helper"><?php echo $sous_titre; ?></span>
            </div>

        </div>
        <div class="portlet-body">
            <div id="graphe_loading3">
                <img src="assets/admin/layout/img/loading.gif" alt="loading"/>
            </div>
            <div id="<?php echo $id_graphe."_content"; ?>" class="display-none">
                <div id="<?php echo $id_graphe; ?>" style="height: 228px;">
                </div>
            </div>
            <div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                                                            <span style="color: white ; background-color: <?php echo $couleur;?>">
										<?php echo "- ".$label1." - "; ?> 
                                                                                </span>
										
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										 <span style="color: white ; background-color: <?php echo $couleur2;?>">
										<?php echo "- ".$label2." - "; ?>  
                                                                                </span>
										
									</div>
									
								</div>
							</div>
        </div>
    </div>

    <script language="javascript">
        var stat_unit3 = '<?php echo $stat_unit ?>';
        var couleur3 = '<?php echo $couleur ?>';
         var couleur4 = '<?php echo $couleur2 ?>';
        var id_graphe3 = '<?php echo '#'.$id_graphe ?>';
        var graphe_content3 = '<?php echo '#'.$id_graphe."_content" ?>';
    </script>
    <?php
// On passe le tableau au fichier JS
    echo '<script language="javascript">';
    echo 'data3 = new Object();';
    echo 'data3 = ' . json_encode($data) . ';';
    echo 'data4 = new Object();';
    echo 'data4 = ' . json_encode($data2) . ';';
    echo '</script>';
    ?>    

    <?php
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function RETURN_INFO_FILLEUL_LEVEL1($id_affiliate) 
{
    $affilies = array();
    $sql = "SELECT affiliate.id_affiliate, affiliate.first_name, affiliate.last_name, affiliate.last_connection_date, affiliate_details.email, affiliate_details.phone_number 
	        FROM affiliate, affiliate_details 
		    WHERE is_activated = 1 
		    and id_upline = $id_affiliate 
			AND affiliate.id_affiliate = affiliate_details.id_affiliate
			order by last_connection_date desc ";
    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql) or die("Requete pas comprise code : #0400#");
	
    while ($reponse = mysql_fetch_array($result)) {
        $non_connecte             = intval((strtotime(date("Y-m-d H:i:s")) - strtotime($reponse['last_connection_date'])) / 86400);
        $last_connection_date     = $reponse['last_connection_date'];
        list($date)               = explode(" ", $last_connection_date);
        list($year, $month, $day) = explode("-", $date);
        $last_connection_date     = "$day/$month/$year ";
        $affilies[]               = array('id_affiliate' => $reponse['id_affiliate'], 'first_name' => $reponse['first_name'], 'last_name' => $reponse['last_name'], 'last_connection_date' => $last_connection_date, 'email' => $reponse['email'], 'non_connecte' => $non_connecte, 'phone_number' => $reponse['phone_number']);
    }
    return $affilies;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<?php  function DISPLAY_PROFILE_PICTURE_AFFILIE_MOBILE($id_affiliate, $id_partenaire, $param2)
{
     $name_file = "fichiers/affilies/photos/images_resize/affilie_".$id_affiliate."_profile.png";
     $path     = "../../fichiers/affilies/photos/images_resize/affilie_".$id_affiliate."_profile.png";
	 
     IF (!file_exists($path))
            {
				            $name_file = "fichiers/partenaires/photos/images_resize/partenaire_".$id_affiliate."_profile.png";
			                $path     = "../../fichiers/partenaires/photos/images_resize/partenaire_".$id_affiliate."_profile.png";
                            IF (!file_exists($path)) 
                               {           
						   				 $path     = "../../fichiers/partenaires/photos/profil/partenaire_X_profile.png";
				                         $name_file = "fichiers/partenaires/photos/profil/partenaire_X_profile.png";
						        }
            }
     return ($name_file);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

 
<?php function RETURN_TAUX_PRET()  {

$sql = "SELECT * FROM taux_pret";
mysql_query('SET NAMES utf8');
$result = mysql_query($sql) or die("Requete pas comprise code : #0401#");

$result = mysql_query($sql);
$reponse = mysql_fetch_array($result);
$dix_ans = $reponse['dix_ans'];
$quinze_ans = $reponse['quinze_ans'];
$vingt_ans = $reponse['vingt_ans'];
$vingt_cinq_ans = $reponse['vingt_cinq_ans'];
$trente_ans = $reponse['trente_ans'];

$list_taux[] = array('dix_ans' => $reponse['dix_ans'], 'quinze_ans' => $reponse['quinze_ans'], 'vingt_ans' => $reponse['vingt_ans'], 'vingt_cinq_ans' => $reponse['vingt_cinq_ans'], 'trente_ans' => $reponse['trente_ans']);

return $list_taux;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

    
<?php  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function UPDATE_TAUX_PRET($dix_ans, $quinze_ans, $vingt_ans, $vingt_cinq_ans, $trente_ans, $date_maj)
{
$sql = "UPDATE taux_pret 
        SET  dix_ans        = $dix_ans, 
		     quinze_ans     = $quinze_ans,
			 vingt_ans      = $vingt_ans, 
			 vingt_cinq_ans = $vingt_cinq_ans, 
			 trente_ans     = $trente_ans, 
			 date_maj       = '$date_maj'";
			 
$result = mysql_query($sql) or die("Requete pas comprise code : #0402#");

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function RETURN_LIST_RECOMMANDATION($id_partenaire)
{
    $list_recommandations = array();

    $countprescription = count_prescription_pour_partenaire($id_partenaire);
    
	$sql    = " SELECT r_creation_date, rd.id_recommandation, r_sub_category, r_sub_category_code, r_first_name, r_last_name, r_status, r_city, r_devis_ttc, r_gain, r_managed_date, id_privileged_partner, r_category, action_max_date, r_email, r_phone_number 
	            FROM   recommandation_details  rd , action_list ac
				WHERE rd.id_privileged_partner = ".$id_partenaire."
                AND   rd.id_recommandation = ac.id_recommandation 
				AND   action_status_int = 1  				
				AND   r_status > 2  
				AND   r_status < 8 order by action_max_date   ";

    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql) or die("Merci de contacter le support NosRezo : contact@nosrezo.com");
    while ($reponse = mysql_fetch_array($result)) {

        date_default_timezone_set('Europe/Paris');
        $date_max = round((strtotime($reponse["action_max_date"]) - strtotime(date('Y-m-d H:i:s', time()))) / (60 * 60 * 24));

        if ($date_max < 1) {
            $echeance = "A TRAITER";
        } else {
            $echeance = "Dans $date_max jours";
        }
        $nom = $reponse["r_first_name"] . ' ' . $reponse["r_last_name"];
        $ville = $reponse["r_city"];
        $etape = $reponse["r_status"];
        $categorie = $reponse["r_sub_category"];
        $id_recommandation = $reponse["id_recommandation"];
		$r_email = $reponse["r_email"];
		$r_phone_number = $reponse["r_phone_number"];

        $list_recommandations[] = array('nombre_reco' => $countprescription, 'echeance' => $echeance, 'nom' => $nom, 'ville' => $ville, 'etape' => $etape, 'categorie' => $categorie, 'date_max' => $date_max, 'id_recommandation' => $id_recommandation, 'r_email' => $r_email, 'r_phone_number'  => $r_phone_number );
    }

return $list_recommandations;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function RETURN_INFO_ENI_DEPARTEMENT() {
    $list_departements = array();

    $sql = "SELECT nom_departement, taux_vote FROM eni_dept_ouvert";

    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql);
    while ($reponse = mysql_fetch_array($result)) 
	{


        $nom_departement = $reponse["nom_departement"];
        $taux_vote = $reponse["taux_vote"];


        $list_departements[] = array('nom_departement' => $nom_departement, 'taux_vote' => $taux_vote);
    }

    return $list_departements;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>   

<?php 
function isValidIban($iban)
{
	/*Régles de validation par pays*/
	static $rules = array(
			'AL'=>'[0-9]{8}[0-9A-Z]{16}',
			'AD'=>'[0-9]{8}[0-9A-Z]{12}',
			'AT'=>'[0-9]{16}',
			'BE'=>'[0-9]{12}',
			'BA'=>'[0-9]{16}',
			'BG'=>'[A-Z]{4}[0-9]{6}[0-9A-Z]{8}',
			'HR'=>'[0-9]{17}',
			'CY'=>'[0-9]{8}[0-9A-Z]{16}',
			'CZ'=>'[0-9]{20}',
			'DK'=>'[0-9]{14}',
			'EE'=>'[0-9]{16}',
			'FO'=>'[0-9]{14}',
			'FI'=>'[0-9]{14}',
			'FR'=>'[0-9]{10}[0-9A-Z]{11}[0-9]{2}',
			'GE'=>'[0-9A-Z]{2}[0-9]{16}',
			'DE'=>'[0-9]{18}',
			'GI'=>'[A-Z]{4}[0-9A-Z]{15}',
			'GR'=>'[0-9]{7}[0-9A-Z]{16}',
			'GL'=>'[0-9]{14}',
			'HU'=>'[0-9]{24}',
			'IS'=>'[0-9]{22}',
			'IE'=>'[0-9A-Z]{4}[0-9]{14}',
			'IL'=>'[0-9]{19}',
			'IT'=>'[A-Z][0-9]{10}[0-9A-Z]{12}',
			'KZ'=>'[0-9]{3}[0-9A-Z]{3}[0-9]{10}',
			'KW'=>'[A-Z]{4}[0-9]{22}',
			'LV'=>'[A-Z]{4}[0-9A-Z]{13}',
			'LB'=>'[0-9]{4}[0-9A-Z]{20}',
			'LI'=>'[0-9]{5}[0-9A-Z]{12}',
			'LT'=>'[0-9]{16}',
			'LU'=>'[0-9]{3}[0-9A-Z]{13}',
			'MK'=>'[0-9]{3}[0-9A-Z]{10}[0-9]{2}',
			'MT'=>'[A-Z]{4}[0-9]{5}[0-9A-Z]{18}',
			'MR'=>'[0-9]{23}',
			'MU'=>'[A-Z]{4}[0-9]{19}[A-Z]{3}',
			'MC'=>'[0-9]{10}[0-9A-Z]{11}[0-9]{2}',
			'ME'=>'[0-9]{18}',
			'NL'=>'[A-Z]{4}[0-9]{10}',
			'NO'=>'[0-9]{11}',
			'PL'=>'[0-9]{24}',
			'PT'=>'[0-9]{21}',
			'RO'=>'[A-Z]{4}[0-9A-Z]{16}',
			'SM'=>'[A-Z][0-9]{10}[0-9A-Z]{12}',
			'SA'=>'[0-9]{2}[0-9A-Z]{18}',
			'RS'=>'[0-9]{18}',
			'SK'=>'[0-9]{20}',
			'SI'=>'[0-9]{15}',
			'ES'=>'[0-9]{20}',
			'SE'=>'[0-9]{20}',
			'CH'=>'[0-9]{5}[0-9A-Z]{12}',
			'TN'=>'[0-9]{20}',
			'TR'=>'[0-9]{5}[0-9A-Z]{17}',
			'AE'=>'[0-9]{19}',
			'GB'=>'[A-Z]{4}[0-9]{14}'
	);
	/*On vérifie la longueur minimale*/
	if(mb_strlen($iban) < 18)
	{
		return false;
	}
	/*On récupère le code ISO du pays*/
	$ctr = substr($iban,0,2);
	if(isset($rules[$ctr]) === false)
	{
		return false;
	}
	/*On récupère la règle de validation en fonction du pays*/
	$check = substr($iban,4);
	/*Si la règle n'est pas bonne l'IBAN n'est pas valide*/
	if(preg_match('~'.$rules[$ctr].'~',$check) !== 1)
	{
		return false;
	}
	/*On récupère la chaine qui permet de calculer la validation*/
	$check = $check.substr($iban,0,4);
	/*On remplace les caractères alpha par leurs valeurs décimales*/
	$check = str_replace(
			array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T','U', 'V', 'W', 'X', 'Y', 'Z'),
			array('10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35'),
			$check
			);
	/*On effectue la vérification finale*/
	return bcmod($check,97) === '1';
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
