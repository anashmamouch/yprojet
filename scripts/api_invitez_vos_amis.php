<?php  
       // API INVITEZ_VOS_AMIS - CALLED BY INTRANET_INVITEZ_VOS_AMIS.PHP OU MOBILES APS
       // RETURN 1  : ERROR -  PB SESSION
       // RETURN 2  : ERROR -  MAIL VIDE      	   
       // RETURN 3  : ERROR -  FORMAT MAIL INVALIDE
       // RETURN 4  : ERROR -  CE MAIL EST DÉJÀ CHEZ NOSREZO	   
       // RETURN 10 : OK    -  MAIL INVITATION ENVOYÉE AU MAIL 	
	   

        session_start ();             // ON OUVRE LA SESSION EN COURS        
        require('functions.php');     // ON DÉFINI LES FUNCTIONS             
        include('config.php');        // ON SE CONNECTE A LA BASE DE DONNÉE 
        include('config_PDO.php');
	    List ($connection_database2, $connection_ok2 , $message_erreur2 )= PDO_CONNECT("", "", "");		

     IF($_SESSION['id_affiliate'] == 0)
          {
     		echo '1'; // PB SESSION
     	 }
     ELSE             // LA SESSION EST OK
         {    	 
          IF (!isset($_POST['email_to_send']))  
     	         { 
     		          echo '2'; // MAIL VIDE 
                 }
          ELSE        //LES DONNÉES NE SONT PAS VIDE 
		        {
			      $_POST['email_to_send']  = mysql_real_escape_string(stripslashes(trim($_POST['email_to_send'])));
				  IF (!preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email_to_send'])) 
     	                 { 
     		                  echo '3'; // PB FORMAT 
                         }
				  ELSE   {
					  
                          IF (CHECK_IF_AFFILIATE_ALREADY_EXIST( $connection_database2, $_POST['email_to_send'] )  >= 1 )  
     	                         { 
     		                          echo '4'; // CE MAIL EST DÉJÀ CHEZ NOSREZO 
                                 }
                          ELSE
     	                         { 
						              include('email/email_invitez_vos_amis_1.php'); 
						              SEND_EMAIL_INVITEZ_VOS_CONTACTS($connection_database2, $_SESSION['id_affiliate'], $_POST['email_to_send']);
	                                  INSERT_LOG_TRACK_ACTIONS($_SESSION['id_affiliate'], $_POST['email_to_send'], 'Invitation', 'Intranet_invitez_vos_amis.php','Mail');
     		                          echo '10'; // CE MAIL EST DÉJÀ CHEZ NOSREZO 
                                 }							  

				         }

                }
     	}
	 
 
?>