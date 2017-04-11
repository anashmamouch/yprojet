<?php
include ('../config_PDO.php');

$term = trim ( stripslashes ( $_GET ["term"] ) );
$term = addslashes ( $term );

List ( $connection_database, $connection_ok, $message_erreur ) = PDO_CONNECT ( "", "", "" );

$sql      = "SELECT distinct (ad.id_affiliate) as id_affiliate, first_name, last_name, zip_code, city
					                       FROM affiliate_details ad, action_list al
										   WHERE ad.id_affiliate = al.id_affiliate
										   AND al.action_status_int = 1
										   AND al.action_id_category > 1
										   AND al.action_id_category <> 4
										   AND al.action_id_category <> 25
					                       AND trim(CONCAT( trim(ad.last_name),  ' ', trim(ad.first_name) )) LIKE '%" . $term . "%' 
			                               AND trim(CONCAT( trim(ad.first_name),  ' ', trim(ad.last_name) )) LIKE '%" . $term . "%' 
										   order by ad.last_name   ";

try {
	$stmt = $connection_database->prepare ( $sql );
	$stmt->execute();
	$reponse = $stmt->fetchAll( PDO::FETCH_ASSOC );
	$json = array ();
	foreach ($reponse as $student){
		$json [] = array (
				'value' => $student ["id_affiliate"],
				'label' => $student ["last_name"] . '  ' . $student ["first_name"] . ' - A' . $student ["id_affiliate"] . ''
		);
	}

} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}


echo json_encode ( $json );

?>