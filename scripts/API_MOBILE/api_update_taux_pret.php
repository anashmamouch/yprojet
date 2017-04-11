<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// RETURN 0 : Taux non mis à jour 
// RETURN 1 : Taux mis à jour avec succès

session_start();                    // ON OUVRE LA SESSION EN COURS    
include('../config.php');            // ON SE CONNECTE A LA BASE DE DONNÉES 
require('../functions.php');         // ON DÉFINI LES FUNCTIONS   

$postdata = file_get_contents("php://input");    # Récupération du JSON
$request = json_decode($postdata);              # Décodage du JSON en array

$dix_ans = $request->dix_ans;
$quinze_ans = $request->quinze_ans;
$vingt_ans = $request->vingt_ans;
$vingt_cinq_ans = $request->vingt_cinq_ans;
$trente_ans = $request->trente_ans;
$date_maj = date('Y-m-d');


UPDATE_TAUX_PRET($dix_ans, $quinze_ans, $vingt_ans, $vingt_cinq_ans, $trente_ans, $date_maj);

?> 
