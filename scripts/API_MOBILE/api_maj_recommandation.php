<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

session_start();                                            // ON OUVRE LA SESSION EN COURS
include('../config.php');                                   // ON SE CONNECTE A LA BASE DE DONNÉE 	 
require('../functions.php');
require('../function_12345678910.php');                     // ON DÉFINI LES FUNCTIONS 
//require('../config_PDO.php');                               // ON SE CONNECTE A LA BASE DE DONNÉE 	

$postdata = file_get_contents("php://input");   // RÉCUPÉRATION DU JSON
$request = json_decode($postdata);              // DÉCODAGE DU JSON EN ARRAY

$id_recommandation = $request->id_recommandation;
$etape_reco = $request->etape_reco;
$delai_relance = $request->delai_relance;
$montant_honoraires = $request->montant_honoraires;
$description = $request->description;
$id_iad_transaction = $request->id_iad_transaction;

$montant_tva_facture = 20;

$description = stripslashes($description);
$description = addslashes($description);

List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");


if ($etape_reco != "" && $delai_relance != "") {

    /*     * ******************************************************************************************************************* */
//ini_set('display_errors','off');
    $sql = " SELECT r_creation_date, id_recommandation, r_status, id_affiliate, r_category, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary, r_devis_ttc, montant_tva_percent, id_iad_transaction, r_lat, r_long  
	 FROM recommandation_details 
	 where id_recommandation = " . $id_recommandation . " ";

    mysql_query('SET NAMES utf8');
    $result = mysql_query($sql) or die(" Module en maintenance pour 10 minutes ");
    $reponse = mysql_fetch_array($result);
    if ($reponse) {
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

// Messages de retour
        $msg_info = "VOTRE ACTION EST PRISE EN COMPTE.";
        $msg_success = "";
        $msg_success2 = "";
        $msg_danger = "";
        $msg_danger2 = "";
        ?>	


        <?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////// MODULE DE RÉALISATION DES ACTIONS DU MEME SCRIPT					  ///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
        $ERROR_CODE = 0;
        $STOP = 0;

        IF (is_num($montant_honoraires) == 0) {
            $ERROR_CODE = 3;
            $montant_honoraires = 0;
        } ELSE IF ($montant_honoraires > 0) 
		{   // MODULE DE COHERENCE DU PRIX DU MANDAT OU DU DEVIS                                          
            IF ( $r_sub_category_code == 8 and $montant_honoraires <> 600) // RECRUTEMENT IMMO
			{

                $msg_success = "Pour un recrutement immobilier, la commission NosRezo est de 600 € TTC  et non " . $montant_honoraires . " €";

                $montant_honoraires = 600;
            } 
			ELSE IF ( $r_sub_category_code == 56 and $montant_honoraires <> 1500) // RECRUTEMENT EXPERT COMPTABLE
			{

                $msg_success = "Pour un recrutement expert comptable, la commission NosRezo est de 1500 € TTC et non " . $montant_honoraires . " €";

                $montant_honoraires = 600;
            } ELSE IF ($reponse["r_category"] == "immobilier") {
                IF ($r_sub_category_code == 1) {                             // MISE EN VENTE DE BIEN
                    IF (($montant_honoraires > 310000) or ( $montant_honoraires < 500)) {

                        $msg_success = "Les honoraires du mandat de vente semblent incohérents. La moyenne nationale est 10 000€ TTC de commission et non $montant_honoraires €. Merci de mettre à jour cette information avant de valider à nouveau.";
                        $montant_honoraires = 0;
                    }
                } ELSE IF ($r_sub_category_code == 4) {
                    IF (($montant_honoraires > 3000000) or ( $montant_honoraires < 10000)) {

                        $msg_success = "Le montant emprunté semble incohérent. La moyenne nationale est 140 000€ TTC et non $montant_honoraires €. Merci de mettre à jour cette information avant de valider à nouveau.";
                        $montant_honoraires = 140000;
                    }
                }
            } ELSE IF ($reponse["r_category"] == "travaux") {
                IF (($montant_honoraires > 200000) or ( $montant_honoraires < 10)) {

                    $msg_success = "Le montant emprunté semble incohérent. La moyenne nationale est 2 000€ TTC et non €. Merci de mettre à jour cette information avant de valider à nouveau.";
                    $montant_honoraires = 0;
                }
            }
        }

        IF ($etape_reco == -1) {
            $ERROR_CODE = 1;
        } ELSE IF ($etape_reco >= 5 AND $etape_reco <= 7 AND $montant_honoraires == 0) {
            $ERROR_CODE = 3;
            $msg_danger = "MERCI DE METTRE À JOUR LE MONTANT DES HONORAIRES TTC";
        } ELSE IF ($etape_reco >= 0 AND $ERROR_CODE == 0) {      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////     UNE ACTION EST À RÉALISER                                   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////     CES ACTIONS SONT GÉRÉES DE FACON AUTOMATIQUE PAR LE PARTENAIRE : 11_2.php     /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            IF (trim($id_iad_transaction) > 100) {  // MISE A JOUR DE L'IDENTIFIANT DE TRANSACTION IAD FRANCE
                UPDATE_RECOMMANDATION_DETAILS_FIELD($id_recommandation, "id_iad_transaction", trim($id_iad_transaction));
            }

            IF ($etape_reco == 0) {
                $etape_realisee_text = "0 - " . "Contact non intéressé par nos services";
                /// 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                /// 2. MISE A JOUR DE LA TABLE DES ACTIONS
                update_action_list_statut_recommandation($id_recommandation, 'FERME', " - ", "Action réalisée directement par le partenaire.");
                insert_action_list("Étape 0", 50, "Contact non intéressé par nos services. ", $id_recommandation, $id_privileged_partner, $id_affiliate, "FERME", action_list_return_details($id_recommandation), "Recommandation annulée par le partenaire", "PARTENAIRE", $delai_relance, "");
                /// 3. ENVOYER MAIL A L'AFFILIE
                send_email_affilie_statut($connection_database2, $id_recommandation, 50, $description);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 41) {
                $etape_reco = 0;
                $etape_realisee_text = "0 - " . "Vendu par la concurrence";
                /// 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                /// 2. MISE A JOUR DE LA TABLE DES ACTIONS
                update_action_list_statut_recommandation($id_recommandation, 'FERME', " - ", "Action réalisée directement par le partenaire.");
                insert_action_list("Étape 0", 50, "Contact non intéressé par nos services. La vente est déjà réalisée par un concurrent.", $id_recommandation, $id_privileged_partner, $id_affiliate, "FERME", action_list_return_details($id_recommandation), "Recommandation annulée par le partenaire", "PARTENAIRE", $delai_relance, "");
                /// 3. ENVOYER MAIL A L'AFFILIE
                send_email_affilie_statut($connection_database2, $id_recommandation, 50, $description);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 4) {
                $etape_realisee_text = "4 - RDV planifié";
                $action_id_category = 14;
                /// 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                /// 2. MISE A JOUR DE LA TABLE DES ACTIONS
                $statut_mail = statut_fonction_etape_et_service($etape_reco, $reponse["r_category"], "PARTENAIRE", $r_sub_category_code);


                update_action_list_statut_recommandation($id_recommandation, 'FERME', $statut_mail, "Action réalisée automatiquement par le partenaire.");
                insert_action_list("Étape 4", $action_id_category, $statut_mail, $id_recommandation, $id_privileged_partner, $id_affiliate, "OUVERT", action_list_return_details($id_recommandation), "Création automatique par le partenaire.", "PARTENAIRE", $delai_relance, "");
                /// 3. ENVOYER MAIL A L'AFFILIE
                send_email_affilie_statut($connection_database2, $id_recommandation, $action_id_category, $description);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 5) {
                $etape_realisee_text = "5 - Devis/Mandat envoyé au contact";
                $action_id_category = 15;

                // 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                // 2. MISE A JOUR DE LA TABLE DES ACTIONS
                $statut_mail = statut_fonction_etape_et_service($etape_reco, $reponse["r_category"], "PARTENAIRE", $r_sub_category_code);

                update_action_list_statut_recommandation($id_recommandation, 'FERME', $statut_mail, "Action réalisée automatiquement par le partenaire.");
                insert_action_list("Étape 5", $action_id_category, $statut_mail, $id_recommandation, $id_privileged_partner, $id_affiliate, "OUVERT", action_list_return_details($id_recommandation), "Création automatique par le partenaire", "PARTENAIRE", $delai_relance, "");
                // 3. ENVOYER MAIL A L'AFFILIE							
                send_email_affilie_statut($connection_database2, $id_recommandation, $action_id_category, $description);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 6) {
                $etape_realisee_text = "6 - Devis validé par le contact ";
                $action_id_category = 16;
                // 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                // 2. MISE A JOUR DE LA TABLE DES ACTIONS
                $statut_mail = statut_fonction_etape_et_service($etape_reco, $reponse["r_category"], "PARTENAIRE", $r_sub_category_code);

                update_action_list_statut_recommandation($id_recommandation, 'FERME', $statut_mail, "Action réalisée automatiquement par le partenaire.");
                insert_action_list("Étape 6", $action_id_category, $statut_mail, $id_recommandation, $id_privileged_partner, $id_affiliate, "OUVERT", action_list_return_details($id_recommandation), "Création automatique par le partenaire", "PARTENAIRE", $delai_relance, "");
                // 3. ENVOYER MAIL A L'AFFILIE							
                send_email_affilie_statut($connection_database2, $id_recommandation, $action_id_category, $description);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 7) {
                $etape_realisee_text = "7 - Vente réalisée";
                $action_id_category = 20;
                // 1. MISE A JOUR DES INFORMATIONS DE RECOMMANDATIONS
                update_info_recommandation_details_statuts($id_recommandation, $etape_reco);
                // 2. MISE A JOUR DE LA TABLE DES ACTIONS
                $statut_mail = statut_fonction_etape_et_service($etape_reco, $reponse["r_category"], "PARTENAIRE", $r_sub_category_code);

                update_action_list_statut_recommandation($id_recommandation, 'FERME', $statut_mail, "Action réalisée automatiquement par le partenaire.");
                insert_action_list("Étape 7.1", $action_id_category, $statut_mail, $id_recommandation, $id_privileged_partner, $id_affiliate, "OUVERT", action_list_return_details($id_recommandation), "Création automatique par le partenaire", "PARTENAIRE", $delai_relance, "");
                // 3. ENVOYER MAIL A L'AFFILIE							
                send_email_affilie_statut($connection_database2, $id_recommandation, $action_id_category, $description);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 8) {
                $etape_realisee_text = "8 - Virement envoyé à NosRezo";
                $action_id_category = 22;

                // 1. VERIFIONS QUE LA FACTURE A ETE GENEREE CAR SINON : IMPOSSIBLE DE PAYER	
                IF (check_if_facture_generated($id_recommandation) == 0) {
                    $msg_success2 = "Vous ne pouvez pas réaliser de virement pour l'instant car la facture n'a pas été envoyée. Vous allez recevoir la facture par mail dans les prochaines heures.";
                } ELSE {
                    // 2. MISE A JOUR DE LA TABLE DES ACTIONS
                    $statut_mail = statut_fonction_etape_et_service($etape_reco, $reponse["r_category"], "PARTENAIRE", $r_sub_category_code);

                    update_action_list_statut_recommandation($id_recommandation, 'FERME', $statut_mail, "Action réalisée automatiquement par le partenaire.");
                    insert_action_list("Étape 7.3", $action_id_category, $statut_mail, $id_recommandation, $id_privileged_partner, $id_affiliate, "OUVERT", action_list_return_details($id_recommandation), "Création automatique par le partenaire", "PARTENAIRE", $delai_relance, "");
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF (($etape_reco == 33) OR ( $etape_reco == 35)) {
                mysql_query('SET NAMES utf8');
                $result = mysql_fetch_array(mysql_query("SELECT CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_contact_phone, p_contact_mail FROM partner_list where id_partner =" . $id_privileged_partner . "   ")) or die("Requete pas comprise - #3BGA0912! ");
                $p_contact = $result['p_contact'];
                $p_contact_phone = $result['p_contact_phone'];
                $p_contact_mail = $result['p_contact_mail'];

                IF ($etape_reco == 33) {
                    $etape_realisee_text = "Contact non joignable pour le moment. Nous avons laissé un message sur son répondeur. 
						                                 Nous retenterons de le joindre très prochainement. Merci d'avance de revenir vers nous si vous avez des retours au " . $p_contact_phone . "ou par mail à" . $p_contact_mail . ". " . $description;
                    $action_id_category = 33;
                } ELSE {
                    $etape_realisee_text = "Dossier actuellement en cours. N'hésitez pas à revenir vers nous si vous avez des compléments d'informations au " . $p_contact_phone . " ou par mail à " . $p_contact_mail . ". " . $description;
                    $action_id_category = 35;
                }

                // 1. ON COPIE LA DERNIERE ACTION X EN Y ET ON FERME X [A PARTIR DE ID_ACTION] POUR HISTORIQUE							 
                $id_action = last_id_action_from_action_list($connection_database2, $id_recommandation);
                insert_action_list_duplicate($id_action, $delai_relance, 0, "PARTENAIRE", $etape_realisee_text);
                update_action_list_que_statut($connection_database2, $id_action, "FERME");
                // 2. ENVOYER MAIL A L'AFFILIE							
                send_email_affilie_statut($connection_database2, $id_recommandation, 0, $etape_realisee_text);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ELSE IF ($etape_reco == 36) {
                $etape_realisee_text = "Projet trop tôt" . " - " . "A réaliser dans le futur." . $description;

                // 1. ON COPIE LA DERNIERE ACTION X EN Y ET ON FERME X [A PARTIR DE ID_ACTION] POUR HISTORIQUE							 
                $id_action = last_id_action_from_action_list($connection_database2, $id_recommandation);
                insert_action_list_duplicate($id_action, $delai_relance, 0, "PARTENAIRE", $etape_realisee_text);
                update_action_list_que_statut($connection_database2, $id_action, "FERME");
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 			        
            ELSE IF ($etape_reco == 40) {
                IF (strlen($description) < 50) {
                    $STOP = 1;
                    $msg_danger2 = "MSG DANGER: MERCI DE PRÉCISER D'AVANTAGE LA RAISON POUR QUE NOUS PUISSIONS AU MIEUX RÉATTRIBUER CETTE RECOMMANDATION";
                } ELSE {
                    $etape_realisee_text = " - " . "Le partenaire ne peut traiter cette recommandation. Pourquoi :" . $description;

                    // 1. ON COPIE LA DERNIERE ACTION X EN Y ET ON FERME X [A PARTIR DE ID_ACTION] POUR HISTORIQUE							 
                    $id_action = last_id_action_from_action_list($connection_database2, $id_recommandation);
                    insert_action_list_duplicate_refuse_partenaire($connection_database2, $id_action, 0, 0, $etape_realisee_text);   // ON REMET AU STATUT 2
                    update_action_list_que_statut($connection_database2, $id_action, "FERME");                                        // ON FERME L'ANCIENNE ACTION
                    insert_into_recommandation_refuse_partenaire($connection_database2, $id_recommandation, $_SESSION['id_partenaire'], $id_affiliate, "", "");
                    UPDATE_STATUS_RECOMMANDATION_DETAILS($connection_database2, $id_recommandation, 2);
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

            IF ($STOP == 0) {
                //CALCUL DU MONTANT DE LA COMMISSION A APPLIQUER AU MLM	 
                $commission_mlm = CALCUL_COMMISSION_MLM($connection_database2, $id_recommandation, $r_sub_category_code, $montant_honoraires, $montant_tva_facture, "UNIQUEMENT_MLM", 0);

                INSERT_ACTION_SUIVI_PARTENAIRE(0, $delai_relance, $etape_reco, 0, addslashes($etape_realisee_text), $description, $id_recommandation, $id_privileged_partner, $reponse["id_affiliate"], $montant_honoraires, $montant_tva_facture);
                UPDATE_DEVIS_RECOMMANDATION_DETAILS($id_recommandation, $montant_honoraires, $montant_tva_facture, $commission_mlm, $r_sub_category_code);
            }
        }


        /*         * ******************************************************************************************************************* */


        $json[] = array('msg_info' => $msg_info, 'msg_success' => $msg_success, 'msg_success2' => $msg_success2, 'msg_danger' => $msg_danger, 'msg_danger2' => $msg_danger2);
        echo json_encode($json);
    } else {
        $json[] = array('msg_info' => '', 'msg_success' => '', 'msg_success2' => '', 'msg_danger' => '', 'msg_danger2' => '');

        echo json_encode($json);
    }
}
?>