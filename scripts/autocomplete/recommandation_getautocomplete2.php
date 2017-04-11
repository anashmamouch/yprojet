<?php
include ('../config_PDO.php');

$term = trim ( stripslashes ( $_GET ["term"] ) );
$term = addslashes ( $term );

List ( $connection_database, $connection_ok, $message_erreur ) = PDO_CONNECT ( "", "", "" );

	 IF ( is_numeric($term) == 1 )
	 {

                     $sql = " SELECT id_recommandation, \"\" as r_last_name, \"\" as r_first_name, \"\" as r_sub_category, \"\" as r_zip_code, \"\" as r_city  
					          FROM action_list
					          WHERE action_status_int = 1
							  AND action_id_category > 1
							  AND id_recommandation <> 0
							  AND action_id_category <> 4
							  AND action_id_category <> 25
                     	      AND id_recommandation LIKE '%" . $term . "%'                                           
							  ORDER BY id_recommandation DESC";
	 }
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

try {
	$stmt = $connection_database->prepare ( $sql );
	$stmt->execute();
	$reponse = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$json = array ();
	foreach ($reponse as $student){
		$json [] = array (
				'value' => $student ["id_recommandation"],
				'label' => $student ["id_recommandation"] . ' '. $student["r_last_name"].'  '.$student["r_first_name"].' - '.$student["r_sub_category"].' - '.$student["r_zip_code"].'  '.$student["r_city"].''
		);
	}

} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}


echo json_encode ( $json );

?>