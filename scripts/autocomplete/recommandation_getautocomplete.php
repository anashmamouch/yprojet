<?php
 
     include('../config.php'); 

     $term              = trim(stripslashes($_GET["term"]));
     $term              = addslashes($term);
	 $id_recommandation = trim(substr($term, 1, 8));
	 
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 IF ( substr($term,0,1) == "R"  AND is_numeric($id_recommandation) == 1 )
	 {
     $sql          = " SELECT r_creation_date, id_recommandation, id_affiliate, r_status, r_email, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, id_iad_transaction , r_devis_ttc
		               FROM recommandation_details 
				       WHERE id_recommandation = '".$id_recommandation."%'			  ";	 
	 }
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 ELSE IF ( substr($term,0,1) == "T"  AND is_numeric($id_recommandation) == 1 )
	 {
     $sql          = " SELECT r_creation_date, id_recommandation, id_affiliate, r_status, r_email, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, id_iad_transaction , r_devis_ttc
		               FROM recommandation_details 
				       WHERE id_iad_transaction = '".$id_recommandation."%'			  ";	 
	 }
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 ELSE IF ( substr($term,0,1) == "P" )
	 {
     $sql          = " SELECT r_creation_date, id_recommandation, id_affiliate, r_status, r_email, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, id_iad_transaction , r_devis_ttc
		               FROM recommandation_details 
				       WHERE trim(r_gain_TTC)      LIKE  '%".$id_recommandation."%'		  ";	 
	 }
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 ELSE IF ( substr($term,0,6) == "TPLEIN"  )
	 {
     $sql          = " SELECT r_creation_date, id_recommandation, id_affiliate, r_status, r_email, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, id_iad_transaction , r_devis_ttc
		               FROM recommandation_details 
				       WHERE id_iad_transaction <> 0			  ";	 
	 }
	 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 ELSE
	 {
     $sql          = " SELECT r_creation_date, id_recommandation, id_affiliate, r_status, r_email, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary , id_iad_transaction, r_devis_ttc
		               FROM recommandation_details 
				       WHERE  (     trim(CONCAT( trim(r_first_name),  ' ', trim(r_last_name) )) LIKE '%".$term."%' 
						         OR  trim(CONCAT( trim(r_last_name), ' ', trim(r_first_name) ))  LIKE '%".$term."%'
                                 OR  trim(r_city)              LIKE  '%".$term."%'
                                 OR  trim(r_phone_number)      LIKE  '%".$term."%'
								 OR  trim(r_commentary)        LIKE  '%".$term."%'
								 OR  id_recommandation         LIKE  '%".$term."%'
								 OR  trim(r_email)             LIKE  '%".$term."%'
								 OR  trim(r_address)           LIKE  '%".$term."%'
								 OR  trim(r_gain_TTC)          LIKE  '%".$term."%'
								 )							 
						   ORDER  by r_first_name ";
    }
	mysql_query('SET NAMES utf8');	
    $query  = mysql_query($sql);						   
    $json   = array();
 
    WHILE($student=mysql_fetch_array($query))
	{
         $json[]=array(
                         'value'=>$student["id_recommandation"],
                         'label'=>$student["r_last_name"].'  '.$student["r_first_name"].' - '.$student["r_sub_category"].' - '.$student["r_zip_code"].'  '.$student["r_city"].' - '.$student["r_devis_ttc"].'€ - S'.$student["r_status"].' - IAD T'.$student["id_iad_transaction"].' - R'.$student["id_recommandation"],
                         'zip_code'=>$student["r_zip_code"],
					     'city'=>$student["r_city"]
                      );
    }
 
 echo json_encode($json);
 
?>