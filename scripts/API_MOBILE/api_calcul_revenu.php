<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

session_start();                                              // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 

$postdata     = file_get_contents("php://input");             // RÉCUPÉRATION DU JSON
$request      = json_decode($postdata);

/////////// DÉCODAGE DU JSON EN ARRAY ////////////////////////////////////////////////////////////////////////////
$nb_personnes_niv1   = $request->nb_personnes_niv1 ;
$nb_moy_parrain_niv1 = $request->nb_moy_parrain_niv1 ;
$nb_moy_parrain_niv2 = $request->nb_moy_parrain_niv2 ;
$nb_moy_parrain_niv3 = $request->nb_moy_parrain_niv3 ;
$nb_moy_parrain_niv4 = $request->nb_moy_parrain_niv4 ;
$nb_moy_parrain_niv5 = $request->nb_moy_parrain_niv5 ;

$montant_revenu = 500;
$ca_moyen       = 500;
$population_mondiale = 3000000;
$percent_num         = 20; // 1 PERSONNE SUR 5 FAIT DES RECOS
    
         $result_2_1 = $nb_personnes_niv1;                        $result_2_2 = round( $result_2_1 * $montant_revenu * 9/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN);     
         $result_3_1 = $result_2_1 * $nb_moy_parrain_niv1;        $result_3_2 = round( $result_3_1 * $montant_revenu * 3/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN);     
         $result_4_1 = $result_3_1 * $nb_moy_parrain_niv2;        $result_4_2 = round( $result_4_1 * $montant_revenu * 3/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN);    
         $result_5_1 = $result_4_1 * $nb_moy_parrain_niv3;        $result_5_2 = round( $result_5_1 * $montant_revenu * 3/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN);     
         $result_6_1 = $result_5_1 * $nb_moy_parrain_niv4;        $result_6_2 = round( $result_6_1 * $montant_revenu * 3/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN);    
         $result_7_1 = $result_6_1 * $nb_moy_parrain_niv5;        $result_7_2 = round( $result_7_1 * $montant_revenu * 3/100 * $percent_num/100,  0, PHP_ROUND_HALF_DOWN); 
		 
      
        $commission_moy = $result_2_2 + $result_3_2 + $result_4_2 + $result_5_2 + $result_6_2 + $result_7_2 ;
        $montant_revenu   = $commission_moy ;
		$ca_moyen         = $commission_moy ;
		$nb_filleul_total = $result_7_1;


$json = array('montant_revenu' => $montant_revenu, 
              'ca_moyen' => $ca_moyen, 
			  'commission_moy' => $commission_moy, 
			  'nb_filleul_total' => $nb_filleul_total , 
		      'population_mondiale' => $population_mondiale);
				
echo json_encode($json);
?>