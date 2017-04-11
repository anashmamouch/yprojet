<?php 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

     // CALLED BY APPS MOBILE ONLY
              
     include('../config.php');        // ON SE CONNECTE A LA BASE DE DONNÉE 

     $postdata       = file_get_contents("php://input");    # RÉCUPÉRATION DU JSON
     $request        = json_decode($postdata);              # DÉCODAGE DU JSON EN ARRAY
     $term           = $request->term;          
	 
      $term = strtolower(trim(stripslashes($_GET["term"])));
      $term = addslashes($term);
      
      mysql_query('SET NAMES utf8');	
      
     	IF (is_numeric($term)) // NOUS RECHERCONS LE CODE POSTAL
              {
     		  $query=mysql_query(" SELECT distinct (ville) as ville, cp, LATITUDE, LONGITUDE, country  FROM cp_autocomplete 
     		                       WHERE cp LIKE '".$term."%' 
     							   OR trim(CONCAT( trim(cp),  ' ', trim(ville) )) LIKE '%".$term."%' 
     							   order by country, ville       ");
     		 } 
     	ELSE  IF ( substr($term,0,7) == "reunion" ) // NOUS RECHERCHONS EXPRESSEMENT SUR l'ILE DE LA REUNION
     	     {
     		  $query=mysql_query(" SELECT distinct (ville) as ville, cp, LATITUDE, LONGITUDE, country  FROM cp_autocomplete 
     		                       WHERE country like '%".$term."%' 
     							   ORDER BY ville  
     							 ");
     
              }
     	ELSE  IF ( substr($term,0,8) == "portugal" ) // NOUS RECHERCHONS PAR PAYS
     	     {
     		  $query=mysql_query(" SELECT distinct (ville) as ville, cp, LATITUDE, LONGITUDE, country  FROM cp_autocomplete 
     		                       WHERE country like '%".$term."%' 
     							   ORDER BY ville
       							   LIMIT 0, 50
     							 ");
     
              }
         ELSE		 // NOUS RECHERCHONS LA VILLE 
     	     {
     		  $term2 = $term;
     		  $term3 = $term;
     		  IF ( ( substr($term,0,5) == "saint") )  
     		         {    
     			         $term2 ="saint-".trim(substr($term,6,15));  
     			         $term3 ="st ".trim(substr($term,3,15));  
     				 }
     		  ELSE IF ( ( substr($term,0,3) == "st ") )  
     		         {    
     			         $term2 ="saint-".trim(substr($term,3,15));
       			         $term3 ="st-".trim(substr($term,3,15)); 
     				 }
     		  ELSE IF ( ( substr($term,0,3) == "st-") )  
     		         {    
     			         $term2 ="saint-".trim(substr($term,3,15));  
     			         $term2 ="saint ".trim(substr($term,3,15)); 
     				 }
     				 
     
     		  $query=mysql_query(" SELECT distinct (ville) as ville, cp, LATITUDE, LONGITUDE, country  FROM cp_autocomplete 
     		                       WHERE VILLE LIKE '".$term."%' 
     							   OR trim(CONCAT( trim(cp),  ' ', trim(ville) )) LIKE '".$term."%'
     							   OR trim(CONCAT( trim(ville),  ' ', trim(CP) )) LIKE '".$term."%'
     							   OR trim(CONCAT( trim(ville),  ' ', trim(CP) )) LIKE '".$term2."%'
     							   OR trim(CONCAT( trim(ville),  ' ', trim(CP) )) LIKE '".$term3."%'
     							   ORDER BY ville  
     							 ");
     		 } 
     
         $json=array();
      
         while($student=mysql_fetch_array($query))
		 {
			 IF (  mysql_num_rows($query) < 1 ) { $student["cp"] = 0; }
			 
              $json[]=array(
                         'value'=>trim($student["cp"]),
                         'label'=>$student["cp"].'  '.$student["ville"],
                         'latitude'=>trim($student["LATITUDE"]),
     					 'longitude'=>trim($student["LONGITUDE"]),
     					 'country'=>trim($student["country"])
                             );
         }
      
      echo json_encode($json);
      
?>