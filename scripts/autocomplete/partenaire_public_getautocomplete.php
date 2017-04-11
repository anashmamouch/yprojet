<?php
 
     include('../config.php'); 

     $term         = trim(stripslashes($_GET["term"]));
     $term         = addslashes($term);
	 $id_partner = trim(substr($term, 1, 8));
	 
     $sql          = " SELECT pl.p_last_name, pl.p_first_name, pl.id_partner, pl.p_zip_code, pl.p_city, pl.p_contact_mail 
	                       FROM partner_list pl
						   WHERE      pl.id_partner > 0 
						   AND        pl.is_activated in (1, 8) 
						   AND (     trim(CONCAT( trim(pl.p_last_name),  ' ', trim(pl.p_first_name) )) LIKE '%".$term."%' 
						         OR  trim(CONCAT( trim(pl.p_first_name), ' ', trim(pl.p_last_name) ))  LIKE '%".$term."%'
                                 OR  trim(pl.p_contact_mail)           LIKE  '%".$term."%'
								 OR  trim(pl.p_contact_phone)          LIKE  '%".$term."%'
								 )							 
						   ORDER  by pl.p_last_name ";

	mysql_query('SET NAMES utf8');	
    $query  = mysql_query($sql);						   
    $json   = array();
 
    WHILE($student=mysql_fetch_array($query))
	{
         $json[]=array(
                         'value'=>$student["id_partner"],
                         'label'=>$student["p_last_name"].'  '.$student["p_first_name"].' - '.$student["p_contact_mail"],
                         'p_zip_code'=>$student["p_zip_code"],
					     'p_city'=>$student["p_city"]
                      );
    }
 
 echo json_encode($json);
 
?>