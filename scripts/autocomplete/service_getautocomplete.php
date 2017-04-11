<?php
 
 include('../config.php'); 
 
 $term = trim(stripslashes($_GET["term"]));
 $term = addslashes($term);
 
 mysql_query('SET NAMES utf8');	
 $query=mysql_query("SELECT  distinct(s_display) as s_display, id_services FROM services_autocomplete WHERE s_sub_category LIKE '%".$term."%' order by s_sub_category ");

    $json=array();
 
    while($student=mysql_fetch_array($query)){
         $json[]=array(
                    'value'=>$student["id_services"],
                    'label'=>$student["s_display"]
                        );
    }
 
 echo json_encode($json);
 
?>