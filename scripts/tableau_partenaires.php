<?php //Liste déroulante des services
if(isset($_SESSION['id_affiliate']))
{   
     $nb_rows = 4;
	 if (!isset($_POST['count_partenaires']))    {$_POST['count_partenaires']     = count_partenaires(0);}
     if (!isset($_POST['first_page']))           {$_POST['first_page']            = 1;}	 
	 if (!isset($_POST['range_min_query']))      {$_POST['range_min_query']       = 0;}	 
	 if (!isset($_POST['row_max_page']))         {$_POST['row_max_page']          = $nb_rows;}	 
	 if (!isset($_POST['count_page']))           {$_POST['count_page']            = nb_page_tableau($nb_rows, count_partenaires(0) );}
	 if (!isset($_POST['service_immobilier']))   {$_POST['service_immobilier']    = 0;}	 
	 if (!isset($_POST['id_partenaire']))        {$_POST['id_partenaire']         = 0;}




    $nb_partenaires   = count_partenaires($_POST['service_immobilier']);    // Total de partenaires
             if  ($_POST['id_partenaire'] != 0) {$nb_partenaires   = 1; }   // Total de partenaires
	$premiere_page    = $_POST['first_page'];                               // La page en cours à afficher            
	$range_min_page   = $_POST['range_min_query'];                          // Range min pour lancer la query   	
	$row_maxx_page    = 3;                                                  // Nombre de ligne max par page à afficher
	$compte_page      = nb_page_tableau(3,$nb_partenaires);                 // Nombre de page à afficher     
	$service_immo     = $_POST['service_immobilier'];                       // Service sur lequel nous souhaitons filtrer     	
    $id_partner       = $_POST['id_partenaire'];;
	
	// REQUETE DE REMPLISSAGE DU TABLEAU DES PARTENAIRES //////////////////////////////////////////////
	         if  (($_POST['service_immobilier'] == 0) and ($_POST['id_partenaire'] == 0))              
	              {$sql = "SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact , p_sub_category,  p_secteur, p_fonction, recommanded_by, nb_interventions, percent_satisfaction, id_image FROM partner_list pl, partner_notation pn where pl.id_partner = pn.id_partner_notation and is_activated = 1 order by id_services limit ".$range_min_page.",".$row_maxx_page." ";}               
	         if  (($_POST['service_immobilier'] == 0) and ($_POST['id_partenaire'] != 0))              
	              {$sql = "SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_sub_category,  p_secteur, p_fonction, recommanded_by, nb_interventions, percent_satisfaction, id_image FROM partner_list pl, partner_notation pn where pl.id_partner = pn.id_partner_notation and is_activated = 1 and id_partner = ".$id_partner." ";} 	
	         if  (($_POST['service_immobilier'] != 0) and ($_POST['id_partenaire'] == 0))              
	              {$sql = "SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_sub_category,  p_secteur, p_fonction, recommanded_by, nb_interventions, percent_satisfaction, id_image FROM partner_list pl, partner_notation pn where pl.id_partner = pn.id_partner_notation and is_activated = 1 and id_services = ".$service_immo."  order by id_partner limit ".$range_min_page.",".$row_maxx_page." ";} 
	         if  (($_POST['service_immobilier'] != 0) and ($_POST['id_partenaire'] != 0))              
	              {$sql = "SELECT id_partner, CONCAT( p_first_name, ' ', p_last_name ) AS p_contact, p_sub_category,  p_secteur, p_fonction, recommanded_by, nb_interventions, percent_satisfaction, id_image FROM partner_list pl, partner_notation pn where pl.id_partner = pn.id_partner_notation and is_activated = 1 and id_partner = ".$id_partner." ";} 	

        $result = mysql_query($sql) or die("Requete pas comprise #345 - Maintenance !");

		
    // AFFICHAGE DU BANDEAU ////////////////////////////////////////////////////////////////////////////
    echo '    <p> <b> </p>';	
	echo '<div id="tab_partenaire_1" style="width:610px; height:90px; margin-left:-15px; background-color:#f5f6f7;">';
	echo '     <div id="tab_partenaire_1" style="width:460px; height:70px; background-color:#f5f6f7; border-width:0px; margin-left:12px; margin-top:12px;">';
	
    ///////////////////LISTE DEROULANTE DES SERVICES ////////////////////////////////////////////////////
                     $sql_service = "SELECT id_services, s_sub_category, s_category  FROM services where is_activated=1 and type =\"services\" and id_services <> 30 order by order_affichage";
                     $result_service = mysql_query($sql_service) or die("Requete pas comprise");

				    echo '<form id="filtre_partenaire_actif" action="Intranet_Partenaires.php" method="post">	    '; 
                        echo " <label style='margin-left:15px;'><img src='fichiers/carre_bleu3.PNG'>  Nos Services : </label><select style='font-size:11px;' name='service_immobilier' onChange=\"filtre_partenaire_actif.submit()\" >";
                        //PREMIERE LIGNE DIFFERENTE ON AFFICHE : TOUS SERVICES                    
                        echo" <option style='font-size:11px;' value='0';";if ($_POST['service_immobilier'] == 0) {echo" selected='selected' ";} echo" >-- Tous Services -- </option> ; ";
					 
					    while ($row=mysql_fetch_array($result_service))   { 
					      echo" <option style='font-size:11px;' value=".utf8_encode($row[0])." ; ";
					      if ($_POST['service_immobilier'] == $row[0]) {echo" selected='selected' ";}
					      echo" >".ucfirst(utf8_encode($row[2]))." - ".utf8_encode($row[1])."</option>"; }
                        echo" </select><br />";
                    
		                echo '<input type="hidden" name="first_page"                 value = 1 /> ';
						echo '<input type="hidden" name="range_min_query"            value = 0 />';
					    echo '<input type="hidden" name="id_partenaire"              value = 0  /> ';						

	                echo '</form>';
					
    ///////////////////LISTE DEROULANTE DES NOMS ////////////////////////////////////////////////////
	                 if  ($_POST['service_immobilier'] == 0)               
	                     {$sql2 = "SELECT id_partner, CONCAT( p_last_name , ' ', p_first_name ) AS p_contact, p_sub_category,  p_secteur, p_fonction, recommanded_by FROM partner_list WHERE is_activated=1 order by p_last_name ";}               
                     else                                              //ON AFFICHE QUE LE SERVICE VOULU
	                    {$sql2 = "SELECT id_partner, CONCAT( p_last_name , ' ', p_first_name ) AS p_contact, p_sub_category,  p_secteur, p_fonction, recommanded_by FROM partner_list WHERE is_activated=1 and id_services = ".$service_immo."  order by p_last_name ";} 
	                    $result_nom = mysql_query($sql2) or die("Requete pas comprise !");


				    echo '<form id="filtre_partenaire_nom" action="Intranet_Partenaires.php" method="post">	    '; 
                        echo " <label style='margin-left:15px;'><img src='fichiers/carre_bleu3.PNG'>  Partenaires : </label><select style='font-size:11px;' name='id_partenaire' onChange=\"filtre_partenaire_nom.submit()\" >";
                        //PREMIERE LIGNE DIFFERENTE ON AFFICHE : TOUS SERVICES                    
                        echo" <option style='font-size:11px;' value='0';";if ($_POST['id_partenaire'] == 0) {echo" selected='selected' ";} echo" >-- Tous Partenaires -- </option> ; ";
					 
					    while ($row_nom=mysql_fetch_array($result_nom))   { 
					      echo" <option value=".utf8_encode($row_nom[0])." ; ";
					      if ($_POST['id_partenaire'] == $row_nom[0]) {echo" selected='selected' ";}
					      echo" >".utf8_encode($row_nom[1])." - ".utf8_encode($row_nom[2])."</option>"; }
                        echo" </select><br />";
                    
		                echo '<input type="hidden" name="first_page"                 value = 1 /> ';
						echo '<input type="hidden" name="range_min_query"            value = 0 />';
						echo '<input type="hidden" name="service_immobilier"         value = '.$service_immo.'  /> ';

	                echo '</form>';

	if  ($_POST['id_partenaire'] != 0)	// ON AFFICHE PARTENAIRE AU SINGULIER CAR 1 SEUL SELECTIONNE		
	{echo '         <p style="margin-left:15px; margin-top:0px;"> <img src=\'fichiers/carre_bleu3.PNG\'>  Partenaire NosRezo :  <font color=#fa38a3>'.$nb_partenaires.'</font></b></p>';}
	else                                // ON AFFICHE AU PLURIEL
	{echo '         <p style="margin-left:15px; margin-top:0px;"> <img src=\'fichiers/carre_bleu3.PNG\'>  Nombre de Partenaires NosRezo :  &nbsp  &nbsp  <font color=#fa38a3>'.$nb_partenaires.'</font></b></p>';}

    echo '     </div> ';
	
	
    echo ' <div id="tab_partenaire_1" style="width:80px; height:35px; margin-right:-15px; margin-top:35px;  background-color:#FFFFFF; float:right;" > '; 
    ///////////////////GESTION DES FLECHES GAUCHE ET DROITE ////////////////////////////////////////////////////
	if($premiere_page != 1) {
			            echo '<form id="page_gauche" action="Intranet_Partenaires.php" method="post">	    ';
		                echo '<input type="hidden" name="count_partenaires"          value = '.$nb_partenaires.' /> ';			
		                echo '<input type="hidden" name="first_page"                 value = '.($premiere_page - 1).' /> ';
						echo '<input type="hidden" name="range_min_query"            value = '.($range_min_page - $row_maxx_page).' />';
			            echo '<input type="hidden" name="range_max_query"            value = '.$row_maxx_page.' />';
						echo '<input type="hidden" name="row_max_page"               value = '.$row_maxx_page.'   /> ';
		                echo '<input type="hidden" name="count_page"                 value = '.$compte_page.'  /> ';
					    echo '<input type="hidden" name="service_immobilier"         value = '.$service_immo.'  /> ';
					    echo '<input type="hidden" name="id_partenaire"              value = '.$id_partner.'  /> ';						
	                    echo '<a title="'.$row_maxx_page.' partenaires précedents" href="#" onclick="document.getElementById(\'page_gauche\').submit();" ><img id="concept_1_light" style="margin-left:5px;" src=\'fichiers/fleche_grise_gauche.PNG\'></a></form> ';
                           }
						   
	if($premiere_page != $compte_page) 
	            {	
			            echo '<form id="page_droite" action="Intranet_Partenaires.php" method="post">	    ';
		                echo '<input type="hidden" name="count_partenaires"          value = '.$nb_partenaires.' /> ';			
		                echo '<input type="hidden" name="first_page"                 value = '.($premiere_page + 1).' /> ';
						echo '<input type="hidden" name="range_min_query"            value = '.($range_min_page + $row_maxx_page).' />';
			            echo '<input type="hidden" name="range_max_query"            value = '.$row_maxx_page.' />';
						echo '<input type="hidden" name="row_max_page"               value = '.$row_maxx_page.'   /> ';
		                echo '<input type="hidden" name="count_page"                 value = '.$compte_page.'  /> ';
					    echo '<input type="hidden" name="service_immobilier"         value = '.$service_immo.'  /> ';
					    echo '<input type="hidden" name="id_partenaire"              value = '.$id_partner.'  /> ';						
	                    echo '<a title="'.$row_maxx_page.' partenaires suivants" href="#" onclick="document.getElementById(\'page_droite\').submit();" ><img id="concept_1_light" style="float:right; margin-right:5px;" src=\'fichiers/fleche_grise_droite.PNG\'></a></form> ';
                } 
    echo '       </div> ';
    echo ' </div> ';

    ///////////////////ON REMPLI LE TABLEAU DES PARTENAIRES ////////////////////////////////////////////////////
	               $lien_notation = 0; // Afin d'avoir un lien dynamique
                   while ($reponse = mysql_fetch_array($result))
                        {  
						  $image_partenaire = 'fichiers/partenaires/partenaire_'.$reponse["id_partner"].'.PNG';
						  IF (!file_exists($image_partenaire))   { $image_partenaire = 'fichiers/partenaires/partenaire_0.PNG'; }
                          $lien_notation = $lien_notation + 1; // Lien unique						
                          echo '<div style="width:600px; height:10px;  background-color:#FFFFFF; float: left" > </div> ';
                          echo '<div style="width:600px; height:120px; background-color:#FFFFFF; float: left; margin-left:-10px;" > ';
                          echo '     <div id="tab_partenaire_1" >    ';
                          echo '            <div id="tab_partenaire_1" style="width:70px; height:96px; margin-left:5px; margin-top: -10px;" > ';
                          echo '                <img style="width:100%; border-radius:10px; " src=\''.$image_partenaire.'\' >';
                          echo '             </div>';
                          echo '            <p>  &nbsp <b><font color=#fa38a3>'.utf8_encode($reponse["p_sub_category"]).' </font></b></p> ';
                          echo '            <p style="line-height:4px;"> &nbsp &nbsp &nbsp <u> Nom</u> : <b>&nbsp &nbsp'.utf8_encode($reponse["p_contact"]).' </b></p>';
                          echo '            <p style="line-height:4px;"> &nbsp &nbsp &nbsp <u> Fonction</u> : <b>&nbsp &nbsp'.utf8_encode($reponse["p_fonction"]).' </b></p>';
                          echo '            <p style="line-height:4px;"> &nbsp &nbsp &nbsp <u> Secteur</u> : <b>&nbsp &nbsp'.utf8_encode($reponse["p_secteur"]).' </b></p>';						  
					//	  echo '            <p style="line-height:4px;"> &nbsp &nbsp &nbsp <u> Recommandé par</u> : <b>&nbsp &nbsp'.utf8_encode($reponse["prenom"]).' '.utf8_encode($reponse["nom_du_reco"]).' </b> </p>';
						  echo '     </div> ';
						  echo '     <div id="tab_partenaire_1" style="width:205px; margin-left: 5px;" > ';
						                     if ($reponse["nb_interventions"] >= 1)  { 
									                                                 if ($reponse["nb_interventions"] == 1) {$nbintervention = "&nbsp Moyenne sur 1 intervention";}
																					 if ($reponse["nb_interventions"] > 1)  {$nbintervention = "&nbsp Moyenne sur ".$reponse["nb_interventions"]." interventions";}																	 
									   							                     echo '<form id="Notes_des_partenaires_'.$lien_notation.'" action="Intranet_Notes_des_partenaires.php" method="post">';
			                                                                         echo '            <input type="hidden"   name="id_partner"           value="'.$reponse["id_partner"].'" />'; 
                                                                                     echo '            <input type="hidden"   name="nb_recommandation"    value="'.$reponse["nb_interventions"].'" />';
						                                                             echo '<p><b>  &nbsp <a  class="link_label"  href="#" onclick=\'document.getElementById("Notes_des_partenaires_'.$lien_notation.'").submit()\'> &nbsp'.$nbintervention.' </a></b></p></form>';
																					 }
						               else if ($reponse["nb_interventions"] == 0)  { 
											                                         $nbintervention = "&nbsp &nbsp Pas encore d'intervention";
																					 echo '            <p><b>  &nbsp &nbsp'.$nbintervention.' </b></p>';
																					 }

																					 
																					 
						  echo '            <p style="line-height:4px;">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <img style="border-radius:10px;" src=\'fichiers/partenaires/etoile_'.$reponse["id_image"].'_5.PNG\' >	</p>';
						  echo '            <p><b>  &nbsp &nbsp &nbsp &nbsp &nbsp '.$reponse["percent_satisfaction"].'% de satisfaction </b></p>';
						  echo '     </div> 			  ';
                          echo '</div>     ';
						
           				}
                   echo"</table>";
}
?>