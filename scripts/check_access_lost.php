<?php   require('functions.php');
        include('config.php'); 
	    include('config_PDO.php');
	    List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");	


        $email = trim(mysql_real_escape_string($_POST['email']));
		$email = strtolower($email);
		
	if ($email <> "")
	{
 		$req  = mysql_query(' select aa.id_affiliate AS id_affiliate, lower(email) as email 
		                      FROM affiliate_details ad, affiliate aa 
							  WHERE ad.id_affiliate = aa.id_affiliate 
							  AND aa.is_activated = 1 
							  AND email= "'.$email.'"   ');
		$dn   = mysql_fetch_array($req);
		mysql_query('SET NAMES utf8');
		//On le compare a celui qu il a entré et on verifie si le membre existe
				
		IF(trim($dn['email'])== $email and mysql_num_rows($req)>0)
		     { 
             insert_action_list("Send MDP oublié", 6, $email, 0,0,$dn['id_affiliate'], "FERME", " Email : [ ".$email." ]" ,"", "Service Admin", 0, "");
 			 send_password($dn['email'], "OUBLIE");
    		 echo '<body onLoad="alert(\'Votre email est reconnu, vous allez recevoir votre nouveau mot de passe : Pensez aux spams !.\')">'; 	
             echo '<meta http-equiv="refresh" content="0; URL=../index.php ">'; 			
			 }
		ELSE
		    {
		      $req  = mysql_query(' select aa.id_affiliate AS id_affiliate, pl.p_contact_mail as email, pl.id_partner 
			                        FROM affiliate_details ad, affiliate aa, partner_list pl 
									WHERE ad.id_affiliate = aa.id_affiliate 
									AND   aa.is_activated = 1 
									AND   pl.id_partner = aa.id_partenaire 
									AND   pl.p_contact_mail = "'.$email.'"    ');			  
			  $dn   = mysql_fetch_array($req);
		      mysql_query('SET NAMES utf8');
		      //On le compare a celui qu il a entré et on verifie si le membre existe
				
		     if(trim($dn['email'])==$email and mysql_num_rows($req)>0)
		          { 
                    insert_action_list("Send MDP oublié", 6, $email, 0,0,$dn['id_affiliate'], "FERME", " Email : [ ".$email." ]" ,"", "Service Admin", 0, "");
					send_password_partenaire($dn['id_partner'], "OUBLIE");
    		        echo '<body onLoad="alert(\'Votre email est reconnu, vous allez recevoir votre nouveau mot de passe. Pensez aux spams !.\')">'; 	
                    echo '<meta http-equiv="refresh" content="0; URL=../index.php ">'; 			
			       }
             ELSE		
		           {
                      echo '<meta http-equiv="refresh" content="0; URL=../index.php ">'; 
 		  	          echo '<body onLoad="alert(\'Votre email est inconnu ou inactif ! Merci de contacter contact@nosrezo.com. \')">'; 
		           }
            }				   
    }
	 ELSE
		     {
            echo '<meta http-equiv="refresh" content="0; URL=../index.php ">'; 
 			echo '<body onLoad="alert(\'Votre email est vide !\')">'; 
		     }
			 
?>

