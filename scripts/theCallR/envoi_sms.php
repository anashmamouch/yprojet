<?php  function SEND_SMS_RELANCE_PARTENAIRE_1($num_tel, $text_a_envoyer)
{
             //require('scripts/theCallR/envoi_sms.php');
			 //send_sms_1(1, "0608508812", 1);
			 //send_sms_1(1, "0686495254", 1);
     //IF ($categorie_text = 1)

     
	 //echo $num_tel."<br/>";
	// $text_a_envoyer = stripslashes($text_a_envoyer);
	// $text_a_envoyer = addslashes($text_a_envoyer);
	 
     $on_envoi_sms   = 0;
	 $mobile         = substr($num_tel, 0, 2); 
	 
	 IF (($mobile = "06") OR ($mobile = "07")) 
	     {  
		     $num_tel      = "+33".substr($num_tel, 1, 10);
             $on_envoi_sms = 1; 
	         //echo $num_tel."<br/>";
		 }
	 
 	    
     IF ($on_envoi_sms == 1)
	 {
     
     require('src/ThecallrClient.php');
     $thecallrLogin    = 'nosrezo';
     $thecallrPassword = 'Up5neaT6cU';
     $THECALLR = new ThecallrClient($thecallrLogin, $thecallrPassword);

     try {	
	         // Sender
	         $sender = "NosRezo";
	         // Recipient phone number (E.164 format)
	         $to = $num_tel;
	         // SMS text
	         $text = $text_a_envoyer;
	         // Options
	         $options = new stdClass();
	         $options->flash_message = FALSE;
	
	         // "sms.send" method execution
	         $result = $THECALLR->call('sms.send',$sender,$to,$text,$options);
	
	         // The method returns the SMS ID
	         //echo 'SMS ID : ' . $result . '<br />';
	
          } catch (Exception $error) 
		 {
	         die($error->getMessage());
         }
     }
	
}
?>