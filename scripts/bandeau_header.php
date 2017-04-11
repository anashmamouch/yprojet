<?php    if(!isset($_SESSION)){session_start();}                ?>
<?php    require('scripts/config.php');                         ?>
<?php    require('scripts/function_12345678910.php');           ?>  
<?php    require("scripts/functions.php");                      ?>
<?php    $pageName = basename($_SERVER['SCRIPT_NAME']);         ?>

<?php
date_default_timezone_set('Europe/Paris');
    if(!isset($_GET['lang'] )){
    if(isset($_SESSION['lang'])){
        $_GET['lang'] = $_SESSION['lang'];
    }else{
        $_SESSION['lang'] = '';
    }

} else {
    $_SESSION['lang'] = $_GET['lang'];
}
setlocale(LC_ALL, $_SESSION['lang']);
$traduction = 'translation';
include 'traduction/localization.php';


?>

<body class="page-header-fixed page-quick-sidebar-over-content page-style-square page-footer-fixed"> 
    
<div> 
  <?php if(isset($_SESSION['id_affiliate']) or isset($_SESSION['id_partenaire'])) 
		 { ?>
    <div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="page-header-inner">
		<!---------------------------------------------------------------------------------------------------------->
		<!-- BEGIN CHECK INTERNET EXPLORER OLD VERSION < 8  -------------------------------------------------------->
	  	          <?php 
                                IF(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])) // if IE<=8
                                { echo '<meta http-equiv="refresh" content="0;URL=index_IE.php">'; } 
	              ?>

  	    <!---------------------------------------------------------------------------------------------------------->
		<!-- BEGIN LOGO -------------------------------------------------------------------------------------------->	
		<div class="page-logo">
		    <a <?php      IF( CHECK_ACCESS_123($_SESSION['id_affiliate'], $_SESSION['statut'], "CRYPT_LEVEL_8") == 1)                              { echo ' href="NosRezo12345678910.php"'; }
                     ELSE IF( CHECK_ACCESS_123($_SESSION['id_affiliate'], $_SESSION['statut'], "CRYPT_LEVEL_8") == 2)                              { echo ' href="NosRezo12345678911_6.php"'; }
                                                             ELSE IF ( (isset($_SESSION['first_name']) and $_SESSION['id_affiliate']  > 10))       { echo ' href="Intranet_Accueil.php"';   }	
		    												 ELSE                                                                                    echo ' href="login.php"' ?> >
		    	<img src="assets/img/logo_nosrezo_blue.png" alt="logo" class="logo-default"/>
		    </a>	
		</div>
		<!-- END LOGO ---------------------------------------------------------------------------------------------->
		<!---------------------------------------------------------------------------------------------------------->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
		<div class="top-menu">
		<ul class="nav navbar-nav pull-right">
			
                <!----------------------------------- 1. LANGUAGE BAR  -------------------------------------------------->
                <?php  switch ($_SESSION['lang']) 
				{
                case 'fr_Fr':  ?>
                <li class="dropdown dropdown-language">
					<a href="?lang=fr_FR" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="assets/global/img/flags/fr.png">
					<span class="langname">
					FR </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<!--<li> <a href="?lang=en_US">	<img alt="" src="assets/global/img/flags/us.png"> English </a></li>-->
						<li>
							<a href="?lang=pt_PT">
							<img alt="" src="assets/global/img/flags/pt.png"> Português </a>
						</li>

					</ul>
				</li>
				
                <?php  break;  case 'en_US': ?>
                <li class="dropdown dropdown-language">
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="?lang=fr_FR">
							<img alt="" src="assets/global/img/flags/fr.png"> Français </a>
						</li>
						<li>
							<a href="?lang=pt_PT">
							<img alt="" src="assets/global/img/flags/pt.png"> Português </a>
						</li>
					</ul>
				</li>
				
                <?php  break; case 'pt_PT':  ?>
                <li class="dropdown dropdown-language">
 
					<a href="?lang=pt_PT" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="assets/global/img/flags/pt.png">
					<span class="langname">
					PT </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<!--<li>
							<a href="?lang=en_US">
							<img alt="" src="assets/global/img/flags/us.png"> English </a>
						</li>-->
						<li>
							<a href="?lang=fr_FR">
							<img alt="" src="assets/global/img/flags/fr.png"> Français </a>
						</li>
						
						
					</ul>
				</li>
				
                 <?php break; default: ?>
                <li class="dropdown dropdown-language">
 
					<a href="?lang=fr_FR" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="assets/global/img/flags/fr.png">
					<span class="langname">
					FR </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">

						<li>
							<a href="?lang=pt_PT">
							<img alt="" src="assets/global/img/flags/pt.png"> Português </a>
						</li>
						
						
					</ul>
				</li>
                 <?php  break;
                 }  ?>
                
             <!-------------------------------------------------------------------------------------------------- BEGIN CALENDAR NOTIFICATIONS -->
			<?php  $notifi_calendar = COUNT_NOTIFICATION_CALENDAR_OUVERTE(0,0);	?>    
			
			 <li id="header_notification_bar" class="dropdown dropdown-extended dropdown-notification">
		         <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                 <i class="icon-calendar"></i>
				     <?php  IF ($notifi_calendar > 0) { echo'<span class="badge badge-danger ">'.$notifi_calendar.'</span>'; } ?>
                 </a>
				     <?php  IF ($notifi_calendar > 0) { DROPDOWN_CALENDAR_NOTIFICATIONS_LIST($lien_webinar , 0); } ?> 				
             </li>
			 
             <!-------------------------------------------------------------------------------------------------- BEGIN NOTIFICATIONS -->
			<?php  $notification = COUNT_NOTIFICATION_AFFILIE_OUVERTE($_SESSION['id_affiliate']);	?>    
			
			 <li id="header_notification_bar" class="dropdown dropdown-extended dropdown-notification">
		         <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                 <i class="icon-bell"></i>
				     <?php  IF ($notification > 0) { echo'<span class="badge badge-danger ">'.$notification.'</span>'; } ?>
                 </a>
				     <?php  IF ($notification > 0) { DROPDOWN_NOTIFICATIONS_LIST($_SESSION['id_affiliate']); } ?> 				
             </li>
			 			
             <!-------------------------------------------------------------------------------------------------- BEGIN USER LOGIN OPTIONS -->
			<li id="header_notification_bar" class="dropdown dropdown-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-user"></i>
					<span class="username">
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
                    <li>
					<a href="Intranet_Nouvelle_recommandation.php?category=1">
					       <i class="icon-rocket"> </i> <?php echo T_("Mise en relation");?> &nbsp 
						 </a>
				    </li>		
                    <li>
					<a href="Intranet_invitez_vos_amis.php"> 
					       <i class="icon-users"> </i> <?php echo T_("Inviter un ami");?>
						   </a>
				    </li>
                    <li>
					<a href="signup.php?id_parrain=<?php echo $_SESSION['id_affiliate'] ?>&amp;name_parrain=<?php echo $_SESSION['first_name'] ?>" target="_blank"> 
					       <i class="icon-users"></i> <?php echo T_("Inscription en LIVE");?> &nbsp 
						   </a>
				    </li>
					<li>
					<!----<a href="Intranet_Mon_Profil.php">
							<i class="icon-user"></i> Mon profil
						</a>
					</li>
					<li>
					<a href="Intranet_Mon_Profil_pass.php">					
							<i class="icon-lock"></i> Mot de passe
						</a>
					</li> -->

					<li>
						<a href="scripts/deconnection.php">
							<i class="icon-key"></i> <?php echo T_("Déconnexion");?>
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
    </div>

  <?php } ELSE 
            { ?>
    	         <form name="p_action"  action="login.php" method="post"> 
	             <script language="JavaScript">document.p_action.submit();</script></form> 
  <?php }	 ?>																															 
																																 


</div>


