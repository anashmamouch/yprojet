<?php include('config.php'); //On se connecte a la base de donnee ?> 
<?php require('functions.php'); ?>

<?php
//On verifie que le formulaire a ete envoye et que les données ne sont pas vide
     $ERROR_FORMULAIRE = 0;
	 $mdp                    = trim(mysql_real_escape_string($_POST['mdp']));
	 
		IF(get_magic_quotes_gpc()) { $id_affiliate  = stripslashes($_POST['id_affiliate']); }
				                     $id_affiliate  = mysql_real_escape_string($_POST['id_affiliate']);	
	 
          if (empty($_POST['mdp']))                         { $ERROR_FORMULAIRE = 1;  }
     else if (trim($_POST['mdp']) =='')                     { $ERROR_FORMULAIRE = 1;  }
     else if (empty($_POST['n_mdp']))                       { $ERROR_FORMULAIRE = 2;  }
     else if (trim($_POST['n_mdp']) =='')                   { $ERROR_FORMULAIRE = 2;  }
     else if (empty($_POST['n_mdp_conf']))                  { $ERROR_FORMULAIRE = 3;  }
     else if (trim($_POST['n_mdp_conf']) =='')              { $ERROR_FORMULAIRE = 3;  }
     else if (strlen($_POST['mdp']) < 6)                    { $ERROR_FORMULAIRE = 4;  }
     else if (strlen($_POST['n_mdp']) < 6)                  { $ERROR_FORMULAIRE = 5;  }	 
     else if (strlen($_POST['n_mdp_conf']) < 6)             { $ERROR_FORMULAIRE = 6;  }	
     else if (($_POST['n_mdp_conf']) <> ($_POST['n_mdp']))  { $ERROR_FORMULAIRE = 7;  }
     else if (check_new_mdp($_POST['n_mdp'])  == 0 )        { $ERROR_FORMULAIRE = 10; }	
     else 
	     {	 
    	  	 $req = mysql_query('select password from affiliate where id_affiliate="'.$id_affiliate.'"   ') or die(".");
	    	 $dn = mysql_fetch_array($req);
		     if($dn['password'] <> $mdp) { $ERROR_FORMULAIRE = 11; }
		 }
		 
if ($ERROR_FORMULAIRE > 0 ) 
   {
    	echo '<form name="mdp_action"  action="../Intranet_Mon_Profil_pass.php" method="post">  ';
	    echo '<input type="hidden"   name="error_code"             value = '. $ERROR_FORMULAIRE .'     >';
		echo '<input type="hidden"   name="id_affiliate"           value = '. $id_affiliate .'    > ';
	    echo '<script language="JavaScript">document.mdp_action.submit();</script></form>';
   }	
else
if(isset($_POST['mdp'], $_POST['n_mdp'], $_POST['n_mdp_conf'], $_POST['id_affiliate']))
 {				
				mysql_query('SET NAMES utf8');
				date_default_timezone_set('Europe/Paris');
			    IF(get_magic_quotes_gpc()) { $_POST['n_mdp']  = stripslashes($_POST['n_mdp']); }
				                             $n_mdp_conf      = trim(mysql_real_escape_string($_POST['n_mdp']));	
				
				
				
				if(mysql_query(" UPDATE affiliate SET 
				                 password='$n_mdp_conf', 
								 last_connection_date=CURRENT_TIMESTAMP 
								 WHERE id_affiliate='$id_affiliate' "))          
				{
					//Si ca a fonctionne, on affiche une confirmation 
                      $ERROR_FORMULAIRE = 100;					
                      echo '<form name="mdp_action"  action="../Intranet_Mon_Profil_pass.php" method="post">  ';
	                  echo '<input type="hidden"   name="error_code"             value = '. $ERROR_FORMULAIRE .'     >';
	                  echo '<input type="hidden"   name="id_affiliate"           value = '. $id_affiliate .'    > ';
					  echo '<script language="JavaScript">document.mdp_action.submit();</script></form>';
				}
				else
				{
                      $ERROR_FORMULAIRE = 200;					
                      echo '<form name="mdp_action"  action="../Intranet_Mon_Profil_pass.php" method="post">  ';
	                  echo '<input type="hidden"   name="error_code"             value = '. $ERROR_FORMULAIRE .'     >';
	                  echo '<input type="hidden"   name="id_affiliate"           value = '. $id_affiliate .'    > ';
					  echo '<script language="JavaScript">document.mdp_action.submit();</script></form>';
				}
 }
 else
				{
                      $ERROR_FORMULAIRE = 200;					
                      echo '<form name="mdp_action"  action="../Intranet_Mon_Profil_pass.php" method="post">  ';
	                  echo '<input type="hidden"   name="error_code"             value = '. $ERROR_FORMULAIRE .'     >';
	                  echo '<input type="hidden"   name="id_affiliate"           value = '. $id_affiliate .'    > ';
					  echo '<script language="JavaScript">document.mdp_action.submit();</script></form>';
				}

?> 
