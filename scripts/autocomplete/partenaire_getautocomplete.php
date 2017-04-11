<?php
include ('../config_PDO.php');

$term = trim ( stripslashes ( $_GET ["term"] ) );
$term = addslashes ( $term );

List ( $connection_database, $connection_ok, $message_erreur ) = PDO_CONNECT ( "", "", "" );


$sql    = "SELECT distinct (pl.id_partner) as id_partner, CONCAT( p_last_name, ' ', p_first_name ) AS p_contact, p_sub_category, pl.p_last_name, pl.p_first_name
					                       FROM partner_list pl, action_list al
										   WHERE pl.id_partner = al.id_partner
										   AND   pl.is_access_intranet = 1
										   AND   al.action_status_int = 1
                                           AND   al.action_id_category > 1
										   AND   al.action_id_category <> 4
										   AND   al.action_id_category <> 25
		                                   AND (trim(CONCAT( trim(pl.p_last_name), ' ', trim(pl.p_first_name) )) LIKE '%".$term."%' 
                                           OR trim(CONCAT( trim(pl.p_first_name), ' ', trim(pl.p_last_name) )) LIKE '%".$term."%')
										   ORDER by pl.p_last_name ";

try {
	$stmt = $connection_database->prepare ( $sql );
	$stmt->execute ();
	$reponse = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	$json = array ();
	foreach ( $reponse as $student ) {
		
		$json [] = array (
				'value' => $student ["id_partner"],
				'label' => $student ["p_last_name"] . '  ' . $student ["p_first_name"] . ' - P'. $student ["id_partner"]. '' 
		);
	}
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}

echo json_encode ( $json );

?>