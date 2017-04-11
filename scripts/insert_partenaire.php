<?php   include('config.php');                   ?>
<?php   require('functions.php');                ?>
<?php   require('function_12345678910.php');     ?> 
<?php   if(!isset($_SESSION)){session_start();}  

//ON VÉRIFIE QUE LE FORMULAIRE A ETE ENVOYÉ ET QUE LES DONNÉES SONT VALIDES
			 
			 include('config_PDO.php');
	         List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");

     $ERROR_FORMULAIRE = 0;
	 $_POST['cgu_checked'] = "ok";
     $_POST['email']       = mysql_real_escape_string(stripslashes($_POST['email']));
	 $_POST['mobile']      = trim($_POST['mobile']);

          if (empty($_POST['cgu_checked']))                                                           { $ERROR_FORMULAIRE = 1; $_POST['cgu_checked'] = "ko"; }
     else if (empty($_POST['nom_entreprise']))                                                        { $ERROR_FORMULAIRE = 2; }
     else if (empty($_POST['nom']))         	                                                      { $ERROR_FORMULAIRE = 3; }
     else if (empty($_POST['prenom']))                                                                { $ERROR_FORMULAIRE = 4; }
     else if (empty($_POST['fonction']))                                                              { $ERROR_FORMULAIRE = 5; }
     else if (empty($_POST['cp']))                                                                    { $ERROR_FORMULAIRE = 7; }
     else if (is_num($_POST['cp']) == 0)                                                              { $ERROR_FORMULAIRE = 8; }
     else if (strlen($_POST['cp']) < 4)                                                               { $ERROR_FORMULAIRE = 9; }
     else if (empty($_POST['ville']))                                                                 { $ERROR_FORMULAIRE = 10; }	
     else if (empty($_POST['mobile']))                                                                { $ERROR_FORMULAIRE = 11; }
     else if (is_num($_POST['mobile']) == 0)                                                          { $ERROR_FORMULAIRE = 12; }
     else if (strlen($_POST['mobile']) < 6)                                                           { $ERROR_FORMULAIRE = 13; }	 
     else if (empty($_POST['why_recommand']))                                                         { $ERROR_FORMULAIRE = 14; }
     else if (CHECK_IF_PARTNER_ALREADY_EXIST($connection_database2, $_POST['email']) > 0)             { $ERROR_FORMULAIRE = 16; }
	 else if (CHECK_IF_PARTNER_ALREADY_EXIST_PHONE($connection_database2, $_POST['mobile']) > 0)      { $ERROR_FORMULAIRE = 20; } 
 
	 	 
IF ($ERROR_FORMULAIRE > 0 ) 
   {
    	echo '<form name="p_action2"  action="../Intranet_Nouveau_partenaire.php" method="post">  ';
        echo '<input type="hidden" name="s_category"             value = '. $_POST['s_category'].' >';
        echo '<input type="hidden" name="s_sub_category_code"    value = '. $_POST['s_sub_category_code'] .' >';
	    echo '<input type="hidden" name="cgu_checked"            value = '. $_POST['cgu_checked'] .' >';
	    echo '<input type="hidden" name="gender"                 value = '. $_POST['gender'] .' >';	
	    echo '<input type="hidden" name="error_code"             value = '. $ERROR_FORMULAIRE .'     >';
	    echo '<input type="hidden" name="nom_entreprise"         value = "'. $_POST['nom_entreprise'] .'"       >';
	    echo '<input type="hidden" name="nom"                    value = "'. trim(strtoupper($_POST['nom'])) .'"       >';	
	    echo '<input type="hidden" name="prenom"                 value = "'. trim(ucfirst($_POST['prenom'])) .'"    >';
	    echo '<input type="hidden" name="fonction"               value = "'. $_POST['fonction'] .'"    >';
	    echo '<input type="hidden" name="adresse"                value = "'. $_POST['adresse'] .'"   >';
	    echo '<input type="hidden" name="cp"                     value = "'. $_POST['cp'] .'"        >';
	    echo '<input type="hidden" name="ville"                  value = "'. $_POST['ville'] .'"     >';
	    echo '<input type="hidden" name="mobile"                 value = "'. $_POST['mobile'] .'"    >';
	    echo '<input type="hidden" name="email"                  value = "'. $_POST['email'] .'"     >';
	    echo '<input type="hidden" name="rayon_action"           value = "'. $_POST['rayon_action'] .'"     >';
	    echo '<input type="hidden" name="why_recommand"          value = "'. $_POST['why_recommand'] .'"     >';
	    echo '<input type="hidden" name="site_web"               value = "'. $_POST['site_web'] .'"     >';
	    echo '<input type="hidden" name="pays_partenaire"        value = "'. $_POST['pays_partenaire'] .'"     >';		
		
	    echo '<script language="JavaScript">document.p_action2.submit();</script></form>';
   }	
ELSE
IF (isset($_POST['nom'], $_POST['prenom'], $_SESSION['id_affiliate']))
{		//ON ENLEVE LECHAPPEMENT SI GET_MAGIC_QUOTES_GPC EST ACTIVE
		        IF(get_magic_quotes_gpc())
		        {
         		$_POST['nom_entreprise']      = stripslashes($_POST['nom_entreprise']);
			    $_POST['fonction']            = stripslashes($_POST['fonction']);
        		$_POST['nom']                 = stripslashes($_POST['nom']);
			    $_POST['prenom']              = stripslashes($_POST['prenom']);
			    $_POST['mobile']              = stripslashes($_POST['mobile']);
			    $_POST['email']               = stripslashes($_POST['email']);
			    $_POST['adresse']             = stripslashes($_POST['adresse']);			
			    $_POST['cp']                  = stripslashes($_POST['cp']);
			    $_POST['ville']               = stripslashes($_POST['ville']);	
			    $_POST['why_recommand']       = stripslashes($_POST['why_recommand']);
				$_POST['site_web']            = stripslashes($_POST['site_web']);
				}
				
				$pays_partenaire              = $_POST['pays_partenaire'];
                $s_sub_category_code          = $_POST['s_sub_category_code'];				
				$nom_entreprise               = trim(strtoupper(mysql_real_escape_string($_POST['nom_entreprise'])));				
				$fonction                     = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['fonction']))));
				$last_name                    = trim(strtoupper(mysql_real_escape_string($_POST['nom'])));
				$first_name                   = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['prenom']))));
				$mobile                       = mysql_real_escape_string($_POST['mobile']);	
				$email                        = trim(mysql_real_escape_string($_POST['email']));	
				$adresse                      = trim(mysql_real_escape_string($_POST['adresse']));
				$cp                           = mysql_real_escape_string($_POST['cp']);	
				$ville                        = mysql_real_escape_string($_POST['ville']);
				$cp_secteur                   = $cp; // LE CP_SECTEUR DU PARTENAIRE PEUT ETRE DIFFERENT DU CP DE L'ADRESSE AFFILIE
				$ville_secteur                = $ville;
				$site_web                     = mysql_real_escape_string($_POST['site_web']);
				$why_recommand                = trim(ucfirst(strtolower(mysql_real_escape_string($_POST['why_recommand']))));
				$p_rayon_level1               = 50;
				$id_partner_max               = id_partner_max_FROM_partner_list("");		
                $s_sub_category               = s_sub_category_FROM_s_sub_category_code($s_sub_category_code); 
				$com_nr_contrat_percent       = 0; // PAR DÉFAUT LA NÉGOCIATION DU CONTRAT EST A 0	
                $is_access_intranet           = 0;
				$is_activated                 = 0;
				IF ( $s_sub_category_code == 1) { $is_access_intranet = 1; $is_activated = 1;} //MISE EN VENTE IMMOBILIERE QUI SONT AUTOMATIQUEMENT ACTIVÉ
				
				
				$id_affiliate = INSERT_INTO_PARTNER_LIST_MASTER($connection_database2, $_POST['gender'], $id_partner_max, $_POST['s_category'], $s_sub_category, $s_sub_category_code, $nom_entreprise, $first_name, $last_name, $mobile, $email, $site_web, $adresse, $cp, $ville, "", "", $_POST['rayon_action'], $p_rayon_level1, "-", $fonction, $is_activated , $com_nr_contrat_percent, $_SESSION['id_affiliate'], $why_recommand, $cp_secteur, $ville_secteur, "", "", "", $is_access_intranet, "STANDARD", $serveur, $pays_partenaire );
				IF ( $id_affiliate > 0)
			    	{	
						 ///////// SI INSERTION ALORS ON AFFICHE MAIL DE CONFIRMATION	
                         $result_1       = mysql_fetch_array(mysql_query("SELECT first_name, last_name, phone_number, email, id_affiliate, zip_code, city FROM affiliate_details WHERE id_affiliate = ".$_SESSION['id_affiliate']."   ")) or die("Requete pas comprise - #VGT31! ");
				    	 $details        = "- Service : ".$s_sub_category." \n - Informations : ".$first_name." ".$last_name." ".$nom_entreprise." ".$fonction."   ".$cp." ".$ville." - ".$mobile." \n - Affilié : ".$result_1['first_name']	."  ".$result_1['last_name']."   ".$result_1['phone_number']."   ".$result_1['email']."  -  ".$result_1['zip_code']."  ".$result_1['city']."  \n \n - Pourquoi : ".$why_recommand."        ";
						 IF ( $s_sub_category_code <> 1) // DIFFERENT DE MISE EN VENTE IMMOBILIERE QUI SONT AUTOMATIQUEMENT ACTIVÉ
						 {
						     insert_action_list("Activer partenaire", 4, "Activer nouveau partenaire : [ ".$id_partner_max. " ]", 0, $id_partner_max, $id_affiliate, "OUVERT", $details ,"", "Service Admin", 2, "");
						 }
						 
						 ////////////////////////////////////////////////////////////////////////						 
						echo '<body onLoad="alert(\'Merci pour votre proposition de partenaire. Nous le contacterons en fonction des demandes sur son secteur. \')">'; 
                        echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}
					ELSE // LA CRÉATION DU PARTENAIRE A ÉCHOUÉ POUR UN PROBLÉME TECHNIQUE
					{
	              		echo '<body onLoad="alert(\'Prescription non prise en compte : merci de contacter le support (support@nosrezo.com).\')">'; 
                        echo '<meta http-equiv="refresh" content="0;URL=../Intranet_Accueil.php">'; 
					}
}
?> 
