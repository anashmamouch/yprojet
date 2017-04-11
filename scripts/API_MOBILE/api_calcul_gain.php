<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');


$postdata     = file_get_contents("php://input");             // RÉCUPÉRATION DU JSON
$request      = json_decode($postdata);

$nb_affiliate = $request->nb_affiliate;
$nb_valeur    = $request->nb_valeur;
$percent_num  = $request->percent_num;

$result_1_1 = 1;                             $result_1_2 = round($result_1_1 * $nb_valeur * 60/100, 1, PHP_ROUND_HALF_DOWN);
$result_2_1 = $nb_affiliate;                 $result_2_2 = round($result_2_1 * $nb_valeur * 9/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);
$result_3_1 = $result_2_1 * $nb_affiliate;   $result_3_2 = round($result_3_1 * $nb_valeur * 3/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);
$result_4_1 = $result_3_1 * $nb_affiliate;   $result_4_2 = round($result_4_1 * $nb_valeur * 3/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);
$result_5_1 = $result_4_1 * $nb_affiliate;   $result_5_2 = round($result_5_1 * $nb_valeur * 3/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);
$result_6_1 = $result_5_1 * $nb_affiliate;   $result_6_2 = round($result_6_1 * $nb_valeur * 3/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);
$result_7_1 = $result_6_1 * $nb_affiliate;   $result_7_2 = round($result_7_1 * $nb_valeur * 3/100 * $percent_num/100,  1, PHP_ROUND_HALF_DOWN);

	
// AFFICHAGE DU TOTAL EN ROSE
$result_8_1 = number_format($result_1_1 + $result_2_1 + $result_3_1 + $result_4_1 + $result_5_1 + $result_6_1 + $result_7_1, 0, ',', ' ');
$result_8_2 = number_format($result_1_2 + $result_2_2 + $result_3_2 + $result_4_2 + $result_5_2 + $result_6_2 + $result_7_2, 0, ',', ' ');

$json[] = array('mon_gain' => $result_1_2,
                'nb_affilie' => $result_1_1,
				'gain_niv1' => $result_2_2,
				'nb_affilie_niv1' => $result_2_1,
				'gain_niv2' => $result_3_2,
				'nb_affilie_niv2' => $result_3_1,
				'gain_niv3' => $result_4_2,
				'nb_affilie_niv3' => $result_4_1,
				'gain_niv4' => $result_5_2,
				'nb_affilie_niv4' => $result_5_1,
				'gain_niv5' => $result_6_2,
				'nb_affilie_niv5' => $result_6_1,
				'gain_niv6' => $result_7_2,
				'nb_affilie_niv6' => $result_7_1,
				'gain_total' => $result_8_2,
				'nb_affilie_total' => $result_8_1,
                			);

echo json_encode($json);
?>