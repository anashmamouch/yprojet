<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  1. EXPORT DES DONNÉES TO EXCEL 
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function return_month_french($month)
{
         $value = "";
	          IF ($month == 1)  {  $value = "Jan";  }
	     ELSE IF ($month == 2)  {  $value = "Fev";  }
	     ELSE IF ($month == 3)  {  $value = "Mars"; }
	     ELSE IF ($month == 4)  {  $value = "Avr";  }
	     ELSE IF ($month == 5)  {  $value = "Mai";  }
	     ELSE IF ($month == 6)  {  $value = "Juin"; }
	     ELSE IF ($month == 7)  {  $value = "Juil"; }
	     ELSE IF ($month == 8)  {  $value = "Aout"; }
	     ELSE IF ($month == 9)  {  $value = "Sept"; }
	     ELSE IF ($month == 10) {  $value = "Oct";  }
	     ELSE IF ($month == 11) {  $value = "Nov";  }
	     ELSE IF ($month == 12) {  $value = "Dec";  }
		 
		 return($value);
}
?>

<?php function DECODE_CATEGORY_SERVICE($id_service)
{
	          IF ($id_service == 1)  {  $value = "Mise en Vente";  }
	     ELSE IF ($id_service == 50) {  $value = "Mise en vente";  }
	     ELSE IF ($id_service == 7)  {  $value = "Mise en vente";  }
	     ELSE IF ($id_service == 4)  {  $value = "Financement";  }
	     ELSE IF ($id_service == 8)  {  $value = "Recrutement"; }
	     ELSE                        {  $value = "Travaux";  }
		 
		 return($value);
}
?>

<?php function ADJUST_DEVIS_NOT_TOO_MUCH($id_service, $r_devis_ttc)
{
	     IF ( $id_service == 1 OR $id_service == 50 OR $id_service == 7 )  
			{  
		         IF ( $r_devis_ttc > 50000 )     {  $r_devis_ttc = 50000; }
			}		 
		 return($r_devis_ttc);
}
?>

<?php function removeAccents($str)
{
	$charset='utf-8';
    $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    return $str;
}
?>

<?php function EXPORT_TO_EXCEL_1($connection_database2, $NosRezo_racine, $serveur)
{     
	$resultat1 = mysql_query(' SELECT id_recommandation, id_affiliate, r_status, r_creation_date, month(r_creation_date) as month, year(r_creation_date) as year, r_category, r_sub_category, r_sub_category_code, id_privileged_partner, r_zip_code, r_country, r_connection_with, r_devis_ttc, r_gain_TTC, r_gain, duplicate_id_recommandation , choose_to_not_pay 
	                           FROM recommandation_details	 ')  or die(" Requete coordonnees : #PPTXPA pas comprise. ");
    
	mysql_query('SET NAMES utf8');
    $file    = $NosRezo_racine."/scripts/reporting/Extract data - ".date('Y-m-d H-i-s',time()).".xls";	
    $id_file = fopen($file,'w+');
 
    fwrite($id_file,"id_recommandation"."\t");
    fwrite($id_file,"id_affiliate"."\t");
    fwrite($id_file,"r_status"."\t");
    fwrite($id_file,"r_creation_date"."\t");
    fwrite($id_file,"ID_Month"."\t");
    fwrite($id_file,"Month"."\t");
    fwrite($id_file,"Year"."\t");
    fwrite($id_file,"r_category"."\t");
    fwrite($id_file,"r_sub_category"."\t");
    fwrite($id_file,"category"."\t");
    fwrite($id_file,"id_privileged_partner"."\t");
    fwrite($id_file,"r_zip_code"."\t");
    fwrite($id_file,"r_connection_with"."\t");
    fwrite($id_file,"r_devis_ttc"."\t");
    fwrite($id_file,"r_gain_TTC"."\t");
    fwrite($id_file,"r_gain"."\t");
    fwrite($id_file,"duplicate_id_recommandation"."\t");
    fwrite($id_file,"choose_to_not_pay"."\t"); 
    fwrite($id_file,"r_country"."\n"); 
    
	$i=0;                                                        
    while($ligne1 = mysql_fetch_array($resultat1) )
    {    
         //strtr($str, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
         fwrite($id_file , $ligne1['id_recommandation']."\t");
         fwrite($id_file , $ligne1['id_affiliate']."\t");
         fwrite($id_file , $ligne1['r_status']."\t");
         fwrite($id_file , substr($ligne1['r_creation_date'],0,10)."\t");
         fwrite($id_file , $ligne1['month']."\t");
         fwrite($id_file , RETURN_MONTH_FRENCH($ligne1['month'])."\t");
         fwrite($id_file , $ligne1['year']."\t");
         fwrite($id_file , $ligne1['r_category']."\t");
         fwrite($id_file , REMOVEACCENTS($ligne1['r_sub_category'])."\t");
         fwrite($id_file , DECODE_CATEGORY_SERVICE( trim($ligne1['r_sub_category_code']) )."\t");		 
         fwrite($id_file , $ligne1['id_privileged_partner']."\t");
         fwrite($id_file , substr($ligne1['r_zip_code'],0,2)."\t");
         fwrite($id_file , $ligne1['r_connection_with']."\t");

         IF ( $ligne1['r_sub_category_code'] == 4) // FINANCEMENT 
         {
         fwrite($id_file,strtr($ligne1['r_gain_TTC'],'.',',')."\t");         	
         }
         ELSE
         {
         fwrite($id_file,strtr( ADJUST_DEVIS_NOT_TOO_MUCH( trim($ligne1['r_sub_category_code']) , $ligne1['r_devis_ttc']) ,'.',',')."\t");
         }		 
		 
         fwrite($id_file, strtr($ligne1['r_gain_TTC'],'.',',')."\t");
         fwrite($id_file, strtr($ligne1['r_gain'],'.',',')."\t");
         fwrite($id_file, $ligne1['duplicate_id_recommandation']."\t");
         fwrite($id_file, $ligne1['choose_to_not_pay']."\t");
		 fwrite($id_file, $ligne1['r_country']."\n");
         
		 $i++;
    }
 
 fclose($id_file);
 exit();	  
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php function EXPORT_TO_EXCEL_COMPTABLE($connection_database2, $NosRezo_racine, $serveur)
{     
	$resultat1 = mysql_query(" SELECT first_name, last_name, id_securite_sociale, zip_code, city, date_encaissement, p_company, id_recommandation, rd.id_affiliate, r_status, r_creation_date, month(date_encaissement) as month, year(date_encaissement) as year, r_category, r_sub_category, r_sub_category_code, id_privileged_partner, r_zip_code, r_city, r_first_name, r_last_name, r_country, r_connection_with, r_devis_ttc, r_gain_TTC, 	montant_tva_percent, r_gain, duplicate_id_recommandation , choose_to_not_pay, p_first_name, p_last_name 
	                           FROM recommandation_details rd, affiliate_details ad, partner_list pl
                               WHERE rd.id_affiliate = ad.id_affiliate
							   AND   rd.id_privileged_partner = pl.id_partner
							   AND   r_status >= 8
							   ORDER BY date_encaissement desc							   ")  or die(" Requete coordonnees : #PPTXPA pas comprise. ");
    
	mysql_query('SET NAMES utf8');
    $file    = $NosRezo_racine."/scripts/reporting/comptable/Extract comptable - ".date('Y-m-d H-i-s',time()).".xls";	
    $id_file = fopen($file,'w+');
 
    fwrite($id_file,"Num_Facture"."\t");
    fwrite($id_file,"Date_Facture"."\t");
    fwrite($id_file,"id_recommandation"."\t");
    fwrite($id_file,"date_encaissement"."\t"); 
    fwrite($id_file,"status dossier"."\t");
    fwrite($id_file,"id_partner"."\t");
    fwrite($id_file,"Entreprise"."\t"); 
    fwrite($id_file,"Contact_entreprise"."\t"); 
    fwrite($id_file,"creation_reco"."\t");
    fwrite($id_file,"Category"."\t");
//    fwrite($id_file,"r_sub_category"."\t");
    fwrite($id_file,"Sous Category"."\t");
    fwrite($id_file,"Dossier_reco"."\t"); 
    fwrite($id_file,"departement"."\t");
    fwrite($id_file,"ville recommandation"."\t");
    fwrite($id_file,"connection_with"."\t");
    fwrite($id_file,"devis_partenaire_ttc"."\t");	
    fwrite($id_file,"montant_tva_percent"."\t");	
    fwrite($id_file,"Gain_NR_TTC"."\t");
    fwrite($id_file,"Gain__NR_HT"."\t"); 
    fwrite($id_file,"only_TVA"."\t"); 
    fwrite($id_file,"Country"."\t");
    fwrite($id_file,"Num_Client"."\t");
    fwrite($id_file,"id_affiliate"."\t");
    fwrite($id_file,"Nom_affilie_a_payer"."\t");
    fwrite($id_file,"id_securite_sociale"."\t");
    fwrite($id_file,"ID_Month"."\t");
    fwrite($id_file,"Month"."\t");
    fwrite($id_file,"Year"."\t");	
    fwrite($id_file,"Ville_affilie"."\n"); 
    
	$i=0;                                                        
    while($ligne1 = mysql_fetch_array($resultat1) )
    {    
         //strtr($str, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
         fwrite($id_file , $ligne1['id_recommandation']."\t");
		 
			  $facturation_date = "";
			  $reponse4     = mysql_fetch_array(mysql_query(" SELECT COUNT(id_recommandation) as is_exist, action_date 
			                                                  FROM recommandation_facture 
			                                                  WHERE id_recommandation   = ".$ligne1['id_recommandation']."  limit 0,1    ")) ;
		           IF ( $reponse4['is_exist'] > 0 ) {  $facturation_date = $reponse4['action_date'];	}	
              ELSE IF ( $facturation_date == "")    {  $facturation_date = $ligne1['date_encaissement']; }		  
		 
         fwrite($id_file , $facturation_date."\t");		 	 
         fwrite($id_file , $ligne1['id_recommandation']."\t");
         fwrite($id_file , $ligne1['date_encaissement']."\t"); 
         fwrite($id_file , $ligne1['r_status']."\t");
         fwrite($id_file , $ligne1['id_privileged_partner']."\t");
         fwrite($id_file , $ligne1['p_company']."\t");
         fwrite($id_file , $ligne1['p_first_name']." ".$ligne1['p_last_name']."\t"); 		 
         fwrite($id_file , substr($ligne1['r_creation_date'],0,10)."\t");
         fwrite($id_file , $ligne1['r_category']."\t");
//         fwrite($id_file , REMOVEACCENTS($ligne1['r_sub_category'])."\t");
         fwrite($id_file , DECODE_CATEGORY_SERVICE( trim($ligne1['r_sub_category_code']) )."\t");
         fwrite($id_file , $ligne1['r_first_name']." ".$ligne1['r_last_name']."\t"); 		 
         fwrite($id_file , substr($ligne1['r_zip_code'],0,2)."\t");
         fwrite($id_file , $ligne1['r_city']."\t");
         fwrite($id_file , $ligne1['r_connection_with']."\t");

         IF ( $ligne1['r_sub_category_code'] == 4) // FINANCEMENT 
         {
         fwrite($id_file,strtr($ligne1['r_gain_TTC'],'.',',')."\t");         	
         }
         ELSE
         {
         fwrite($id_file,strtr( ADJUST_DEVIS_NOT_TOO_MUCH( trim($ligne1['r_sub_category_code']) , $ligne1['r_devis_ttc']) ,'.',',')."\t");
         }		 
         fwrite($id_file, strtr($ligne1['montant_tva_percent'],'.',',') ." %\t");
         fwrite($id_file, strtr($ligne1['r_gain_TTC'],'.',',')."\t");
         fwrite($id_file, strtr($ligne1['r_gain'],'.',',')."\t");
         fwrite($id_file, round($ligne1['r_gain_TTC'] - $ligne1['r_gain'],  3, PHP_ROUND_HALF_DOWN) ."\t");
		 fwrite($id_file, $ligne1['r_country']."\t"); 
         fwrite($id_file , $ligne1['id_affiliate']."\t");
         fwrite($id_file , $ligne1['id_affiliate']."\t");
         fwrite($id_file , $ligne1['first_name']." ".$ligne1['last_name']."\t"); 
         fwrite($id_file , $ligne1['id_securite_sociale']."\t");
         fwrite($id_file , $ligne1['month']."\t");
         fwrite($id_file , RETURN_MONTH_FRENCH($ligne1['month'])."\t");
         fwrite($id_file , $ligne1['year']."\t");
		 fwrite($id_file, $ligne1['zip_code'] ." ".$ligne1['city'] ."\n"); 
         
		 $i++;
    }
 
 fclose($id_file);
// exit();	  
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
