<?php    $pageName = basename($_SERVER['SCRIPT_NAME']);  ?>

<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<?php 
IF( CHECK_ACCESS_123($_SESSION['id_affiliate'], $_SESSION['statut'], "CRYPT_LEVEL_8") == 1)
{ 
?>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <?php  IF( $_SESSION['id_affiliate'] < 10 AND $_SESSION['id_affiliate'] <> 5 AND $_SESSION['id_affiliate'] <> 9) { ?>

			 	<li class="heading">
                      <h3 class="uppercase"> &nbsp ADMINISTRATEUR</h3>
                </li>			 
			 
			<!---	<li <?php    if ($pageName =="NosRezo12345678910.php"     or 
				                  $pageName =="XXXXXXXXXX.php"	              or 
								  $pageName =="XXXXXXXXXX.php"	             ) { echo "class=\"start active\"; ";} ?> >
					<a href="NosRezo12345678910.php">
						<i class="icon-home"></i>
						<span class="title">
							Synthèse
						</span>
						<span  <?php    if ($pageName =="NosRezo12345678910.php") { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
				</li>				
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    IF ( $pageName =="NosRezo12345678911.php"     or 
				                  $pageName =="NosRezo12345678911_0.php"   or 
								  $pageName =="NosRezo12345678911_01.php"  or
								  $pageName =="NosRezo12345678911_1.php"   or
								  $pageName =="NosRezo12345678911_2.php"   or
								  $pageName =="NosRezo12345678911_3.php"   or
								  $pageName =="NosRezo12345678911_4.php"   or
								  $pageName =="NosRezo12345678911_5.php"   or
								  $pageName =="NosRezo12345678918.php"     or
								  $pageName =="NosRezo12345678919_1.php"   or 
								  $pageName =="XXXXXXXXXXXXXX.php"   or 
				                  $pageName =="NosRezo12345678919.php"     ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-rocket"></i>
						<span class="title">
							Actions
						</span>
						<span class="arrow">
						</span>
						<span  <?php    IF ( $pageName =="NosRezo12345678911.php"     or 
						                     $pageName =="NosRezo12345678911_0.php"   or 
											 $pageName =="NosRezo12345678911_01.php"  or
											 $pageName =="NosRezo12345678911_1.php"   or
											 $pageName =="NosRezo12345678911_2.php"   or
											 $pageName =="NosRezo12345678911_3.php"   or
											 $pageName =="NosRezo12345678911_4.php"   or
											 $pageName =="NosRezo12345678911_5.php"   or
											 $pageName =="NosRezo12345678918.php"     or
											 $pageName =="NosRezo12345678919_1.php"   or
											 $pageName =="XXXXXXXXXXXXXX.php"   or 
						                     $pageName =="NosRezo12345678919.php"    ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">
						<li <?php    IF ( $pageName =="NosRezo12345678911.php" or $pageName =="NosRezo12345678911_1.php" or $pageName =="NosRezo12345678911_2.php" or $pageName =="NosRezo12345678911_3.php" or $pageName =="NosRezo12345678911_4.php"  or $pageName =="NosRezo12345678918.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911.php">
								 <i class="icon-pencil"></i> Actions à traiter
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_5.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_5.php">
								 <i class="icon-rocket"></i> Relances Partenaires
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_01.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_01.php">
								 <i class="icon-briefcase"></i> Activer Partenaires
							</a>
						</li>
						
						<?php    IF ( $_SESSION['id_affiliate'] == 1) {?>
						<li <?php    IF ( $pageName =="NosRezo12345678919.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678919.php">
								<i class="icon-settings"></i> Paramètrages
							</a>
						</li>
						 <?php    }?>
						 
					</ul>
				</li>
             <?php  }  ?>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    IF ( $pageName =="NosRezo12345678912.php"    or 
				                  $pageName =="NosRezo12345678913.php"    or 
								  $pageName =="NosRezo12345678914.php"    or
								  $pageName =="NosRezo12345678912_1.php"  or
								  $pageName =="NosRezo12345678912_3.php"  or
								  $pageName =="NosRezo12345678913_1.php"  or
				                  $pageName =="NosRezo12345678912_4.php"  or
								  $pageName =="Intranet_Nouvelle_recommandation_suivi.php"  or
								  $pageName =="Intranet_Dossiers_comptabilite.php"    ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-folder"></i>
						<span class="title">
							Données
						</span>
						<span class="arrow">
						</span>
						<span  <?php    if ( $pageName =="NosRezo12345678912.php"    or 
						                     $pageName =="NosRezo12345678913.php"    or 
											 $pageName =="NosRezo12345678914.php"    or
											 $pageName =="NosRezo12345678912_1.php"  or
											 $pageName =="NosRezo12345678912_3.php"  or
											 $pageName =="NosRezo12345678913_1.php"  or
											 $pageName =="NosRezo12345678912_4.php"  or
											 $pageName =="Intranet_Nouvelle_recommandation_suivi.php"  or
						                     $pageName =="Intranet_Dossiers_comptabilite.php"    ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">
						<li <?php    IF ( $pageName =="NosRezo12345678913.php" or $pageName =="NosRezo12345678913_1.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678913.php">
								<i class="icon-basket"></i>  Recommandations
							</a>
						</li>
						<li <?php    IF ( $pageName =="NosRezo12345678912.php" or $pageName =="NosRezo12345678912_1.php" or $pageName =="NosRezo12345678912_3.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678912.php"> 
								<i class="icon-users"></i>  Affilié / Partenaire
							</a>
						</li>
						<li <?php    IF ( $pageName =="NosRezo12345678914.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678914.php">
								<i class="icon-briefcase"></i> Trouver Partenaire
							</a>
						</li>
						<li <?php    IF ( $pageName =="NosRezo12345678912_4.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678912_4.php">
								 <i class="icon-bar-chart"></i> Top Affiliés
							</a>
						</li>
						<li <?php    IF ( $pageName =="Intranet_Dossiers_comptabilite.php" or $pageName =="Intranet_Nouvelle_recommandation_suivi.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Dossiers_comptabilite.php">
								<i class="icon-basket"></i>  Focus JARVIS
							</a>
						</li>
					</ul>
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <?php  IF( $_SESSION['id_affiliate'] == 1  OR $_SESSION['id_affiliate'] == 2 OR $_SESSION['id_affiliate'] == 9 ) { ?>
				<li <?php    IF ( $pageName =="XXXXXXXXXXXXX.php"     or 
				                  $pageName =="XXXXXXXXXXXXX.php"   or 
								  $pageName =="XXXXXXXXXXXXX.php"  or
								  $pageName =="XXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXX.php"   or
								  $pageName =="NosRezo12345678911_9.php"   or
								  $pageName =="NosRezo12345678911_8.php"     or
								  $pageName =="NosRezo12345678911_7.php"   or 
								  $pageName =="NosRezo12345678911_6.php"   or 
				                  $pageName =="XXXXXXXXXXXXX.php"     ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-bar-chart"></i>
						<span class="title">
							SOREGOR
						</span>
						<span class="arrow">
						</span>
						<span  <?php    IF ( $pageName =="XXXXXXXXXXXXX.php"     or 
						                     $pageName =="XXXXXXXXXXXXX.php"   or 
											 $pageName =="XXXXXXXXXXXXX.php"  or
											 $pageName =="XXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXX.php"   or
											 $pageName =="NosRezo12345678911_9.php"   or
											 $pageName =="NosRezo12345678911_8.php"     or
											 $pageName =="NosRezo12345678911_7.php"   or
											 $pageName =="NosRezo12345678911_6.php"   or 
						                     $pageName =="XXXXXXXXXXXXX.php"    ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">

						
						<li <?php    IF ( $pageName =="NosRezo12345678911_6.php" OR $pageName =="NosRezo12345678918.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_6.php">
								 <i class="icon-pencil"></i> Actions à traiter
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_7.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_7.php">
								 <i class="icon-folder"></i> Liste des Factures
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_8.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_8.php">
								 <i class="fa fa-calendar"></i> Historique paiements
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_9.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_9.php">
								 <i class="icon-bar-chart"></i> Suivi Comptable
							</a>
						</li>
						
					</ul>
				</li>
             <?php  }  ?>				
				
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
			 
				<li class="heading">
                      <h3 class="uppercase"> &nbsp AFFILIÉ</h3>
                </li>
			 
			 
				<li <?php    if ( $pageName =="Intranet_Accueil.php"           or 
				                  $pageName =="XXXXXXXXXX.php"	              or 
								  $pageName =="XXXXXXXXXX.php"	             ) { echo "class=\"start active\"; ";} ?> >
					<a href="Intranet_Accueil.php">
						<i class="icon-users"></i>
						<span class="title">
							Intranet Affilié
						</span>
						<span  <?php    if ($pageName =="Intranet_Accueil.php") { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
				</li>				
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
<?php 
}
ELSE IF( check_access_123($_SESSION['id_affiliate'], $_SESSION['statut'], "CRYPT_LEVEL_8") == 2) // 
{
?>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <?php  IF( $_SESSION['id_affiliate'] < 10 AND $_SESSION['id_affiliate'] <> 5 ) { ?>

			 	<li class="heading">
                      <h3 class="uppercase"> &nbsp SOREGOR</h3>
                </li>			 
			 				
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    IF ( $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or 
				                  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or 
								  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="NosRezo12345678911_9.php"   or
								  $pageName =="NosRezo12345678911_8.php"   or
								  $pageName =="NosRezo12345678911_7.php"   or 
								  $pageName =="NosRezo12345678911_6.php"   or 
				                  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"     ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-rocket"></i>
						<span class="title">
							Actions
						</span>
						<span class="arrow">
						</span>
						<span  <?php    IF ( $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or 
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or 
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"   or
											 $pageName =="NosRezo12345678911_9.php"   or
											 $pageName =="NosRezo12345678911_8.php"   or
											 $pageName =="NosRezo12345678911_7.php"   or
											 $pageName =="NosRezo12345678911_6.php"   or 
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_6.php" OR $pageName =="NosRezo12345678918.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_6.php">
								 <i class="icon-pencil"></i> Actions à traiter
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_7.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_7.php">
								 <i class="icon-folder"></i> Liste des Factures
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_8.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_8.php">
								 <i class="fa fa-calendar"></i> Historique paiements
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="NosRezo12345678911_9.php" OR $pageName =="XXXXXXXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="NosRezo12345678911_9.php">
								 <i class="icon-bar-chart"></i> Suivi Comptable
							</a>
						</li>
		
					</ul>
				</li>
             <?php  }  ?>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div> 
<?php 
} 
ELSE
     {
	  echo '<meta http-equiv="refresh" content="0;URL=login.php">'; 	
     }
?>
