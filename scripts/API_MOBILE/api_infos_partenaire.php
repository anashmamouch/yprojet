<?php

//header("Content-Type: application/json; charset=UTF-8");
//header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//header('Access-Control-Allow-Origin: *');

                                            // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 
include('../config_PDO.php');
List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");

$term = $_GET["term"];
$id_partenaire = addslashes($term);


$sql1 = "SELECT  id_notation, pnd.id_recommandation, pnd.p_notation_date, pnd.commentaires, rd.id_affiliate, r_zip_code, r_city, r_country, af.first_name, af.last_name, af.city
FROM    partner_notation_details pnd, recommandation_details rd, affiliate_details af
WHERE   pnd.id_partner       = :id_partenaire
AND     rd.id_recommandation =  pnd.id_recommandation	
AND     rd.id_affiliate      =  af.id_affiliate
AND	   af.id_affiliate > 5		
AND     pnd.is_activated = 1	";

try {
	$stmt = $connection_database2->prepare ( $sql1 );
	$stmt->execute ( array ( ':id_partenaire' => $id_partenaire ) );
	$result1 = $stmt->fetchAll ( PDO::FETCH_ASSOC );
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}

$commentaires = array();
foreach ($result1 as $partenaire){
	
	array_push($commentaires, $partenaire['commentaires']);
}

$sql2 = "SELECT aff.id_affiliate, aff.first_name, aff.last_name, aff_d.city  FROM affiliate aff, affiliate_details aff_d WHERE id_partenaire = :id_partenaire AND aff.id_affiliate = aff_d.id_affiliate";

try {
	$stmt = $connection_database2->prepare ( $sql2 );
	$stmt->execute ( array ( ':id_partenaire' => $id_partenaire ) );
	$result2 = $stmt->fetch ( PDO::FETCH_ASSOC );
} catch ( PDOException $e ) {
	die ( $e->getMessage () );
}
    


//////////////////////////////////////////////////////////////


$json = array();

$json[] = array(
    'id_affiliate' => $result2['id_affiliate'],
	'nom' => $result2['last_name'],
	'prenom' => $result2['first_name'],
	'ville' => $result2['city'],
	'commentaires' => $commentaires
);


echo json_encode($json);
?>