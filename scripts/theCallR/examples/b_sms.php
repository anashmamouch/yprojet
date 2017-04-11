<?php
require('../src/ThecallrClient.php');

$thecallrLogin = 'nosrezo';
$thecallrPassword = '6KdQecqoar';
$THECALLR = new ThecallrClient($thecallrLogin, $thecallrPassword);

try {
	
	// Sender
	$sender = "THECALLR";
	// Recipient phone number (E.164 format)
	$to = "+33608508812";
	// SMS text
	$text = "This is my first SMS with THECALLR API :)";
	// Options
	$options = new stdClass();
	$options->flash_message = FALSE;
	
	// "sms.send" method execution
	$result = $THECALLR->call('sms.send',$sender,$to,$text,$options);
	
	// The method returns the SMS ID
	//echo 'SMS ID : ' . $result . '<br />';
	
} catch (Exception $error) {
	die($error->getMessage());
}

?>