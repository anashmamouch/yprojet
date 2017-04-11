<?php  function RELANCE_PARTENAIRE_EMAIL($connection_database2, $id_recommandation, $id_affiliate, $serveur)
{

	 // REQUETTE DE REMPLISSAGE DU MAIL 
         $sql     = "SELECT r_creation_date, id_recommandation, id_affiliate, r_sub_category, r_sub_category_code,  r_first_name, r_last_name,  id_privileged_partner, r_type, r_address, r_zip_code, r_city, r_phone_number, r_email, r_connection_with, r_commentary 
		            FROM recommandation_details where id_recommandation=".$id_recommandation." limit 0,1   ";               
		 $result  = mysql_query($sql) or die("Requete pas comprise #12");
		 $reponse = mysql_fetch_array($result);

         $r_sub_category         = $reponse['r_sub_category'];
	     $id_privileged_partner  = $reponse['id_privileged_partner'];
		 $r_last_name            = $reponse['r_last_name'];
		 $r_first_name           = $reponse['r_first_name'];
		 $r_city                 = $reponse['r_city'];
		 $r_zip_code             = $reponse['r_zip_code'];
		 $r_address              = $reponse['r_address'];
		 $r_type                 = $reponse['r_type'];
		 $r_phone_number         = $reponse['r_phone_number'];
		 $r_email                = $reponse['r_email'];
		 
         $id_affiliate           = $reponse['id_affiliate'];		 
		 $r_connection_with      = $reponse['r_connection_with'];
		 $r_commentary           = $reponse['r_commentary'];

		 $reponse2       = mysql_fetch_array(mysql_query("SELECT email, first_name, last_name, zip_code, city FROM affiliate_details where id_affiliate =".$id_affiliate."  limit 0,1   ")) or die("Requete pas comprise - #CCCCC32! ");
	     $a_first_name   = $reponse2['first_name'];
		 $a_last_name    = $reponse2['last_name'];
		 $a_city         = $reponse2['city'];
		 $zip_code       = $reponse2['zip_code'];
		 $mail           = $reponse2['email'];
		 //$mail           ="benjamin.allais@gmail.com";

		 $reponse10 = mysql_fetch_array(mysql_query("SELECT count(id_affiliate) as countifexist, id_affiliate, password FROM affiliate where id_affiliate =".$id_affiliate."   ")) or die("Requete pas comprise - #R323AARFT: TEST !");
		 $mdp       = $reponse10['password'];

		 
		 if  ($id_privileged_partner == 0) // PAS DE PARTENAIRE CAR RECOMMANDATION ANNULEE AVANT
		     {$name_id_privileged_partner  = "Aucun partenaire sélectionné par NosRezo";}
		 else	 
		     {$reponse3 = mysql_fetch_array(mysql_query("SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact , p_contact_mail FROM partner_list where id_partner =".$id_privileged_partner."  limit 0,1   ")) or die("Requete pas comprise - #33-2! ");
		     $name_id_privileged_partner  = $reponse3['p_contact'];}

	 	 
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "script PHP.";
$message_html = "
<html><head></head><body style='background-color:#5179be;'>
      <div style='width:auto height:auto; margin-top:0px; border-color:#e7e8e9; border-radius: 5px;' >
	    <img style='border-radius:4px;' src=$src >	
     </div>
     <div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Bonjour $a_first_name, <br />                               
<br />
Votre recommandation d'affaire est  <font color=#fa38a3><b> FINALISÉE </b></font> et vous n'avez pas toujours pas noté le partenaire.  <br />
     <img src=$src_carre> <u>Partenaire en charge du service</u> :  <b> $name_id_privileged_partner </b> <br /><br />
Merci pour votre retour sur ce dernier.
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Ci-après le détail de votre recommandation : <br />
     <img src=$src_carre> <u>Projet du contact </u> :  <b> $r_sub_category / $r_type </b> <br />
     <img src=$src_carre> <u>Contact </u> :  <font color=#fa38a3><b> $r_first_name  $r_last_name </b></font>  <br />
     <img src=$src_carre> <u>Adresse du contact </u> : <b>  $r_address  </b> <br />
     <img src=$src_carre> <u>Ville du contact </u> : <b>  $r_zip_code $r_city </b> <br />
     <img src=$src_carre> <u>Dossier </u> : <b>  $id_recommandation </b> <br />
     <img src=$src_carre> <u>Coordonnées du contact </u> : <b>  $r_phone_number   </b> <br />
     <img src=$src_carre> <u>Commentaire </u> : <b>  $r_commentary </b> <br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Pour rappel : <br />
     <img src=$src_carre>  <u>Votre identifiant </u>: <font color=#fa38a3><b>$id_affiliate</b></font><br />
     <img src=$src_carre>  <u>Votre mot de passe </u>: <b>$mdp</b>  
<br />
<a href='http://www.nosrezo.com/login.php?id_affiliate=$id_affiliate&amp;token=$mdp' > Cliquez ici pour vous connecter directement.</a>
<br />
</p>
</div>
<div style='width:auto; height:auto; margin-top:2px; border-style: solid; border-color:#2375b0; border-radius:4px; border-width:1px; background-color:#FFFFFF;' >
<p style='font-size:10px; margin-top:10px; margin-left:5px;'> 
Nous vous souhaitons de belles opportunités d'affaires grâce à nos services.<br />
<br />
L'équipe NosRezo<br />
<a href='www.NosRezo.com' target='_blank'><b>www.NosRezo.com</b></a><br />
</p>
</div>
<br />


 </body></html>";
//==========
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = "Noter votre partenaire NosRezo !";
//=========
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
//$header.= "Cc: contact@nosrezo.com ".$passage_ligne;
$header.= "Cc: karim@nosrezo.com ".$passage_ligne;
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
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>