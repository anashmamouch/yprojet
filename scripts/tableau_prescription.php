<?php //Tableau des prescriptions
if(isset($_SESSION['id_affiliate']))
{    
    mysql_query('SET NAMES utf8');  

	if(get_magic_quotes_gpc()) { $id_affiliate  = stripslashes( $_SESSION['id_affiliate'] ); }
			                     $id_affiliate  = trim(ucfirst(strtolower(mysql_real_escape_string( $_SESSION['id_affiliate'] ))));

	// REQUETTE DE REMPLISSAGE DU TABLEAU 
	$sql    = "SELECT r_status, r_creation_date, id_recommandation, r_sub_category, r_first_name, r_last_name, r_status, r_gain, r_managed_date, id_privileged_partner, r_zip_code, r_city 
	           FROM recommandation_details 
			   where id_affiliate=".$id_affiliate." 
			   and r_status > 0 and r_status < 10 order by id_recommandation desc   ";               
    $result = mysql_query($sql) or die("Requete pas comprise !");
	

    // AFFICHAGE DU BANDEAU 
   	echo '<div class="col-md-12" > '; 
   	echo '<div class="col-md-12 note note" > '; 
         echo '<p> '.T_("POUR TOUTE QUESTION SUIVI QUALITÉ").' : <span class="badge badge-info badge-roundless">contact@nosrezo.com </span> '.T_("ou").' <span class="badge badge-info badge-roundless">'.$telephone_call_center.'</span></p>';
         echo '<p> '.T_("CLIQUEZ SUR DÉTAILS POUR AVOIR LES COORDONNÉES DU PARTENAIRE").'.    </p>';
    echo ' </div> ';
    echo ' </div> ';
	

		         echo '<div class="col-md-12 margin-top-20" >';
				 echo '<ul class="nav nav-tabs">';
				          echo '<li class="active"><a href="#tab_2_1" data-toggle="tab">  <i class="fa fa-bar-chart-o"></i> '.T_("EN COURS").' </a></li>';
				          echo '<li ><a href="#tab_2_2" data-toggle="tab"> <i class="fa fa-info"></i> '.T_("FERMÉES").'</a></li>';
				 echo '</ul>';
				 echo '<div class="tab-content">';

                 ///////////////////////////// TAB 2_1  /////////////////////////////////////////////////////////////////////////////////////	 
				 echo '<div id="tab_2_1" class="tab-pane fade in col-md-12 active">';
				 
				  echo '<div class="portlet-body margin-top-10 " >';
				  echo '<div class="table-responsive" >';
				  echo '<table class="table table-striped  table-advance table-hover">'."\n";
				  
                    // première ligne on affiche un en-tête différent
					 echo '<thead>';
				     $background_color = '#4b8df8';
				     $font_color = '#FFFFFF';
                     echo '<tr>';
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-tag"></i> '.T_("CATÉGORIE").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-user"></i> '.T_("NOM").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-globe"></i> '.T_("VILLE").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-star"></i> '.T_("ÉTAPE").'/'.T_("ACTION").'   </th>'; 					 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-money"></i> '.T_("GAINS POTENTIEL ").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-money"></i> '.T_("GAINS BRUT").'   </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-folder-open"></i> '.T_("DOSSIER").'   </th>'; 
					 echo '</thead>';      
                     echo '</tr>'."\n";
				   			   
				   $lien_notation       = 0;
                   $lien_recommandation = 0;
                   $nb_notification_affilie = 0;				   
                   WHILE ($reponse = mysql_fetch_array($result))
                        {                                
                             echo '<tr>'; 					    
							 $lien_notation = $lien_notation + 1;
                             $lien_recommandation = $lien_recommandation + 1;
                         								
                             echo '<td style="text-align:center;" >'.$reponse["r_sub_category"].'</td>';                                                                                                                                                               
						 	 echo '<td style="text-align:center;" >'.$reponse["r_last_name"].' '.$reponse["r_first_name"].'</td>'; 
                             echo '<td style="text-align:center;" >'.$reponse["r_zip_code"].' '.$reponse["r_city"].'</td>';  							 
							 
							 ////ÉTAPE
							 IF ($reponse["r_status"] == 8 ) 
							 {
							     $nb_notification_affilie = $nb_notification_affilie + 1;
								 echo '<form id="Noter_partenaire_'.$lien_notation.'" action="Intranet_Noter_partenaire.php" method="post">';
			                     echo '<input type="hidden" name="id_partner"           value="'.$reponse["id_privileged_partner"].'" />'; 
							     echo '<input type="hidden" name="id_recommandation"    value="'.$reponse["id_recommandation"].'" />';
							     echo '<input type="hidden" name="error_code"           value= 0 />';
							     echo '<td style="text-align:center;" > <a  class="link_label btn red btn-sm" href="#" onclick=\'document.getElementById("Noter_partenaire_'.$lien_notation.'").submit()\'>'.T_("NOTER LE PARTENAIRE").' &nbsp <i class="fa fa-plus"></i> </a></td></form>'; 
							 }
							 ELSE IF ($reponse["r_status"] == 9 AND $reponse["r_gain"]*60 /100 >= 200) 
	                         {
							     echo '<form id="ENCAISSEMENT_'.$lien_notation.'" action="Intranet_ma_remuneration.php" method="post">';
							     echo '<td style="text-align:center;" > <a  class="link_label btn red btn-sm" href="#" onclick=\'document.getElementById("ENCAISSEMENT_'.$lien_notation.'").submit()\'>'.T_("DEMANDE VIREMENT").' &nbsp <i class="fa fa-plus"></i> </a></td></form>'; 
                            }
							 ELSE 
							 { 
							     echo '<td style="text-align:center;" >'.$reponse["r_status"].'</td>';
							 }							 
                             
							 //GAINS POTENTIEL 
							 echo '<td style="text-align:center;" >'.round($reponse["r_gain"]*60 /100 , 1, PHP_ROUND_HALF_DOWN).' €</td>';
							 
							 IF ($reponse["r_status"] > 7 )
							 {
							     echo '<td style="text-align:center;" >'.round($reponse["r_gain"]*60 /100 , 1, PHP_ROUND_HALF_DOWN).' €</td>';
                             }
							 ELSE
							 {
							     echo '<td style="text-align:center;" >0 €</td>';                    
                             }							 

							 echo '<form id="Suivi_recommandation_'.$lien_recommandation.'" action="Intranet_Nouvelle_recommandation_suivi.php" method="post">';
							 echo '<input type="hidden" name="id_recommandation"    value="'.$reponse["id_recommandation"].'" />';
							 echo '<td style="text-align:center;"  title="'.($reponse["r_sub_category"]).'"> <a  class="link_label btn btn-sm yellow" href="#" onclick=\'document.getElementById("Suivi_recommandation_'.$lien_recommandation .'").submit()\'>'.T_("DÉTAILS").' &nbsp <i class="fa fa-plus"></i> </a></td></form>'; 

							 
						     echo '</tr>'."\n";
           				}
                   echo"</table>";
				   
				   
      	         echo ' </div> ';
		         echo ' </div> ';
				 
				 IF ( $nb_notification_affilie == 0 ) // IL N'Y A PERSONNE A NOTER DONC ON FERME EN CAS D'ERREUR
				 {
					 UPDATE_ACTION_NOTIFICATION_STATUS( $_SESSION['id_affiliate'] , 2);
				 }

		         echo '</div>';		// FIN TAB 2_1		 

             ///////////////////////////// TAB 2_2  /////////////////////////////////////////////////////////////////////////////////////	 
			 echo '<div id="tab_2_2" class="tab-pane fade in col-md-12" >';
			 $sql2    = "SELECT r_creation_date, id_recommandation, r_sub_category, r_first_name, r_last_name, r_status, r_gain, r_managed_date, id_privileged_partner , r_zip_code, r_city
			             FROM recommandation_details where id_affiliate=".$id_affiliate." 
						 and r_status in (0, 10) order by id_recommandation desc   ";          
             $result2 = mysql_query($sql2) or die("Requete pas comprise !");
	
				  echo '<div class="portlet-body margin-top-10" >';
				  echo '<div class="table-responsive" >';
				  echo '<table class="table table-striped  table-advance table-hover">'."\n";
				   
                    // PREMIÈRE LIGNE ON AFFICHE UN EN-TÊTE DIFFÉRENT
					 echo '<thead>';
                     echo '<tr>';
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-tag"></i> '.T_("CATÉGORIE").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-user"></i> '.T_("PRÉNOM").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-user"></i> '.T_("NOM").'  </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-star"></i> '.T_("ÉTAPE").'/'.T_("ACTION").'   </th>'; 					 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-money"></i> '.T_("GAINS BRUT").'   </th>'; 
				     echo '<th style="text-align:center; background-color:'.$background_color.'; color:'.$font_color.' " > <i class="fa fa-folder-open"></i> '.T_("DOSSIER").'   </th>'; 
					 echo '</thead>';      
                     echo '</tr>'."\n";
				   			   
				   $lien_notation       = 0;
                   $lien_recommandation = 10000;				   
                   while ($reponse = mysql_fetch_array($result2))
                        {                                
                             echo '<tr>'; 					    
							 $lien_notation = $lien_notation + 1;
                             $lien_recommandation = $lien_recommandation + 1;
                         								
                             echo '<td style="text-align:center;" >'.($reponse["r_sub_category"]).'</td>';                                                                                    
                       	     echo '<td style="text-align:center;" >'.($reponse["r_first_name"]).'</td>';                                                                            
						 	 echo '<td style="text-align:center;" >'.($reponse["r_last_name"]).'</td>';                                                                             


						     
							 if ($reponse["r_status"] == 0 ) 
							 {
							 echo '<td style="text-align:center;" >'.T_("Annulée").'</td>';
							 }
							 else 
							 { 
							 echo '<td style="text-align:center;" >'.$reponse["r_status"].'</td>';
							 }							 
                             
							 IF ($reponse["r_status"] > 7 )
							 {
							 echo '<td style="text-align:center;" >'.round($reponse["r_gain"]*60 /100 , 1, PHP_ROUND_HALF_DOWN).' €</td>';
                             }
							 ELSE
							 {
							 echo '<td style="text-align:center;" >0 €</td>';                    
                             }							 

							 echo '<form id="Suivi_recommandation_'.$lien_recommandation.'" action="Intranet_Nouvelle_recommandation_suivi.php" method="post">';
							 echo '<input type="hidden" name="id_recommandation"    value = "'.$reponse["id_recommandation"].'" />';
							 echo '<td style="text-align:center;"  title="'.$reponse["r_sub_category"].'"> <a  class="link_label btn btn-sm yellow" href="#" onclick=\'document.getElementById("Suivi_recommandation_'.$lien_recommandation .'").submit()\'> '. T_("Détails") .' &nbsp <i class="fa fa-plus"></i> </a></td></form>'; 

							 
						     echo '</tr>'."\n";
           				}
                   echo"</table>";
      	         echo ' </div> ';
		         echo ' </div> ';			 
			 
			 echo '</div>'; 
			 
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 
			 echo '</div>'; 
			 echo '</div>';	
		 
   	echo '<div class="col-md-12 margin-top-20" > '; 	
    echo '<div class="col-md-12 note note margin-top-20">';
	     echo '<p> '.T_("LES").' <span class="badge badge-info badge-roundless">10</span> '.T_("DIFFÉRENTES ÉTAPES DE LA RECOMMANDATION").' : </p>';
    echo '</div> ';	
    echo '</div> ';
	  
       	echo '<div class="col-md-12" > '; 
			 	 echo '<div class="col-md-12" style="text-align:center">';
				     echo '<p> <img style="width:80%;" src= '.lien_etapes_recommandations(10, 1).' ></p>	';     
                 echo '</div>';	
        echo '</div> ';

		
		
				 
        echo ' </div> ';			
}
?>