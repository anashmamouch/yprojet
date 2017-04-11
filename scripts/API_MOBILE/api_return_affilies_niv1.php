<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');



session_start();                                              // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 

$term = $_GET["term"];
$id_affiliate = addslashes($term);


header('Content-Type: application/json; charset=UTF-8');


$json = RETURN_INFO_FILLEUL_LEVEL1($id_affiliate);
echo json_encode($json);
?>