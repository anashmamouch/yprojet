<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');



session_start();                                             // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 

$term = $_GET["term"];
$id_recommandation = addslashes($term);

$json = array();



$sql = " SELECT r_creation_date, id_recommandation, r_status, id_affiliate, r_category, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, r_devis_ttc, montant_tva_percent, id_iad_transaction, r_lat, r_long  
	 FROM recommandation_details 
	 where id_recommandation = " . $id_recommandation . " ";

mysql_query('SET NAMES utf8');
$result = mysql_query($sql) or die(" Module en maintenance pour 10 minutes ");
$reponse = mysql_fetch_array($result);
$r_status = $reponse['r_status'];
$id_privileged_partner = $reponse['id_privileged_partner'];
$id_affiliate = $reponse['id_affiliate'];
$r_category = $reponse['r_category'];
$r_sub_category_code = $reponse['r_sub_category_code'];
$r_phone_number = $reponse['r_phone_number'];
$r_devis_ttc = $reponse['r_devis_ttc'];
$montant_tva_percent = $reponse['montant_tva_percent'];
$id_iad_transaction = $reponse['id_iad_transaction'];
$longitude = $reponse['r_long'];
$latitude = $reponse['r_lat'];
$ville_reco = $reponse['r_city'];
$r_first_name = $reponse['r_first_name'];
$r_last_name = $reponse['r_last_name'];

if ($reponse["r_category"] == "recrutement") {
    $montant = "Forfait recrutement";
} else if ($reponse["r_category"] == "immobilier") {

    IF ($r_sub_category_code == 4) {
        $montant = "Montant emprunté";
    } ELSE {
        $montant = "Montant des honoraires ttc";
    }
} else if ($reponse["r_category"] == "travaux") {
    $montant = "Devis des travaux ttc";
} else if ($reponse["r_category"] == "autres") {
    $montant = "Devis ttc";
} else {
    $montant = "Devis ttc";
}


$json[] = array('id_recommandation' => $id_recommandation, 
                 'r_status' => $r_status, 
				 'id_privileged_partner' => $id_privileged_partner, 
				 'id_affiliate' => $id_affiliate, 
				 'r_category' => $r_category, 
				 'r_sub_category_code' => $r_sub_category_code, 
				 'r_phone_number' => $r_phone_number, 
				 'r_devis_ttc' => $r_devis_ttc, 
				 'montant_tva_percent' => $montant_tva_percent, 
				 'id_iad_transaction' => $id_iad_transaction, 
				 'longitude' => $longitude, 
				 'latitude' => $latitude, 
				 'ville_reco' => $ville_reco, 
				 'montant_label' => $montant,
				 'r_first_name' => $r_first_name,
				 'r_last_name' => $r_last_name
				 );

echo json_encode($json);
?>