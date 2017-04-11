<?php   require('functions.php'); 

// On démarre la session
     session_start ();  
//   insert_log_track_actions($_SESSION['id_affiliate'],$_SESSION['first_name'], 'deconnection', 'deconnection.php','-');

 
// On détruit les variables de notre session
     session_unset ();  
 
// On détruit notre session
     session_destroy ();  
 
// On redirige le visiteur vers la page d'accueil
     echo '<meta http-equiv="refresh" content="0;URL=../../index.php">';
 
?>