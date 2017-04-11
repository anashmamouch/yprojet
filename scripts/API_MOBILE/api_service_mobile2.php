<?php 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

     // CALLED BY APPS MOBILE ONLY
	 // CALL       : http://nosrezo.com/scripts/API_MOBILE/api_service_mobile.php
	 //              https://www.hurl.it/	 Content-Type  application/json
              
     include('../config.php');        // ON SE CONNECTE A LA BASE DE DONNÉE 

     $postdata       = file_get_contents("php://input");    # RÉCUPÉRATION DU JSON
     $request        = json_decode($postdata);              # DÉCODAGE DU JSON EN ARRAY
     $term           = $request->term;  

	 $id_partenaire_is_iad    = 0;
     $id_partenaire_is_iad    = $_GET["term"];	
     $country = $_GET["country"];

     $json     = array();
	 $compteur = 0;
	 
     mysql_query('SET NAMES utf8');	
	                     
     
					     IF ( $country == "Portugal" ) {  $requete_filtre_1 = " AND id_services in (1, 50) ";}
					     ELSE                                         {  $requete_filtre_1 = ""; }
						 
                         $sql    = " SELECT s_category, s_sub_category, id_services, type  FROM services WHERE is_activated = 1   $requete_filtre_1
						             ORDER BY master_order_affichage, order_affichage ";
						
						IF ( $id_partenaire_is_iad  == 1)
						 {
						  $sql    = " SELECT s_category, s_sub_category, id_services, type  FROM services WHERE is_activated = 1 and id_services <> 4 $requete_filtre_1
						              ORDER BY master_order_affichage, order_affichage ";	 
						 }	 
	 
						// echo $sql; 
						 
	 
	 
     $query = mysql_query($sql) or die("Requete pas comprise - #api_service_mobile.php! ");

	 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     WHILE( $service_recommandation = mysql_fetch_array($query) )
	    {
		 $affichage_service = "";
		 $compteur          = $compteur + 1;
		 
		     IF ( $service_recommandation['id_services'] == 50 ) // RECHERCHE IMMOBILIERE
		     {
			  $affichage_service = ' <div>
                                     TOUS LES POINTS SUIVANTS DOIVENT ÊTRE VALIDÉS  </br>
                                         <p> Votre contact acquéreur  : <p/>
							                 <p> A validé son financement  <p/>
					                         <p> Accepte de mandater un chasseur immobilier </p>	
					                         <p> Ne recherche pas par lui même </p>
					                         <p> Pas besoin de vendre son bien au préalable  </p>				         
					                 </div>	';
		     }

	 		 IF ( $service_recommandation['id_services'] == 55 ) // DESFISCALISATION IMMOBILIERE - PINEL
		    {
			 $affichage_service = ' <div>
                                    TOUS LES POINTS SUIVANTS DOIVENT ÊTRE VALIDÉS  </br>
                                        <p> Votre contact investisseur : <p/>
						                 <p> À une capacité d\'épargne 300€/mois  <p/>
				                         <p> Imposable à plus de 4000€/an </p>				         
				                         <p> Souhaite se constituer un patrimoine </p>
				                 </div>	';
		    }
			
              $json[] = array(
                         "s_category" => trim($service_recommandation['s_category']),
                         "s_sub_category" => $service_recommandation['s_sub_category'],
                         "id_services" => trim($service_recommandation['id_services']),
     		             "type" => trim($service_recommandation['type']),
			   	         "affichage_service" => trim($affichage_service)
                             );
        }
      
      echo json_encode($json);
      
?>