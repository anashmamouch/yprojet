<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');


// CALLED BY APPS MOBILE ONLY
// CALL       : http://nosrezo.com/scripts/API_MOBILE/api_return_info_affiliate.php?term=11
//              https://www.hurl.it/	 Content-Type  application/json
//      	{
// 	  			"term":11 
//			}

session_start();                                              // ON OUVRE LA SESSION EN COURS
include('../config.php');                                     // ON SE CONNECTE A LA BASE DE DONNÉE 	 
//include('../config_PDO.php');

require('../functions.php');                                  // ON DÉFINI LES FUNCTIONS 


//List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");
$connection_database2 = "";

$term = $_GET["term"];
$id_affiliate = addslashes($term);



List($first_name_aff, $id_affiliate, $id_partenaire_aff, $email_aff, $id_upline, $id_partenaire_is_iad, $source, $parrain_is_iad, $id_parrain_is_iad, $id_parrain_2_is_iad, $last_name, $phone_number, $address, $zip_code, $city, $birth_date, $birth_place, $nationality, $id_securite_sociale, $logement_affiliate, $statut_logement,  $photo_profil, $id_partenaire_du_parrain_1, $service_du_parrain_1, $parrain_2_is_iad, $id_partenaire_du_parrain_2, $service_du_parrain_2 ) = RETURN_SESSION_FROM_ID_AFFILIATE($connection_database2, $id_affiliate);
List($name_parrain, $email_parrain, $tel_parrain ) = INFO_PARRAIN_AFFILIATE($connection_database2, $id_upline);

$telephone_service_qualite = $telephone_call_center;


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$result_1_1 = 0;
$nb_affiliate_level_1 = COUNT_FILLEUL_LEVEL($id_affiliate, 1);
$nb_affiliate_level_2 = COUNT_FILLEUL_LEVEL($id_affiliate, 2);
$result_4_1 = COUNT_FILLEUL_LEVEL($id_affiliate, 3);
$result_5_1 = COUNT_FILLEUL_LEVEL($id_affiliate, 4);
$result_6_1 = COUNT_FILLEUL_LEVEL($id_affiliate, 5);
$result_7_1 = COUNT_FILLEUL_LEVEL($id_affiliate, 6);
$nb_filleul_total = $result_1_1 + $nb_affiliate_level_1 + $nb_affiliate_level_2 + $result_4_1 + $result_5_1 + $result_6_1 + $result_7_1;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$result_1_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 1);
$result_2_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 2);
$result_3_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 3);
$result_4_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 4);
$result_5_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 5);
$result_6_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 6);
$result_7_2 = COUNT_RECOMANDATION_LEVEL($id_affiliate, 7);
$nb_reco_total = $result_1_2 + $result_2_2 + $result_3_2 + $result_4_2 + $result_5_2 + $result_6_2 + $result_7_2;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$result_1_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 1, 0.60);
$result_2_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 2, 0.09);
$result_3_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 3, 0.03);
$result_4_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 4, 0.03);
$result_5_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 5, 0.03);
$result_6_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 6, 0.03);
$result_7_status_7 = COUNT_SUM_GAIN_RECO_LEVEL($id_affiliate, 7, 0.03);
$gain_potentiel = number_format($result_1_status_7 + $result_2_status_7 + $result_3_status_7 + $result_4_status_7 + $result_5_status_7 + $result_6_status_7 + $result_7_status_7, 0, ',', ' ');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$result_1_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 0);
$result_2_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 1);
$result_3_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 2);
$result_4_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 3);
$result_5_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 4);
$result_6_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 5);
$result_7_status_89 = COUNT_COMMISSION_COMPTABLE_LEVEL($id_affiliate, 6);
$commission_a_encaisser = $result_1_status_89 + $result_2_status_89 + $result_3_status_89 + $result_4_status_89 + $result_5_status_89 + $result_6_status_89 + $result_7_status_89;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Nombre des recos du partenaire
$nb_reco = COUNT_PRESCRIPTION_POUR_PARTENAIRE($id_partenaire_aff);
$reco_en_retard = 0;


// Liste des recos du partenaire en retard ///////////////////////////////////////////////////////////
if($id_partenaire_aff > 0){
$sql    = " SELECT r_creation_date, rd.id_recommandation, r_sub_category, r_sub_category_code, r_first_name, r_last_name, r_status, r_city, r_devis_ttc, r_gain, r_managed_date, id_privileged_partner, r_category, action_max_date, r_email, r_phone_number 
	            FROM   recommandation_details  rd , action_list ac
				WHERE rd.id_privileged_partner = ".$id_partenaire_aff."
                AND   rd.id_recommandation = ac.id_recommandation 
				AND   action_status_int = 1  				
				AND   r_status > 2  
				AND   r_status < 8    ";

    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql) or die("Merci de contacter le support NosRezo : contact@nosrezo.com");
    $reco_en_retard = 0;
    date_default_timezone_set('Europe/Paris');
	
    while ($reponse = mysql_fetch_array($result)) {
        $date_max = round((strtotime($reponse["action_max_date"]) - strtotime(date('Y-m-d H:i:s', time()))) / (60 * 60 * 24));
        if($date_max <= 0){
            $reco_en_retard++;
        }
       
    }
}
    

//////////////////////////////////////////////////////////////


$json = array();
$json[] = array(
    'id_affiliate' => $id_affiliate,
    'first_name' => $first_name_aff,
    'last_name' => $last_name,
    'email_aff' => $email_aff,
    'id_partenaire' => $id_partenaire_aff,
    'id_upline' => $id_upline,
    'id_partenaire_is_iad' => $id_partenaire_is_iad,
    'parrain_is_iad' => $parrain_is_iad,
    'id_parrain_2_is_iad' => $id_parrain_2_is_iad,
    'name_parrain' => $name_parrain,
    'email_parrain' => $email_parrain,
    'tel_parrain' => $tel_parrain,
    'phone_number' => $phone_number,
    'address' => $address,
    'zip_code' => $zip_code,
    'city' => $city,
    'birth_date' => $birth_date,
    'birth_place' => $birth_place,
    'nationality' => utf8_encode($nationality),
    'id_securite_sociale' => $id_securite_sociale,
    'logement_affiliate' => $logement_affiliate,
    'statut_logement' => $statut_logement,
    'photo_profil' => $photo_profil,
    'nb_filleul_total' => $nb_filleul_total,
    'nb_affiliate_level_1' => $nb_affiliate_level_1,
    'nb_reco_level_1' => $result_1_2,
	'nb_reco_total' => $nb_reco_total,
    'nb_reco' => $nb_reco,
    'gain_potentiel' => $gain_potentiel,
    'commission_a_encaisser' => $commission_a_encaisser,
	'id_partenaire_du_parrain_1' => $id_partenaire_du_parrain_1,
	'service_du_parrain_1' => $service_du_parrain_1,
	'parrain_2_is_iad' => $parrain_2_is_iad,
	'id_partenaire_du_parrain_2' => $id_partenaire_du_parrain_2,
	'service_du_parrain_2' => $service_du_parrain_2,
	'lien_webinar' => $lien_webinar,
	'telephone_service_qualite' => $telephone_service_qualite,
    'nb_reco_retard' => $reco_en_retard,
	'nb_affiliate_level_2' => $nb_affiliate_level_2
	
);


echo json_encode($json);
?>