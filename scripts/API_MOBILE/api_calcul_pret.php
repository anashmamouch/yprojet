<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');


session_start();                                              // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 
//require('../config_PDO.php');                                 // ON SE CONNECTE A LA BASE DE DONNÉE 	
//List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");

//$postdata     = file_get_contents("php://input");             // RÉCUPÉRATION DU JSON
//$request      = json_decode($postdata);
//$id_affiliate = 0;

// DÉCODAGE DU JSON EN ARRAY
$montant_salaire_net = 5000;//$request->montant_salaire_net;
$duree_pret = 10;//$request->duree_pret;
$charges_mois = 100;//$request->charges_mois;
$id_affiliate = 11;//$request->id_affiliate;
$date_simulation = date("Y-m-d H:i:s");

List($jour, $mois, $annee, $jour_de_la_semaine, $timestamp, $heure, $minute, $seconde, $mois_a_afficher, $mois_a_afficher2 ) = RETURN_INFO_SUR_LA_DATE($date_simulation);
$date_maj_2      = $jour." ".$mois_a_afficher2." ".$annee;

$mensualite = ($montant_salaire_net / 3) - $charges_mois;

$sql = "SELECT * FROM taux_pret";
$result = mysql_query($sql) or die("Merci de contacter le support NosRezo : contact@nosrezo.com");
$reponse = mysql_fetch_array($result);
$taux_dix_ans = $reponse['dix_ans'];
$taux_quinze_ans = $reponse['quinze_ans'];
$taux_vingt_ans = $reponse['vingt_ans'];
$taux_vingt_cinq_ans = $reponse['vingt_cinq_ans'];
$taux_trente_ans = $reponse['trente_ans'];

$lastmodified = $reponse['date_maj'];
list($date) = explode(" ", $lastmodified);
list($year, $month, $day) = explode("-", $date);
$lastmodified = "$day/$month/$year ";

List($jour, $mois, $annee, $jour_de_la_semaine, $timestamp, $heure, $minute, $seconde, $mois_a_afficher, $mois_a_afficher2 ) = RETURN_INFO_SUR_LA_DATE($reponse['date_maj']);
$date_maj_2      = $jour." ".$mois_a_afficher2." ".$annee;


switch ($duree_pret) {
    case 10: $taux_pret = $taux_dix_ans;
        break;
    case 15: $taux_pret = $taux_quinze_ans;
        break;
    case 20: $taux_pret = $taux_vingt_ans;
        break;
    case 25: $taux_pret = $taux_vingt_cinq_ans;
        break;
    case 30: $taux_pret = $taux_trente_ans;
        break;

    default: $taux_pret = 0;
        break;
}

// FORMULE CALCUL PRET IMMOBILIER
$montant_pret = $mensualite / ( ( ($taux_pret / 100) / ( 1 - pow((1 + ($taux_pret / 100)), -$duree_pret) ) ) / 12 );
//$montant_pret = number_format( trim($montant_pret) , 0, ',', ' ');

$montant_pret = round($montant_pret, 2, PHP_ROUND_HALF_DOWN);
$mensualite = round($mensualite, 2, PHP_ROUND_HALF_DOWN);


IF ( $montant_salaire_net > 1000 AND $montant_salaire_net < 20000 AND $id_affiliate > 0 ) 
{
    $sql = " INSERT INTO historique_simulateur( id_affiliate, salaire, mensualite, taux_pret, duree_pret, montant_pret, date_simulation ) 
	         VALUES 
	        ( $id_affiliate, $montant_salaire_net, $mensualite, $taux_pret, $duree_pret, $montant_pret, '$date_simulation' )  ";
    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql) or die("Requete pas comprise : #407#");
}


$json[] = array('montant_pret' => $montant_pret, 
                'taux_pret' => $taux_pret, 
				'mensualite' => $mensualite, 
				'date_maj' => $lastmodified,
                'date_maj_2' => $date_maj_2				);
				
echo json_encode($json);
?>