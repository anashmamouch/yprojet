<?php if(!isset($_SESSION)){session_start();} ?>
<?php mysql_query('SET NAMES utf8'); ?>
<?php require('scripts/function_12345678910.php'); ?>  
<?php require('scripts/functions.php'); ?>  

      <header>
        <div class="side-nav">
          <ul id="gn-menu" class="gn-menu-main">
            <li class="gn-trigger">
              <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
              <nav class="gn-menu-wrapper">
                <div class="gn-scroller">
                  <ul id="main-nav" class="gn-menu">
                    <li><a href="#"><i class="gn-icon linecon-settings"></i>Accueil</a>
                     <ul class="dropdown-menu">
                      <li><a href="#"><i class="gn-icon linecon-settings"></i>Nos Services et Produits</a></li>
                      <li><a href="#"><i class="gn-icon linecon-settings"></i>En Parler</a></li>
                      <li><a href="#"><i class="gn-icon linecon-settings"></i>Développement</a></li>
                      </ul>
                    </li>
               	  <li><a href="#"><i class="gn-icon linecon-settings"></i>Actions</a>
                   	<ul class="dropdown-menu">
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Recommander Service</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Recommander Partenaire</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Suivi de vos Dossiers</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Suivi de vos Equipes</a></li>
                      </ul>
                    </li>
                    <li><a href="#"><i class="gn-icon linecon-settings"></i>Informations</a>
                   	<ul class="dropdown-menu">
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Partenaires</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Documents</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Simulation</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>F.A.Q</a></li>
                      </ul>
                    </li>
                    <li><a href="#"><i class="gn-icon linecon-settings"></i>Mon Compte</a>
                   	<ul class="dropdown-menu">
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Profil</a></li>
                      <li><!-- Ton script --><i class="gn-icon linecon-settings"></i>Deconnexion</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /gn-scroller -->
              </nav>
            </li> 
			
  <?php if(isset($_SESSION['id_affiliate']) or isset($_SESSION['id_partenaire'])) 
		 { ?>
            <li class="logo-wrapper"><a href="index.php"><img src="fichiers/logo_nosrezo.svg" alt="logo"></a></li>
            <li class="cta"><a href="scripts/deconnection.php"><img src="img/deconnexion.png" alt="power" /></a></li>
 			<li class="cta"><a <?php echo '<a'; if(($_SESSION['id_affiliate'] == '1' or $_SESSION['id_affiliate'] == '2') and  check_access_123($_SESSION['id_affiliate']) == 1 and $_SESSION['statut'] = 'A.D.M.I.N') {echo ' href="NosRezo12345678910.php"';}
                                                                                                                                 else if(isset($_SESSION['first_name']) and $_SESSION['id_affiliate']  > 10)           {echo ' href="Intranet_Accueil.php"';}																																
																					                                             else if(isset($_SESSION['first_name']) and $_SESSION['id_partenaire'] > 0 )           {echo ' href="Intranet_partenaire_1.php"';}	
																																 else                                                                                   echo ' href="login.php"' ?> ><img src="img/rocket.png" alt="rocket" /></a></li>			
  <?php } else 
            { ?>
    	         <form name="p_action"  action="login.php" method="post"> 
	             <script language="JavaScript">document.p_action.submit();</script></form> 
  <?php }	 ?>	
  
		  </ul>
        </div>
      </header>
