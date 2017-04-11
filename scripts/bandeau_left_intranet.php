<?php    if(!isset($_SESSION)){session_start();}         ?>
<?php    $pageName = basename($_SERVER['SCRIPT_NAME']);  ?>

<!------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------------->
<?php 
IF( isset($_SESSION['id_affiliate']))
{
?>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler hidden-phone">
					</div>
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<?php IF ($_SESSION['statut'] == "AFFILIE_ET_PARTENAIRE") 
				{ 
			 	echo '<li class="heading">';
                      echo '<h3 class="uppercase"> &nbsp '. T_("affilié").' </h3>';
                echo '</li>';				
                } ?>


			 <li <?php    if (    $pageName =="Intranet_Accueil.php"             or 
							      $pageName =="XXXXXXX.php"	                     or
				                  $pageName =="XXXXXXXX.php"	                 or
								  $pageName =="XXXXXXXXX.php"	                 or            								  
								  $pageName =="XXXXXXXXXX.php"	             ) { echo "class=\"start active\"; ";} ?> >
					<a href="Intranet_Accueil.php">
						<i class="icon-home"></i>
						<span class="title">
							<?php echo T_("Accueil"); ?>
						</span>
						<span  <?php    if ($pageName =="Intranet_Accueil.php") { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
			</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    if ( $pageName =="Intranet_Nouvelle_recommandation.php"          or 
				                  $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXX.php"	              or   
				                  $pageName =="xxxxx.php"	                                  or 
				                  $pageName =="xxxxxxxx.php"	                              or 
				                  $pageName =="xxxxxxxx.php"	                              or 
				                  $pageName =="Intranet_Suivi.php"	                          or 
                                  $pageName =="XXXXXXXXXXXXXXXXXXXXXXX.php"	                  or 
                                  $pageName =="Intranet_invitez_vos_amis.php"	              or 
								  $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.php"   or
								  $pageName =="Intranet_planning_suivi_mail.php"	           ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-rocket"></i>
						<span class="title"> <?php echo T_("Mes Actions"); ?> </span>
						<span class="arrow open "></span>
						<span  <?php    if ( $pageName =="Intranet_Nouvelle_recommandation.php"               or 
						                     $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXX.php"                    or 
				                             $pageName =="xxxxx.php"	                          or 
				                             $pageName =="xxxxxxx.php"	      or 
				                             $pageName =="xxxxxx.php"	                  or 
				                             $pageName =="Intranet_Suivi.php"	                              or 
				                             $pageName =="Intranet_mail_equipe.php"	                          or 
											 $pageName =="XXXXXXXXXXXXXXXXXXXXXXX.php"	                          or 
											 $pageName =="Intranet_invitez_vos_amis.php"	                  or 
											 $pageName =="XXXXXXXXXXXXXXXXXXXXXXX.php"	                  or 
											 $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.php"    or
						                     $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.php"             )  { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu" style="display: block;">
						<li <?php    IF ( $pageName =="Intranet_Nouvelle_recommandation.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Nouvelle_recommandation.php">
                                <span class="badge badge-roundless badge-warning"> GO </span>
							<i class="icon-basket"></i>  <?php echo T_("Mise en relation"); ?>
							</a>
						</li>

						<li <?php    IF ( $pageName =="Intranet_invitez_vos_amis.php") { echo "class=\"start active\"; ";} ?>    >						
					         <a href="signup.php?id_parrain=<?php echo $_SESSION['id_affiliate'] ?>&amp;name_parrain=<?php echo $_SESSION['first_name'] ?>" target="_blank"> 
							        <span class="badge badge-roundless badge-warning"> GO </span>
					                <i class="icon-user"></i> <?php echo T_("Inscription en LIVE");?> &nbsp 
				             </a>
						</li>					
				
					</ul>
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
			 <li <?php    if (    $pageName =="Intranet_Annuaire_partenaires.php"        or 
							      $pageName =="Intranet_partenaire_profil_master.php"	 or
				                  $pageName =="XXXXXXXX.php"	                         or
								  $pageName =="XXXXXXXXX.php"	                         or            								  
								  $pageName =="XXXXXXXXXX.php"	             ) { echo "class=\"start active\"; ";} ?> >
					<a href="Intranet_Annuaire_partenaires.php">
                                <i class="icon-users"></i>
						         <!---- <span class="badge badge-roundless badge-danger"> 	new </span> --->
                                <span class="title">								
								  <?php echo T_("Annuaire"); ?>  
								</span>
						</span>
						<span  <?php    if ($pageName =="Intranet_Annuaire_partenaires.php") { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
			</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
			 <li <?php    IF (    $pageName =="Intranet_travaux.php"               or 
				                  $pageName =="Intranet_entretien.php"             or 
								  $pageName =="Intranet_juridique.php"             or 
								  $pageName =="Intranet_immobilier.php"            or
								  $pageName =="Intranet_recrutement.php"           or
                                  $pageName =="Intranet_Documents.php"             or 
				                  $pageName =="Intranet_Partenaires.php"           or 
								  $pageName =="Intranet_classement_2.php"          or
								  $pageName =="Intranet_classement_3.php"          or
								  $pageName =="Intranet_Simulation.php"            or
								  $pageName =="Intranet_Simulation_Nette.php"      or
								  $pageName =="Intranet_boite_a_idee.php"          or
				                  $pageName =="Intranet_planning_suivi_mail.php"   or 
				                  $pageName =="Intranet_Etapes.php"                or 
				                  $pageName =="Intranet_Extra_FAQ.php"             or 
								  $pageName =="Intranet_Mon_Profil_parrainage.php" or 
								  $pageName =="Intranet_classement_1.php"          or
								  $pageName =="Intranet_Documents_marketing.php"  or
								  $pageName =="Intranet_Contrat_VDI.php"           or
								  $pageName =="Intranet_Nouveau_partenaire.php"    or
								  $pageName =="Intranet_Nouveau_partenaire_0.php"  or
								  $pageName =="Intranet_planning_nr.php"           or
				                  $pageName =="Intranet_Nouveaute_site.php"    ) { echo "class=\"start active\"; ";} ?> >
                             <a href="javascript:;">
                             <i class="icon-info"></i>
                                  <span class="title"><?php echo T_("Informations"); ?></span> 
								  <span class="arrow "></span>
						          <span  <?php    
								  IF (  $pageName =="Intranet_travaux.php"         or 
				                  $pageName =="Intranet_entretien.php"             or
                                  $pageName =="Intranet_juridique.php"             or 								  
								  $pageName =="Intranet_immobilier.php"            or
								  $pageName =="Intranet_recrutement.php"           or
                                  $pageName =="Intranet_Documents.php"             or 
				                  $pageName =="Intranet_Partenaires.php"           or 
								  $pageName =="Intranet_classement_2.php"          or
								  $pageName =="Intranet_classement_3.php"          or
								  $pageName =="Intranet_Simulation.php"            or
								  $pageName =="Intranet_Simulation_Nette.php"      or
								  $pageName =="Intranet_boite_a_idee.php"          or
				                  $pageName =="Intranet_planning_suivi_mail.php"   or 
				                  $pageName =="Intranet_Etapes.php"                or 
				                  $pageName =="Intranet_Extra_FAQ.php"             or 
								  $pageName =="Intranet_Mon_Profil_parrainage.php" or 
								  $pageName =="Intranet_classement_1.php"          or
								  $pageName =="XXXXXXXXXXXXXXXXXXXXXXXXXXXXX.php"  or
								  $pageName =="Intranet_Contrat_VDI.php"           or
								  $pageName =="Intranet_Nouveau_partenaire.php"    or
								  $pageName =="Intranet_Nouveau_partenaire_0.php"  or 
								  $pageName =="Intranet_planning_nr.php"           or
								  $pageName =="Intranet_Documents_marketing.php"           or
				                  $pageName =="Intranet_Nouveaute_site.php"   )  { echo "class=\"selected\"; ";} ?>     >
						          </span>								  

                              </a>
                         
						 <ul class="sub-menu" >
                         <li  <?php    if (  $pageName =="Intranet_travaux.php"      or 
						                     $pageName =="Intranet_entretien.php"    or 
											 $pageName =="Intranet_immobilier.php"   or
											 $pageName =="Intranet_recrutement.php"  or
											 $pageName =="Intranet_juridique.php"  or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"  or
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?>  >
                         <a href="javascript:;"> <i class="icon-settings"></i>  <?php echo T_("Services"); ?> NosRezo    <span class="arrow "></span> </a>
					     <ul class="sub-menu">
					   	                         <li <?php    IF ( $pageName =="Intranet_travaux.php") { echo "class=\"start active\"; ";} ?>    >
					   	                         	<a href="Intranet_travaux.php">
					   	                         		<i class="icon-globe"></i> <?php echo T_("Travaux"); ?>
					   	                         	</a>
					   	                         </li>
												 
					   	                         <li <?php    IF ( $pageName =="Intranet_entretien.php") { echo "class=\"start active\"; ";} ?>    >
					   	                         	<a href="Intranet_entretien.php">
					   	                         		 <i class="icon-globe"></i> <?php echo T_("Entretien maison"); ?>
					   	                         	</a>
					   	                         </li>
												 
					   	                         <li <?php    IF ( $pageName =="Intranet_immobilier.php") { echo "class=\"start active\"; ";} ?>    >
					   	                         	<a href="Intranet_immobilier.php">
					   	                         		<i class="icon-globe"></i> <?php echo T_("Immobilier"); ?>
					   	                         	</a>
					   	                         </li>
												 
					   	                         <li <?php    IF ( $pageName =="Intranet_recrutement.php") { echo "class=\"start active\"; ";} ?>    >
					   	                         	<a href="Intranet_recrutement.php">
					   	                         		<i class="icon-globe"></i> <?php echo T_("Recrutement"); ?>
					   	                         	</a>
					   	                         </li>
												 
					   	                         <li <?php    IF ( $pageName =="Intranet_juridique.php") { echo "class=\"start active\"; ";} ?>    >
					   	                         	<a href="Intranet_juridique.php">
					   	                         		 <i class="icon-globe"></i> <?php echo T_("Juridique"); ?>
					   	                         	</a>
					   	                         </li>
												 
					    </ul>
                        </li>
						
                         <li <?php    if (   $pageName =="Intranet_travaux.php"                  or 
						                     $pageName =="Intranet_Mon_Profil_parrainage.php"    or 
											 $pageName =="Intranet_Extra_FAQ.php"                or
											 $pageName =="Intranet_boite_a_idee.php"             or
											 $pageName =="Intranet_Nouveaute_site.php"              or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"              or
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?> >
                        <a href="javascript:;"><i class="icon-question"></i>  <?php echo T_("Utiles"); ?>    <span class="arrow "></span> </a>
					    <ul class="sub-menu">
							 
					                        <li <?php    IF ( $pageName =="Intranet_Mon_Profil_parrainage.php") { echo "class=\"start active\"; ";} ?>    >
					                        	<a href="Intranet_Mon_Profil_parrainage.php">
					                        		 <i class="icon-puzzle"></i>  <?php echo T_("QCM"); ?> NosRezo
					                        	</a>
					                        </li>
                                            
											
					                        <li <?php    IF ( $pageName =="Intranet_Extra_FAQ.php") { echo "class=\"start active\"; ";} ?>    >
					                        	<a href="Intranet_Extra_FAQ.php">
					                        		<i class="icon-question"></i>  <?php echo T_("FAQ"); ?>
					                        	</a>
					                        </li>
					                        
										<!--	
						                     <li <?php    IF ( $pageName =="Intranet_Nouveaute_site.php") { echo "class=\"start active\"; ";} ?>    >
						                     	<a href="Intranet_Nouveaute_site.php">
						                     		<i class="icon-bulb"></i>  <?php echo T_("Nouveautés"); ?>
						                     	</a>
						                     </li>
											 -->
										<!--	 
						                     <li <?php    IF ( $pageName =="Intranet_boite_a_idee.php") { echo "class=\"start active\"; ";} ?>    >
						                     	<a href="Intranet_boite_a_idee.php">
						                     		<i class="icon-bulb"></i>  <?php echo T_("Boîte à idées"); ?>
						                     	</a>
						                     </li> -->
                                            
					    </ul>
						</li>

<!--
                         <li <?php    if (   $pageName =="Intranet_classement_2.php"             or 
						                     $pageName =="Intranet_classement_1.php"             or 
											 $pageName =="Intranet_classement_3.php"             or
											 $pageName =="XXXXXXXXXXXXXXXXXXXXX.php"             or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"              or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"              or
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?> >
                        <a href="javascript:;"><i class="icon-trophy"></i>  <?php echo T_("TOP"); ?>    <span class="arrow "></span> </a>
					    <ul class="sub-menu">						
						
						
					                    	<li <?php    IF ( $pageName =="Intranet_classement_2.php") { echo "class=\"start active\"; ";} ?>    >
					                    		<a href="Intranet_classement_2.php">
					                    			 <i class="icon-trophy"></i>  <?php echo T_("Recommandations"); ?>
					                    		</a>
					                    	</li>
											
											<?php    IF ( 1 == 2 ) { ?>
					                    	<li <?php    IF ( $pageName =="Intranet_classement_1.php") { echo "class=\"start active\"; ";} ?>    >
					                    		<a href="Intranet_classement_1.php">
					                    			 <i class="icon-trophy"></i>  <?php echo T_("Affiliés"); ?> N1
					                    		</a>
					                    	</li>
											<?php   } ?>
											
					                    	<li <?php    IF ( $pageName =="Intranet_classement_3.php") { echo "class=\"start active\"; ";} ?>    >
					                    		<a href="Intranet_classement_3.php">
					                    			 <i class="icon-trophy"></i> <?php echo T_("Affiliés"); ?>  N2
					                    		</a>
					                    	</li>
						
					    </ul>
						</li>
-->
						
						
						<li <?php    IF ( $pageName =="Intranet_Simulation.php" or $pageName =="Intranet_Simulation_Nette.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Simulation.php">
						<?php //		<span class="badge badge-roundless badge-warning"> 	new </span> ?>
								<i class="icon-bar-chart"></i>  <?php echo T_("Simulation"); ?>
							</a>
						</li>
						
						
                         <li <?php    if (   $pageName =="Intranet_Documents.php"                  or 
						                     $pageName =="Intranet_Etapes.php"    or 
											 $pageName =="Intranet_Contrat_VDI.php"                or
											 $pageName =="Intranet_Documents_marketing.php"             or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"              or
											 $pageName =="XXXXXXXXXXXXXXXXXXXX.php"              or
						                     $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?> >
                        <a href="javascript:;"><i class="icon-folder"></i>  <?php echo T_("Documents"); ?>    <span class="arrow "></span> </a>
					    <ul class="sub-menu">
							 
					                        <li <?php    IF ( $pageName =="Intranet_Mon_Profil_parrainage.php" or $pageName =="Intranet_Etapes.php" or $pageName =="Intranet_Contrat_VDI.php" ) { echo "class=\"start active\"; ";} ?>    >
					                        	<a href="Intranet_Documents.php">
					                        		 <i class="icon-folder"></i>  <?php echo T_("Documents"); ?>
					                        	</a>
					                        </li>
                                            
											
					                        <li <?php    IF ( $pageName =="Intranet_Documents.php") { echo "class=\"start active\"; ";} ?>    >
					                        	<a href="Intranet_Documents_marketing.php">
					                        		<i class="icon-layers"></i>  <?php echo "Marketing"; ?>
					                        	</a>
					                        </li>
                                            
					    </ul>
						</li>						

					
						<li <?php    IF ( $pageName =="Intranet_planning_nr.php" or $pageName =="XXXXXXXXXXXXX.php" ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_planning_nr.php">
						        <span class="badge badge-roundless badge-danger"> 	new </span> 
								<i class="icon-calendar"></i>  ApéroRezo
							</a>
						</li>
					
						<li <?php    IF ( $pageName =="Intranet_Nouveau_partenaire.php" or   $pageName =="Intranet_Nouveau_partenaire_0.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Nouveau_partenaire_0.php">
								<i class="icon-briefcase"></i>  <?php echo T_("Proposer Professionnel"); ?>
							</a>
						</li>

						 </ul>
						 
			</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    IF ( $pageName =="Intranet_Mon_Profil.php"                        or 
				                  $pageName =="Intranet_Mon_Profil_pass.php"                   or 
								  $pageName =="Intranet_Mon_Profil_banque.php"                 or
								  $pageName =="Intranet_ma_remuneration.php"                   or
								  $pageName =="Intranet_suivi_comptable_0.php"                 or
								  $pageName =="Intranet_Equipe_suivi.php"                      or
								  $pageName =="Intranet_Equipe_suivi_L2.php"                   or
				                  $pageName =="Intranet_Dossiers_Equipe.php"                   or
								  $pageName =="Intranet_Dossiers.php"                          or
								  $pageName =="Intranet_Nouvelle_recommandation_suivi.php"     or
								  $pageName =="Intranet_Noter_partenaire.php"                  or 
								  $pageName =="Intranet_Equipe_suivi_challenge.php"            or
								  $pageName =="Intranet_Nouveau_challenge.php"                 or
								  $pageName =="Intranet_Equipe_challenge_customisation.php"    or
								  $pageName =="Intranet_challenge_summer_2015.php"             or
								  $pageName =="Intranet_Equipe_challenge_customisation_2.php"  or
								  $pageName =="Intranet_Dossiers_comptabilite.php"             or
                                  $pageName =="Intranet_mail_equipe.php"  		) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-user"></i>
						<span class="title">
							<?php echo T_("Mon Suivi"); ?>
						</span>
						<span class="arrow">
						</span>
						<span  <?php    if ( $pageName =="Intranet_Mon_Profil.php"                        or 
						                     $pageName =="Intranet_Mon_Profil_pass.php"                   or 
											 $pageName =="Intranet_Mon_Profil_banque.php"                 or
											 $pageName =="Intranet_ma_remuneration.php"                   or
											 $pageName =="Intranet_suivi_comptable_0.php"                 or
											 $pageName =="Intranet_Equipe_suivi_L2.php"                   or
											 $pageName =="Intranet_Equipe_suivi.php"                      or
						                     $pageName =="Intranet_Dossiers_Equipe.php"                   or
											 $pageName =="Intranet_Dossiers.php"                          or
											 $pageName =="Intranet_Nouvelle_recommandation_suivi.php"     or
											 $pageName =="Intranet_Noter_partenaire.php"                  or 
                                             $pageName =="Intranet_Equipe_suivi_challenge.php"            or 	
                                             $pageName =="Intranet_Nouveau_challenge.php"                 or
                                             $pageName =="Intranet_Equipe_challenge_customisation.php"    or		
                                             $pageName =="Intranet_challenge_summer_2015.php"             or
                                             $pageName =="Intranet_Equipe_challenge_customisation_2.php"  or
                                             $pageName =="Intranet_Dossiers_comptabilite.php"             or											 
                                             $pageName =="Intranet_mail_equipe.php"  	 ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">

             <?php 
             IF( $_SESSION['id_affiliate'] == 1742 )  // JOEL PEREIRA
             {
             ?>	
						<li <?php    IF ( $pageName =="Intranet_Dossiers_comptabilite.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Dossiers_comptabilite.php">
							<span class="badge badge-roundless badge-danger"> PRO </span>
																<i class="icon-basket"></i>  Comptabilité
							</a>
						</li>
             <?php 
             }
             ?>		

             <?php 
             IF( $_SESSION['id_affiliate'] == 18 )  // VADIM GOUTY
             {
             ?>	
						<li <?php    IF ( $pageName =="Intranet_Dossiers_comptabilite.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Dossiers_comptabilite.php">
							<span class="badge badge-roundless badge-danger"> PRO </span>
																<i class="icon-basket"></i>  TRIFORCE
							</a>
						</li>
             <?php 
             }
             ?>					 
					
					

						<li <?php    IF ( $pageName =="Intranet_Dossiers.php" or $pageName =="Intranet_Nouvelle_recommandation_suivi.php" or $pageName =="Intranet_Noter_partenaire.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Dossiers.php">

								<i class="icon-graph"></i> <?php echo T_("Suivi des dossiers"); ?>
							</a>
						</li>					
					
						<li <?php    IF ( $pageName =="Intranet_Nouveau_challenge.php" or $pageName =="Intranet_ma_remuneration.php" or $pageName =="Intranet_suivi_comptable_0.php" or $pageName =="Intranet_Equipe_suivi.php" or $pageName =="Intranet_Equipe_suivi_L2.php"  or $pageName =="Intranet_Dossiers_Equipe.php" or $pageName =="Intranet_mail_equipe.php" or $pageName =="Intranet_Equipe_suivi_challenge.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_ma_remuneration.php">
								<i class="icon-users"></i> <?php echo T_("Équipe"); ?> / <?php echo T_("Rémunération"); ?>
							</a>
						</li>

             <?php 
             IF( $_SESSION['id_affiliate'] == 1 AND 1== 2  ) // VADIM
             {
             ?>	
						<li <?php    IF ( $pageName =="Intranet_Equipe_challenge_customisation.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Equipe_challenge_customisation.php">
							<span class="badge badge-roundless badge-danger"> PRO </span>
								<i class="icon-diamond"></i> Challenge VIP
							</a>
						</li>
             <?php 
             }
             ?>	
			 
             <?php 
             IF( $_SESSION['id_affiliate'] == 1 AND 1 == 2 ) // CEDRIC HERRERAS
             {
             ?>	
						<li <?php    IF ( $pageName =="Intranet_Equipe_challenge_customisation_2.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Equipe_challenge_customisation_2.php">
							<span class="badge badge-roundless badge-danger"> PRO </span>
								<i class="icon-diamond"></i> Challenge VIP
							</a>
						</li>
             <?php 
             }
             ?>	
			 	
			 
						<li <?php    IF ( $pageName =="Intranet_Mon_Profil.php" or $pageName =="Intranet_Mon_Profil_banque.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Mon_Profil.php">
								<i class="icon-user"></i> <?php echo T_("Mon profil"); ?>
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="Intranet_Mon_Profil_pass.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Mon_Profil_pass.php">
								<i class="icon-lock"></i> <?php echo T_("Mot de passe"); ?>
							</a>
						</li>
						<li <?php    IF ( $pageName =="XXXXXXXXXXXXXXXXXXXX.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="scripts/deconnection.php">
								<i class="icon-key"></i> <?php echo T_("Déconnexion"); ?>
							</a>
						</li>
					</ul>
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>		 
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>		 

				<?php IF ($_SESSION['statut'] == "AFFILIE_ET_PARTENAIRE") 
				// ON AFFICHE L'ACCÉS PARTENAIRE
				{ ?>

				<br/>
				<br/>
				<li class="heading">
                      <h3 class="uppercase"> &nbsp <?php echo T_("PARTENAIRE"); ?></h3>
                </li>
			
				<li <?php    IF ( $pageName =="Intranet_partenaire_2.php"  or 
				                  $pageName =="Intranet_partenaire_3.php"  or 
				                  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?> >
					<a href="Intranet_partenaire_2.php">
						<i class="icon-home"></i>
						<span class="title">
							<?php echo T_("Mon Activité"); ?>
						</span>
						<span  <?php    if ($pageName =="Intranet_partenaire_2.php") { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
				</li>

             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>
				<li <?php    IF ( $pageName =="Intranet_Mon_Profil_Partenaire.php"         or 
				                  $pageName =="Intranet_Mon_Profil_Partenaire_pass.php"    or 
								  $pageName =="Intranet_partenaire_5.php"                  or
								  $pageName =="Intranet_partenaire_4.php"                  or
								  $pageName =="Intranet_Partenaire_secteur.php"            or
								  $pageName =="Intranet_partenaire_7.php"                  or
								  $pageName =="Intranet_partenaire_8.php"                  or
								  $pageName =="Intranet_partenaire_profil_master.php"           or
								  $pageName =="Intranet_qcm_IAD.php"                  or
				                  $pageName =="Intranet_partenaire_6.php"    ) { echo "class=\"start active\"; ";} ?> >
					<a href="javascript:;">
						<i class="icon-user"></i>
						<span class="title">
							<?php echo T_("Mon Compte"); ?>
						</span>
						<span class="arrow">
						</span>
						<span  <?php    if ( $pageName =="Intranet_Mon_Profil_Partenaire.php"        or 
						                     $pageName =="Intranet_Mon_Profil_Partenaire_pass.php"   or 
											 $pageName =="Intranet_partenaire_5.php"                 or
											 $pageName =="Intranet_partenaire_4.php"                 or
											 $pageName =="Intranet_Partenaire_secteur.php"           or
											 $pageName =="Intranet_partenaire_7.php"                 or
											 $pageName =="Intranet_partenaire_8.php"                 or
											 $pageName =="Intranet_mes_recommandations.php"          or
											 $pageName =="Intranet_qcm_IAD.php"                      or
											 $pageName =="XXXXXXXXXXXXXXXXXXXXX.php"                 or
						                     $pageName =="Intranet_partenaire_profil_master.php"    ) { echo "class=\"selected\"; ";} ?>     >
						</span>
					</a>
					<ul class="sub-menu">
						<li <?php    IF ( $pageName =="Intranet_Mon_Profil_Partenaire.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Mon_Profil_Partenaire.php">
								 <i class="icon-user"></i> <?php echo T_("Mon Profil"); ?>
							</a>
						</li>
						
						<li <?php    IF ( $pageName =="Intranet_partenaire_profil_master.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_partenaire_profil_master.php">
								<i class="icon-user"></i> <?php echo T_("Mon Profil Public"); ?>
							</a>
						</li>

						
						<li <?php    IF ( $pageName =="Intranet_Partenaire_secteur.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_Partenaire_secteur.php">
								<i class="icon-pointer"></i> <?php echo T_("Mon Secteur"); ?>
							</a>
						</li>
						
						<?php  IF ( $_SESSION['id_part_is_iad_FRANCE'] == 1  ) {  ?> 
						<li <?php    IF ( $pageName =="Intranet_qcm_IAD.php" or   $pageName =="Intranet_qcm_IAD.php"  ) { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_qcm_IAD.php">
								<i class="icon-puzzle"></i>  <?php echo T_("QCM IAD France"); ?>
							</a>
						</li>						
						<?php    } ?> 							
						
						
						
						<li <?php    IF ( $pageName =="Intranet_partenaire_8.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_partenaire_8.php">
	
								<i class="icon-plane"></i> <?php echo T_("Mes Vacances"); ?>
							</a>
						</li>

						
						 <!------------------------------------------------------------------------------------------------------------------>
                         <?php 
                         IF( $_SESSION['display_docs_part'] == 1) // IL S'AGIT DES PARTENAIRES TRAVAUX
                         {
                         ?>							

						 <li <?php    IF ( $pageName =="Intranet_partenaire_7.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_partenaire_7.php">
		
								<i class="icon-briefcase"></i> <?php echo T_("Mes compétences"); ?>
							</a>
						 </li>
						
                         <?php 
                         } 
                         ?>	
						 <!------------------------------------------------------------------------------------------------------------------>
						
						<li <?php    IF ( $pageName =="Intranet_partenaire_5.php") { echo "class=\"start active\"; ";} ?>    >
							<a href="Intranet_partenaire_5.php">
								 <i class="icon-docs"></i> <?php echo T_("Charte"); ?> NosRezo
							</a>
						</li>
					</ul>
				</li>
             <!------------------------------------------------------------------------------------------------------------------>
             <!------------------------------------------------------------------------------------------------------------------>

             <?php 
             IF( $_SESSION['display_docs_part'] == 1 ) // IL S'AGIT DES PARTENAIRES TRAVAUX
             {
             ?>			 
				<li <?php    IF ( $pageName =="Intranet_Documents_partenaire.php"  or 
				                  $pageName =="XXXXXXXXXXXXXXXXXXXX.php"    ) { echo "class=\"start active\"; ";} ?> >
					<a href="Intranet_Documents_partenaire.php">
						<i class="icon-doc"></i>
						<span class="title">
							 <?php echo T_("Documents"); ?>
					</a>
				</li>

             <?php 
             } 
             ?>				



			


                <?php }    ?>

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
