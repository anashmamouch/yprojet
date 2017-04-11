<?php
 
     include('../config.php'); 

     $term          = trim(stripslashes($_GET["term"]));
     $term          = addslashes($term);
	 $id_affiliate  = trim(substr($term, 1, 8));
	 
	 IF ( substr($term,0,1) == "A"  AND is_numeric($id_affiliate) == 1 )
	 {
     $sql          = " SELECT ad.last_name, ad.first_name, ad.id_affiliate, ad.zip_code, ad.city, ad.email, aa.id_partenaire, is_activated  
	                       FROM affiliate_details  ad , affiliate aa
						   WHERE     ad.id_affiliate = aa.id_affiliate
						   AND       ad.id_affiliate > 10 
						   AND       aa.is_activated = 1 
						   AND       ad.id_affiliate LIKE '".$id_affiliate."%'							 
						   ORDER  by ad.id_affiliate ";	 
	 }
	 ELSE IF ( substr($term,0,1) == "P"  AND is_numeric($id_affiliate) == 1 )
	 {
     $sql          = " SELECT ad.last_name, ad.first_name, ad.id_affiliate, ad.zip_code, ad.city, ad.email, aa.id_partenaire ,is_activated 
	                       FROM affiliate_details  ad , affiliate aa
						   WHERE     ad.id_affiliate = aa.id_affiliate
						   AND       ad.id_affiliate > 10 
						   AND       aa.is_activated = 1 
						   AND       aa.id_partenaire LIKE '".$id_affiliate."%'							 
						   ORDER  by ad.id_affiliate ";	 
	 }
	 ELSE IF ( is_numeric(trim($term)) == 1 )
	 {
     $sql          = " SELECT ad.last_name, ad.first_name, ad.id_affiliate, ad.zip_code, ad.city, ad.email, aa.id_partenaire, is_activated  
	                       FROM affiliate_details  ad , affiliate aa
						   WHERE     ad.id_affiliate = aa.id_affiliate
						   AND       ad.id_affiliate > 10 
						   AND       aa.is_activated = 1 
						   AND       ( ad.phone_number LIKE '%".$term."%'  OR  aa.id_partenaire in (select id_partner from partner_list WHERE p_contact_phone LIKE '%".$term."%') )						 
						   ORDER  by ad.id_affiliate ";	 
	 }
	 ELSE IF ( substr($term,0,1) == "#" ) // MODE IS_ACTIVATED = 0
	 {
     
	 $term = trim(substr($term,1,10));
	 $sql          = " SELECT ad.last_name, ad.first_name, ad.id_affiliate, ad.zip_code, ad.city, ad.email, aa.id_partenaire, is_activated  
	                       FROM affiliate_details  ad , affiliate aa
						   WHERE     ad.id_affiliate = aa.id_affiliate
						   AND       ad.id_affiliate > 10 
						   AND (     trim(CONCAT( trim(ad.last_name),  ' ', trim(ad.first_name) )) LIKE '%".$term."%' 
						         OR  trim(CONCAT( trim(ad.first_name), ' ', trim(ad.last_name) ))  LIKE '%".$term."%'
                                 OR  trim(ad.city)           LIKE  '%".$term."%'
                                 OR  trim(ad.email)          LIKE  '%".$term."%'
								 OR  trim(ad.phone_number)   LIKE  '%".$term."%'
								 OR  trim(ad.zip_code)       LIKE  '%".$term."%'
								 OR  ad.id_affiliate         LIKE  '%".$term."%'
								 OR  aa.id_partenaire        LIKE  '%".$term."%'
								 OR  aa.id_partenaire in (select id_partner from partner_list where trim( p_contact_mail )  LIKE  '%".$term."%'   )
								 )							 
						   ORDER  by ad.last_name ";
    }
	ELSE 
	{
     $sql          = " SELECT ad.last_name, ad.first_name, ad.id_affiliate, ad.zip_code, ad.city, ad.email, aa.id_partenaire, is_activated  
	                       FROM affiliate_details  ad , affiliate aa
						   WHERE     ad.id_affiliate = aa.id_affiliate
						   AND       ad.id_affiliate > 10 
						   AND       aa.is_activated = 1 
						   AND (     trim(CONCAT( trim(ad.last_name),  ' ', trim(ad.first_name) )) LIKE '%".$term."%' 
						         OR  trim(CONCAT( trim(ad.first_name), ' ', trim(ad.last_name) ))  LIKE '%".$term."%'
                                 OR  trim(ad.city)       LIKE  '%".$term."%'
                                 OR  trim(ad.email)      LIKE  '%".$term."%'
								 OR  trim(ad.zip_code)   LIKE  '%".$term."%'
								 OR  ad.id_affiliate     LIKE  '%".$term."%'
								 OR  aa.id_partenaire    LIKE  '%".$term."%'
								 OR  aa.id_partenaire in (select id_partner from partner_list where trim( p_contact_mail )  LIKE  '%".$term."%'   )
								 )							 
						   ORDER  by ad.last_name ";
    }	
	
	
	
	
	
	mysql_query('SET NAMES utf8');	
    $query  = mysql_query($sql);						   
    $json   = array();
 
    WHILE($student=mysql_fetch_array($query))
	{
         IF  ( $student["is_activated"] == 1 )    {  $compte_statut = "ACTIVÉ";     }
		 ELSE                                     {  $compte_statut = "DÉSACTIVÉ";  }
		 
		 $json[]=array(
                         'value'=>$student["id_affiliate"],
                         'label'=>$student["last_name"].'  '.$student["first_name"].' - '.$student["zip_code"].'  '.$student["city"].' - '.$student["email"].' - A'.$student["id_affiliate"].' - P'.$student["id_partenaire"].' - '.$compte_statut ,
                         'zip_code'=>$student["zip_code"],
					     'city'=>$student["city"]
                      );
    }
 
 echo json_encode($json);
 
?>