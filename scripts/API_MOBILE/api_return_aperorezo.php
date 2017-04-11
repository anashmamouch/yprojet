<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');



session_start();                                             // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 

$term = $_GET["term"];
$id_affiliate = addslashes($term);

date_default_timezone_set('Europe/Paris');
mysql_query('SET NAMES utf8');

$sql = " SELECT id_action_planning , id_affiliate, planning_time, DATE_FORMAT(planning_time, '%Y-%m-%d') as planning_day, substring(planning_time,12,5) as planning_heure, 
			                    DATE_FORMAT(planning_time, '%w') as planning_jour_semaine, DATE_FORMAT(planning_time, '%m') as planning_mois_de_annee, 
								DATE_FORMAT(planning_time, '%e') as jour_du_mois,  evenement, details, presentateur, endroit, endroit_complement, 
								adresse, place_disponible, place_reservees, 
			                   (SELECT count( * ) FROM planning_nr_reservation WHERE id_action_planning = plnr.id_action_planning AND id_affiliate = " . $id_affiliate . ") AS booked 
						FROM planning_nr plnr 
						where PLANNING_TIME > DATE_SUB( CURDATE(),  INTERVAL 1 DAY)   ORDER  by planning_time   ";
$result = mysql_query($sql) or die("Requete pas comprise : NosRezo12345678913.php - Oups");

$list_aperorezo = array();

WHILE ($reponse = mysql_fetch_array($result)) {

    IF ($reponse["planning_jour_semaine"] == 1) {
        $planning_jour_semaine = "Lundi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 2) {
        $planning_jour_semaine = "Mardi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 3) {
        $planning_jour_semaine = "Mercredi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 4) {
        $planning_jour_semaine = "Jeudi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 5) {
        $planning_jour_semaine = "Vendredi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 6) {
        $planning_jour_semaine = "Samedi";
    } ELSE IF ($reponse["planning_jour_semaine"] == 7) {
        $planning_jour_semaine = "Dimanche";
    } ELSE {
        $planning_jour_semaine = "Lundi";
    }
    IF ($reponse["planning_mois_de_annee"] == 1) {
        $planning_mois_de_annee = "janv";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 2) {
        $planning_mois_de_annee = "fév";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 3) {
        $planning_mois_de_annee = "mars";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 4) {
        $planning_mois_de_annee = "avril";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 5) {
        $planning_mois_de_annee = "mai";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 6) {
        $planning_mois_de_annee = "juin";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 7) {
        $planning_mois_de_annee = "juillet";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 8) {
        $planning_mois_de_annee = "août";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 9) {
        $planning_mois_de_annee = "sept";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 10) {
        $planning_mois_de_annee = "oct";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 11) {
        $planning_mois_de_annee = "nov";
    } ELSE IF ($reponse["planning_mois_de_annee"] == 12) {
        $planning_mois_de_annee = "déc";
    } ELSE {
        $planning_mois_de_annee = "janv";
    }

    $planning_heure = $reponse["planning_heure"];
    $valeur = $reponse["adresse"];
    
    $place_reservees    = $reponse["place_reservees"];
    $place_disponible   = $reponse["place_disponible"];
    $id_action_planning = $reponse["id_action_planning"];
    $id_affiliate_pres  = $reponse["id_affiliate"];
	$presentateur       = $reponse["presentateur"];
    $adresse            = $reponse["adresse"];
    $endroit            = $reponse["endroit"];
    $endroit_complement = $reponse["endroit_complement"];
    $details            = $reponse["details"];
    $jour_du_mois       = $reponse["jour_du_mois"];
	
		 $reponse2        = mysql_fetch_array(mysql_query("SELECT phone_number, email 
		                                                   FROM affiliate_details where id_affiliate = ".$id_affiliate_pres."   ")) or die("Requete pas comprise - #BVMPW32! ");
		 $a_phone_number = $reponse2['phone_number'];
		 $a_email        = $reponse2['email'];

    $list_aperorezo[] = array('planning_jour_semaine' => $planning_jour_semaine, 
	                          'planning_mois_de_annee' => $planning_mois_de_annee, 
							  'valeur' => $valeur, 
							  'place_reservees' => $place_reservees, 
							  'place_disponible' => $place_disponible, 
							  'id_action_planning' => $id_action_planning, 
							  'presentateur' => $presentateur, 
							  'adresse' => $adresse, 
							  'endroit' => $endroit, 
							  'details' => $details, 
							  'endroit_complement' => $endroit_complement, 
							  'jour_du_mois' => $jour_du_mois, 
							  'planning_heure' => $planning_heure,
							  'a_phone_number' => $a_phone_number, 
							  'a_email' => $a_email	 );
}

echo json_encode($list_aperorezo);
?>