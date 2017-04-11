<?php  /// PLANNIFICATEUR DE TACHE N°1
       /// FREQUENCE : TOUS LES JOURS A 3H DU MATIN 
	   /// crontab -l lister les tâches CRON
	   /// crontab -e    PUIS ENTER et i
	   /// 30 3 * * * /usr/bin/php /kunden/homepages/0/d492946058/htdocs/scripts/cron/1_cron_nuit.php
	   /// Press the Esc key and type :x and press ENTER to exit and save changes.

       /// LE SCRIPT SE LANCE À 3H33 DU MATIN 	   
		   
		 $NosRezo_scripts          = dirname(dirname(__FILE__));
		 $NosRezo_racine           = dirname($NosRezo_scripts);	   
		 require($NosRezo_scripts.'/config.php');                       
         require($NosRezo_scripts.'/functions.php');
         require($NosRezo_scripts.'/function_12345678910.php');
		 $src_banniere  = "<img style='border-radius:0px;' src='http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG'  > ";
         $src_carre     = "<img style='border-radius:0px;' src='http://www.nosrezo.com/fichiers/carre_bleu3.PNG'            > ";

         $rapport_Load  = "";
		 $log_rapport   = "";
		 $date_debut    = strtotime(date('Y-m-d H:i:s',time()));
		 $retour1       = "<br/>"; 
		 $retour2       = "<br/><br/>";     	     
		 $retour3       = "<br/><br/><br/>";
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 1. REPORTING
         $log_rapport     = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - REPORTING JOUR ".$retour1;
		 $rapport_class   = "";		 
		 $date_reporting  = date('Y-m-d H:i:s',time()-1*24*3600);
		 List ($nb_affiliate_total, $nb_affiliate_parrain_is_iad, $nb_affiliate_parrain_is_iad_portugal, $nb_recommandation, $nb_recommandation_immo  ) = CALCUL_PRODUCTION_JOUR($date_reporting);
		 $rapport_class   = $rapport_class." &nbsp &nbsp ".$src_carre." <u> NEW RECOMMANDATIONS </u> : ". $nb_recommandation.$retour1;
		 $rapport_class   = $rapport_class." &nbsp &nbsp &nbsp &nbsp ".$src_carre." RECOS IMMO : ". $nb_recommandation_immo.$retour1;
		 $rapport_class   = $rapport_class." &nbsp &nbsp ".$src_carre." <u> NEW AFFILIATE </u> : ". $nb_affiliate_total.$retour1;
		 $rapport_class   = $rapport_class." &nbsp &nbsp &nbsp &nbsp ".$src_carre." AFF. PARRAIN IS IAD FRANCE : ". $nb_affiliate_parrain_is_iad.$retour1;
		 $rapport_class   = $rapport_class." &nbsp &nbsp &nbsp &nbsp ".$src_carre." AFF. PARRAIN IS IAD PORTUGAL : ". $nb_affiliate_parrain_is_iad_portugal.$retour1;
		 $log_rapport    = $log_rapport." ".$rapport_class.$retour1;

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 2. ENVOI DES FACTURES AUX PARTENAIRES	  
         $log_rapport   = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - FACTURES PART  ".$retour1;
		 $rapport_Load  = SEND_FACTURE_QUI_SONT_PRETES(0, $NosRezo_racine, $serveur);
         $log_rapport   = $log_rapport." ".$rapport_Load.$retour1;
		 
		 //mail('benjamin.allais@gmail.com','Envoi de 1_cron_nuit.php - 3. ENVOI DES FACTURES AUX PARTENAIRES',phpversion());
		 	
			
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 3. MISE A JOUR DES TABLEAUX DE BORDS  
         $log_rapport    = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - MISE A JOUR TDB  ".$retour1;
		 $rapport_class  = "";
		 $rapport_class  = UPDATE_REPORTING_NIVEAU_1(0);	
		 $log_rapport    = $log_rapport." ".$rapport_class.$retour1;		 

		 //mail('benjamin.allais@gmail.com','Envoi de 1_cron_nuit.php 5. MISE A JOUR DES TABLEAUX DE BORDS ',phpversion());
		 
		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 4. CLASSEMENT DES AFFILIÉS TOP RECOMMANDATIONS ET TOP AFFILIÉS NIVEAU 1	  
         $log_rapport    = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - CLASSEMENT TOP AFFILIES  ".$retour1;
		 $rapport_class  = ">> OK";
		 //$rapport_class  = UPDATE_REPORTING_AFFILIATE_1(0);
		 $log_rapport    = $log_rapport." ".$rapport_class.$retour2;

		 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// 5. INTRANET_CHALLENGE_SUMMER_2015.php	  
        // $log_rapport    = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - CHALLENGE_SUMMER_2015 ".$retour1;
		// $rapport_class  = "";
		// MISE_A_JOUR_CHALLENGE_SUMMER_2015($NosRezo_racine);
		// $log_rapport    = $log_rapport." ".$rapport_class.$retour1;

		
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////  5. IS_PROTECTED CRON  
         $log_rapport    = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - RELANCE EMAILS AFFILIÉS ".$retour1;
		 $rapport_class  = "";
		 $id_affiliate   = 32400; 
		 $rapport_class  = EMAILING_RELANCE_AFFILIATE_AVANT_DESACTIVATION( $NosRezo_racine, $serveur, $id_affiliate, "" );
		 $rapport_class  = str_replace("\"", "", $rapport_class);
		 $log_rapport    = $log_rapport." ".$rapport_class.$retour1;	
		 
		 //mail('benjamin.allais@gmail.com', 'Envoi de 1_cron_nuit.php IS_PROTECTED' , $log_rapport );	
		 
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// X. FIN DU SCRIPT 	  
         $log_rapport    = $log_rapport.$src_carre." ".date('H:i',time()+3600)." - FIN DU SCRIPT  ".$retour1;
         $date_fin       = strtotime(date('Y-m-d H:i:s',time()));
         $diff           = ($date_fin - $date_debut); 
         $secondes       = $diff % 60;
         $minutes        = floor( ($diff - $secondes) /60 )% 60;
		 $hours          = floor( $diff / (60*60));

		 $log_rapport    = $log_rapport." &nbsp &nbsp &nbsp &nbsp ".$src_carre." ".$hours." hr - ".$minutes." min - ".$secondes." sec.";
		 
 
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////// X. ENVOI MAIL DE RAPPORT TOUS LES SOIRS		  

$mail  = "contact@nosrezo.com";		
		 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body>
      <div style='width:auto height:auto; margin-top:0px;'  >
	    $src_banniere
     </div>
     <div style='width:auto; height:auto; margin-top:2px;   background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
RAPPORT CRON, <br />
<br />
$log_rapport <br />
</div>
<div style='width:auto; height:auto; margin-top:2px;  background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'>
L'équipe NR.<br />
<a href='www.nosrezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>

 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "REPORTING NOSREZO ";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
$header.= "Reply-to: \"NosRezo.com\" <contact@nosrezo.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
  
//========== Envoi de l'e-mail.
     IF ($serveur == 'PRODUCTION')
     {
         if(mail($mail,$sujet,$message,$header))
         {echo '';}
	 }

?>

