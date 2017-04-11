<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// RETURN 0 : Profil non mis à jour 
// RETURN 1 : Profil mis à jour avec succès

session_start();                         // ON OUVRE LA SESSION EN COURS        
require('../functions.php');             // ON DÉFINI LES FUNCTIONS   
require('../function_12345678910.php');
include('../config.php');                // ON SE CONNECTE A LA BASE DE DONNÉES 

//include('../config_PDO.php');
List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");

$postdata = file_get_contents("php://input");    # Récupération du JSON
$request = json_decode($postdata);              # Décodage du JSON en array



$id_affiliate = $request->id_affiliate;
$phone_number = $request->phone_number;
$address = $request->address;
$zip_code = $request->zip_code;
$city = $request->city;
$birth_date = $request->birth_date;
$birth_place = $request->birth_place;
$nationality = $request->nationality;
$id_securite_sociale = $request->id_securite_sociale;
$logement_affiliate = $request->logement_affiliate;
$statut_logement = $request->statut_logement;


IF (get_magic_quotes_gpc()) {
    $address = stripslashes($address);
}
$address = mysql_real_escape_string($address);

IF (get_magic_quotes_gpc()) {
    $city = stripslashes($city);
}
$city = mysql_real_escape_string($city);

IF (get_magic_quotes_gpc()) {
    $birth_place = stripslashes($birth_place);
}
$birth_place = mysql_real_escape_string($birth_place);

IF (get_magic_quotes_gpc()) {
    $nationality = stripslashes($nationality);
}
$nationality = mysql_real_escape_string($nationality);

IF (get_magic_quotes_gpc()) {
    $id_securite_sociale = stripslashes($id_securite_sociale);
}
$id_securite_sociale = mysql_real_escape_string($id_securite_sociale);


if ($res = UPDATE_AFFILIATE_DETAILS_PROFIL( $connection_database2, $id_affiliate, $phone_number, $zip_code, $address, $city, $birth_place, $nationality, $id_securite_sociale, $logement_affiliate, $statut_logement)) {
    $json[] = array('data' => $res);
    echo json_encode($json);
} else {
    $json[] = array('data' => 0);
    echo json_encode($json);
}
?> 
