<?php  function SEND_PAIEMENT_EMAIL_LATTERAL($connection_database, $id_affiliate_latteral, $id_recommandation, $id_upline)
{      include('scripts/config.php');  

	 // REQUETTE DE REMPLISSAGE DU MAIL 
     mysql_query('SET NAMES utf8');
     $resultat              = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate FROM affiliate_details where id_affiliate =".$id_affiliate_latteral."   ")) or die("Requete pas comprise - #31! ");
	 $mail                  = $resultat['email'];
	 //$mail                  = 'benjamin.allais@gmail.com';
     $first_name_latteral   = $resultat['first_name']; 
	 

     IF ($id_upline > 10)
	 {
	 $result_parrain        = mysql_fetch_array(mysql_query(" SELECT first_name, last_name, zip_code, email, city, id_affiliate FROM affiliate_details where id_affiliate =".$id_upline."   ")) or die("Requete pas comprise - #3azAA1! ");
     $first_name_parrain    = $result_parrain['first_name'];
	 }
	 ELSE
	 {
	 $first_name_parrain    = "Christophe";	 
	 }
	 

	 $result4 = mysql_query(" SELECT aX_id_affiliate, aX_level, aX_amount_ht, first_name FROM recommandation_comptable rc, affiliate_details ad  WHERE  rc.id_recommandation = ".$id_recommandation ." and rc.aX_id_affiliate = ad.id_affiliate  order by aX_level    ")  or die(" Requete coordonnees : 36ssTXPSSA pas comprise. ");			
     $aX_amount_ht_0 = 0.00;
	 $aX_amount_ht_1 = 0.00;
	 $aX_amount_ht_2 = 0.00;
	 $aX_amount_ht_3 = 0.00;
	 $aX_amount_ht_4 = 0.00;
	 $aX_amount_ht_5 = 0.00;
	 $aX_amount_ht_6 = 0.00;
	 
     $first_name_0 = "NosRezo";
	 $first_name_1 = "NosRezo";
	 $first_name_2 = "NosRezo";
	 $first_name_3 = "NosRezo";
	 $first_name_4 = "NosRezo";
	 $first_name_5 = "NosRezo";
	 $first_name_6 = "NosRezo";	 
	 
				 
 	 while ($reponse4 = mysql_fetch_array($result4))
         {  
             $aX_level        = $reponse4["aX_level"];
			 $aX_amount_ht    = $reponse4["aX_amount_ht"];
			 $aX_first_name   = $reponse4["first_name"];
			 IF ($aX_level == 0) { $aX_amount_ht_0 = $aX_amount_ht;  $first_name_0 = $aX_first_name;    }
			 IF ($aX_level == 1) { $aX_amount_ht_1 = $aX_amount_ht;  $first_name_1 = $aX_first_name;    }
			 IF ($aX_level == 2) { $aX_amount_ht_2 = $aX_amount_ht;  $first_name_2 = $aX_first_name;    }
			 IF ($aX_level == 3) { $aX_amount_ht_3 = $aX_amount_ht;  $first_name_3 = $aX_first_name;    }
			 IF ($aX_level == 4) { $aX_amount_ht_4 = $aX_amount_ht;  $first_name_4 = $aX_first_name;    }
			 IF ($aX_level == 5) { $aX_amount_ht_5 = $aX_amount_ht;  $first_name_5 = $aX_first_name;    }
			 IF ($aX_level == 6) { $aX_amount_ht_6 = $aX_amount_ht;  $first_name_6 = $aX_first_name;    }			 

		 }	 
	 	 
	 		 
IF (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
     {$passage_ligne = "\r\n";}
else
     {$passage_ligne = "\n"; }

$src = 'http://www.nosrezo.com/fichiers/nosrezo_banniere_mail.PNG';
$src_carre = 'http://www.nosrezo.com/fichiers/carre_bleu3.PNG';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$message_txt = "script PHP.";
$message_html = "



<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta name='viewport' content='width=device-width; initial-scale=1.0; maximum-scale=1.0;'>
<title></title>

<style type='text/css'>

div, p, a, li, td { -webkit-text-size-adjust:none; }

.ReadMsgBody
{width: 100%; background-color: #ffffff;}
.ExternalClass
{width: 100%; background-color: #ffffff;}
body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;}
html{width: 100%;}

@font-face {
    font-family: 'proxima_novalight';src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-light-webfont.eot');src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-light-webfont.eot?#iefix') format('embedded-opentype'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-light-webfont.woff') format('woff'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-light-webfont.ttf') format('truetype');font-weight: normal;font-style: normal;}

@font-face {
    font-family: 'proxima_nova_rgregular'; src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-regular-webfont.eot');src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-regular-webfont.eot?#iefix') format('embedded-opentype'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-regular-webfont.woff') format('woff'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-regular-webfont.ttf') format('truetype');font-weight: normal;font-style: normal;}

@font-face {
    font-family: 'proxima_novasemibold';src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-semibold-webfont.eot');src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-semibold-webfont.eot?#iefix') format('embedded-opentype'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-semibold-webfont.woff') format('woff'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-semibold-webfont.ttf') format('truetype');font-weight: normal;font-style: normal;}
    
@font-face {
	font-family: 'proxima_nova_rgbold';src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-bold-webfont.eot');src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-bold-webfont.eot?#iefix') format('embedded-opentype'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-bold-webfont.woff') format('woff'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-bold-webfont.ttf') format('truetype');font-weight: normal;font-style: normal;}
	
@font-face {
    font-family: 'proxima_novablack';src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-black-webfont.eot');src: url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-black-webfont.eot?#iefix') format('embedded-opentype'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-black-webfont.woff') format('woff'),url('http://rocketway.net/themebuilder/template/templates/titan/font/proximanova-black-webfont.ttf') format('truetype');font-weight: normal;font-style: normal;}

p {padding: 0!important; margin-top: 0!important; margin-right: 0!important; margin-bottom: 0!important; margin-left: 0!important; }

.hover:hover {opacity:0.85;filter:alpha(opacity=85);}

#box { -webkit-animation: bounceInLeftFast 2s; -moz-animation: bounceInLeftFast 2s; -o-animation: bounceInLeftFast 2s; animation: bounceInLeftFast 2s; }

@-webkit-keyframes bounceInLeftFast {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

@-moz-keyframes bounceInLeftFast {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

@-o-keyframes bounceInLeftFast {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

#box2 { -webkit-animation: bounceInLeftSlow 3s; -moz-animation: bounceInLeftSlow 3s; -o-animation: bounceInLeftSlow 3s; animation: bounceInLeftSlow 3s; }

@-webkit-keyframes bounceInLeftSlow {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

@-moz-keyframes bounceInLeftSlow {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

@-o-keyframes bounceInLeftSlow {
  0% { opacity: 0; -webkit-transform: translateY(-2000px); transform: translateY(-2000px); }
  60% { opacity: 1; -webkit-transform: translateY(20px); transform: translateY(20px); }
  80% { -webkit-transform: translateY(-5px); transform: translateY(-5px); }
  100% { -webkit-transform: translateY(0); transform: translateY(0); }
}

.fullImage img {width: 600px; height: auto; text-align: center; }
.img254 img {width: 600px!important; height: auto!important; text-align: center!important; clear: both; }
.image180 img {width: 180px; height: 180px; border-radius: 100%!important;}
.image142 img {width: 142px; height: 142px; border-radius: 100%!important;}
.image188 img {width: 188px; height: 188px; border-radius: 100%!important;}
.bigImage img {width: 600px; height: auto; border-radius: 5px!important;}
.small_img1 img {width: 101px; height: auto;}
.socialIcons img {width: 16px!important; height: auto;}
.logo img {width: 180px; height: auto;}

</style>


<!-- @media only screen and (max-width: 640px) 
		   {*/
		   -->
<style type='text/css'> @media only screen and (max-width: 640px){
		body{width:auto!important;}
		table[class=full] {width: 100%!important; clear: both; }
		table[class=mobile] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; }
		table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		.erase {display: none;}
		table[class=fullImage] {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		.fullImage img {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		table[class=image180] {width: 100%!important; text-align: center!important;}
		table[class=image142] {width: 100%!important; text-align: center!important;}
		table[class=small_img1] {width: 100%!important; text-align: center!important;}
		table[class=bigImage] {width: 100%!important; text-align: center!important;}
		.bigImage img {width: 100%!important; text-align: center!important; border-radius: 5px;}
		table[class=image188] {width: 100%!important; text-align: center!important;}
		table[class=img254] {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		.img254 img {width: 254px!important; height: auto!important; text-align: center!important; clear: both; }
		td[class=h15] {height: 15px!important;}
		.buttonPad {padding-left: 20px!important; padding-right: 20px!important;}
		.nbsp {display: none;}
		.floatCenter {text-align: center!important; float: center!important; }
		
} </style>
<!--

@media only screen and (max-width: 479px) 
		   {
		   -->
<style type='text/css'> @media only screen and (max-width: 479px){
		body{width:auto!important;}
		table[class=full] {width: 100%!important; clear: both; }
		table[class=mobile] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; }
		table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		.erase {display: none;}
		img[class=fullImage] { width: 100%!important; height: auto!important; }
		table[class=fullImage] {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		.fullImage img {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		table[class=image180] {width: 100%!important; text-align: center!important;}
		table[class=image142] {width: 100%!important; text-align: center!important;}
		table[class=small_img1] {width: 100%!important; text-align: center!important;}
		table[class=bigImage] {width: 100%!important; text-align: center!important;}
		.bigImage img {width: 100%!important; text-align: center!important; border-radius: 5px;}
		table[class=image188] {width: 100%!important; text-align: center!important;}
		table[class=img254] {width: 100%!important; height: auto!important; text-align: center!important; clear: both; }
		.img254 img {width: 254px!important; height: auto!important; text-align: center!important; clear: both; }
		td[class=h15] {height: 15px!important;}
		.buttonPad {padding-left: 20px!important; padding-right: 20px!important;}
		.nbsp {display: none;}
		.floatCenter {text-align: center!important; float: center!important;}
				
		}
} </style>



<!-- Wrapper 1 -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full'  cu-identifier='element_09225916285067797' style='position: relative; z-index: 0;'>
	<tr>
		<td width='100%' valign='top' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
		
		
			<!-- Nav Mobile Wrapper -->
			<table width='600' border='0' cellpadding='0' cellspacing='0' align='center' class='mobile'>
				<tr>
					<td width='100%'>
					
						<!-- Start Nav -->
						<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full'>
							<tr>
								<td width='100%' height='10'></td>
							</tr>
							<tr>
								<td width='100%' valign='middle' class='logo'>
									
									<!-- Logo -->
									<table width='150' border='0' cellpadding='0' cellspacing='0' align='left' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='fullCenter'>
										<tr>
											<td height='60' valign='middle' width='100%' style='text-align: left;' class='fullCenter'>
												<a href='#' ><img width='150' src='http://www.nosrezo.com/assets/img/logo_nosrezo.png' alt='' border='0'  cu-identify='element_023090786347165704'></a>
											</td>
										</tr>
									</table>
													
								</td>
							</tr>
							<tr>
								<td width='100%' height='10'></td>
							</tr>
						</table><!-- End Nav -->
						
					</td>
				</tr>
			</table><!-- End Nav Mobile Wrapper -->
			
			
		</td>
	</tr>
</table><div style='display: none;' id='element_09130165241658688'></div>
<!-- End Wrapper 1 -->

<!-- Wrapper 2 -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full' >
	<tr>
		<td width='100%' valign='top' bgcolor='#323a45'style='background-color: rgb(71, 176, 215);'>
		
								
			<!-- Wrapper -->
			<table width='600' border='0' cellpadding='0' cellspacing='0' align='center' class='mobile'>
				<tr>
					<td width='100%'>
						
						<!-- Header Image -->
						<table width='600' border='0' cellpadding='0' cellspacing='0' align='left' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='fullImage'>
							<tr>
								<td width='100%' height='50'></td>
							</tr>
							
							<tr>
								<td height='auto' valign='bottom' width='100%' style='text-align: center; font-family: Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); font-size: 13px; line-height: 20px; font-weight: normal;'class='textCenter' id='box2' >
									<span  cu-identify='element_04206447440665215'>Bonjour <b>$first_name_latteral</b>, pour ton information un email que vient de recevoir un autre filleul de <b>$first_name_parrain</b>, simplement pour avoir recommandé le meilleur professionnel de son quartier : <br /> 
									<br />
									<br />
									</span>
								</td>
							</tr>							

							<tr>
								<td valign='bottom' width='100%' style='text-align: center; font-family: Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); font-size: 44px; line-height: 48px; font-weight: 100;'class='textCenter' id='box' >
									<span  cu-identify='element_07997812125831842'><!--[if !mso]><!--><span style='font-family: 'proxima_novalight', Helvetica;'><!--<![endif]-->$first_name_0, <!--[if !mso]><!--></span><!--<![endif]--></span>
								</td>
							</tr>
							<tr>
								<td width='100%' height='20'></td>
							</tr>
							<tr>
								<td width='100%' height='20'></td>
							</tr>
							<tr>
								<td height='auto' valign='bottom' width='100%' style='text-align: center; font-family: Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); font-size: 13px; line-height: 20px; font-weight: normal;'class='textCenter' id='box2' >
									<span  cu-identify='element_04206447440665215'>La vente de la recommandation <b>R$id_recommandation </b> est réalisée et nous venons de recevoir le règlement du partenaire. <br /> 
									<br />
									Votre compte est crédité de <b> $aX_amount_ht_0 €  </b> BRUT.	<br/>
									<br/>
									La rémunération brute en cascade :<br/>
                                         $first_name_0 :  <b> $aX_amount_ht_0 € </b> <br />
                                         <u>Niveau 1</u>,  $first_name_1 : <b> $aX_amount_ht_1  € </b> <br />
                                         <u>Niveau 2</u>,  $first_name_2 : <b> $aX_amount_ht_2  € </b> <br />
                                         <u>Niveau 3</u>,  $first_name_3 : <b> $aX_amount_ht_3  € </b> <br />
                                         <u>Niveau 4</u>,  $first_name_4 : <b> $aX_amount_ht_4  € </b> <br />
                                         <u>Niveau 5</u>,  $first_name_5 : <b> $aX_amount_ht_5  € </b> <br />
                                         <u>Niveau 6</u>,  $first_name_6 : <b> $aX_amount_ht_6  € </b> <br />

									</span><!--<![endif]-->
								</td>
							</tr>
							<tr>
								<td width='100%' height='0'></td>
							</tr>

							<tr>
								<td width='100%' height='0'></td>
							</tr>

							
						</table>
						
					</td>
				</tr>
			</table><!-- End Wrapper -->	
		</td>
	</tr>
</table>

<!-- Wrapper 14 -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full' >
	<tr>
		<td width='100%' valign='top' bgcolor='#ffffff'>

			<!-- Wrapper -->
			<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full'>
				<tr>
					<td>
					
						<!-- Space -->
						<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' style='border-collapse: collapse; background-color: rgb(71, 176, 215); ' bgcolor='#323a45' class='full'>
							<tr>
								<td width='100%' height='25'></td>
							</tr>
						</table><!-- End Space -->
									
						<!-- Trianle -->
						<table bgcolor='#6998a0'width='100%' border='0' cellpadding='0' cellspacing='0' align='center' style='border-collapse: collapse; background-color: rgb(0, 214, 250);' class='full'>
							<tr>
								<td width='100%'>
									
									<!-- Triangle Code for every email client by RocketWay -->
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='9' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='2' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='9' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='8' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='4' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='8' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='7' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='6' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='7' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='6' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='8' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='6' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='5' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='10' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='5' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='4' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='12' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='4' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='3' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='14' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='3' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='2' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='16' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='2' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='1' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='18' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='0' height='1'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='20' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.1;'></td><td width='0' height='1'></td>
										</tr>
									</table>
									<table width='24' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
										<tr>
											<td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td><td width='22' height='1' bgcolor='#ffffff'></td><td width='1' height='1' bgcolor='#ffffff' style='opacity:0.7;'></td>
									</tr></table>																		
								</td>
							</tr>
						</table><!-- End Triangle -->
						
						
					</td>
				</tr>
			</table><!-- End Wrapper -->
		
		
		</td>
	</tr>
</table><!-- Wrapper 14 -->

<!-- Wrapper 15 -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full' >
	<tr>
		<td width='100%' valign='top' bgcolor='#ffffff'>
		
			
			<!-- Wrapper -->
			<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='mobile'>
				<tr>
					<td>
						
						<!-- Wrapper -->
						<table width='600' border='0' cellpadding='0' cellspacing='0' align='center' class='full'>
							<tr>
								<td width='100%'>
									
									<!-- Big Image 1 600px -->
									<table width='600' border='0' cellpadding='0' cellspacing='0' align='left' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='bigImage'>
										<tr>
											<td width='100%' height='70'></td>
										</tr>
										<tr>
											<td width='100%' class='fullCenter' style='text-align: center;'><a href='#' style='text-decoration: none;' ><img src='http://www.nosrezo.com/assets/img/email/article.png' width='600' height='auto' style='width: 600px; height: auto; border-radius: 5px;' alt='' border='0'  class='hover'></a>
											</td>
										</tr>
										<tr>
											<td width='100%' height='30'></td>
										</tr>

										<tr>
											<td width='100%' height='25'></td>
										</tr>
										<tr>
											<td width='100%' style='font-size: 14px; color: rgb(141, 148, 153); text-align: left; font-family: Helvetica, Arial, sans-serif; line-height: 22px; vertical-align: top; font-weight: normal;'>	
												<!--[if !mso]><!--><span style='font-family: 'proxima_nova_rgregular', Helvetica;'><!--<![endif]--> Vous pouvez dès à présent suivre les étapes de paiement dans votre Intranet NosRezo, à commencer par noter la prestation de notre partenaire.<!--[if !mso]><!--></span><!--<![endif]-->
											</td>
										</tr>

										<tr>
											<td width='100%' height='40'></td>
										</tr>

										
										<!-- Button -->
										<tr>
											<td valign='middle' width='100%' class='fullCenter'>
												<table border='0' cellpadding='0' cellspacing='0' align='center' style='float: left;' class='floatCenter'>
													<tr>
														<td align='center' valign='middle' bgcolor='#6998a0'style='color: rgb(255, 255, 255); font-family: Helvetica, Arial, sans-serif; font-size: 13px; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; display: block; padding: 8px 20px; line-height: 22px; vertical-align: middle; background-color: rgb(0, 214, 250);' ><!--[if !mso]><!--><span style='font-family: 'proxima_nova_rgregular', Helvetica;'><!--<![endif]--><a href='http://www.nosrezo.com/login.php' style='color: rgb(255, 255, 255); font-size: 16px; text-decoration: none; line-height: 20px;'class='hover' > Se Connecter à NosRezo ! </a><!--[if !mso]><!--></span><!--<![endif]-->
														</td> 
													</tr>
												</table>
											</td>
										</tr>

										<tr>
											<td width='100%' height='40'></td>
										</tr>
										
										<tr>
											<td width='100%' style='font-size: 14px; color: rgb(141, 148, 153); text-align: left; font-family: Helvetica, Arial, sans-serif; line-height: 22px; vertical-align: top; font-weight: normal;'>	
												<!--[if !mso]><!--><span style='font-family: 'proxima_nova_rgregular', Helvetica;'><!--<![endif]-->Rejoignez-nous sur notre page <a href='http://www.facebook.com/pages/Nosrezo/331807033627841'>Facebook</a>  <!--[if !mso]><!--></span><!--<![endif]--><br/>
											</td>
										</tr>
										
										<tr>
											<td width='100%' height='8'></td>
										</tr>
										
									</table>
									
								</td>
							</tr>
						</table><!-- End Wrapper 2 -->
						
						<!-- Space -->
						<table width='100%' border='0' cellpadding='0' cellspacing='0' align='left' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='full'>
							<tr>
								<td width='100%' height='50'></td>
							</tr>
						</table><!-- End Space -->
						
					</td>
				</tr>
			</table><!-- End Wrapper -->
		
		
		</td>
	</tr>
</table><!-- Wrapper 15 -->


<!-- Wrapper 24 -->
<div style='display: none;' id='element_05757187076378614'></div><!-- Wrapper 24 -->

<!-- Wrapper 25 -->
<div style='display: none;' id='element_01461133025586605'></div><!-- Wrapper 25 -->

<!-- Wrapper 26 -->
<div style='display: none;' id='element_03594634479377419'></div><!-- Wrapper 26 -->

<!-- Wrapper 27 -->
<div style='display: none;' id='element_003359017241746187'></div><!-- Wrapper 27 -->

<!-- Wrapper 28 -->
<div style='display: none;' id='element_011826015263795853'></div><!-- Wrapper 28 -->

<!-- Wrapper 29 -->
<div style='display: none;' id='element_015242550359107554'></div><!-- Wrapper 29 -->

<!-- Wrapper 30 -->
<div style='display: none;' id='element_02379202840384096'></div><!-- Wrapper 30 -->

<!-- Wrapper 31 -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='full'  cu-identifier='element_0963052642531693'>
	<tr>
		<td width='100%' valign='top' bgcolor='#6998a0'style='background-color: rgb(0, 214, 250);'>
		
			
			<!-- Wrapper -->
			<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' class='mobile'>
				<tr>
					<td>
					
						
						<!-- Wrapper -->
						<table width='600' border='0' cellpadding='0' cellspacing='0' align='center' class='full'>
							<tr>
								<td width='100%'>
									
									<!-- Text Left -->
									<table width='275' border='0' cellpadding='0' cellspacing='0' align='left' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='fullCenter'>
										<tr>
											<td width='100%' style='font-size: 18px; color: rgb(255, 255, 255); text-align: left; font-family: Helvetica, Arial, sans-serif; line-height: 32px; vertical-align: top; font-weight: 100;'>	
												<!--[if !mso]><!--><span style='font-family: 'proxima_novalight', Helvetica;'><!--<![endif]-->&copy; NosRezo 2016.<!--[if !mso]><!--></span><!--<![endif]-->
											</td>
										</tr>

									</table>
									
									<!-- Text Right -->
									<table width='275' border='0' cellpadding='0' cellspacing='0' align='right' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='fullCenter'>

						</table><!-- End Wrapper 2 -->
					
					</td>
				</tr>
			</table><!-- End Wrapper -->
		
		
		</td>
	</tr>
</table><!-- Wrapper 31 -->

	<style>body{ background: url(http://rocketway.net/themebuilder/template/patterns/brillant.png) !important; } </style>

";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
//========== Création de la boundary
$boundary = "-----=".md5(rand());
//==========
  
//========== Définition du sujet.
$sujet = " Une nouvelle commission NosRezo proche de vous ! ";
//========= 
  
//========== Création du header de l'e-mail.
$header = "From: \"NosRezo.com\"<contact@nosrezo.com>".$passage_ligne;
//$header.= "Cc:".$mail_cc.", contact@nosrezo.com ".$passage_ligne;
//$header.= "Cc: contact@nosrezo.com  ".$passage_ligne;
//$header.= "Reply-to: ".$mail_cc.$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
  
//========== Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

//==========
  
//========== Envoi de l'e-mail.
     if ($serveur == 'PRODUCTION')
     {
         if(mail($mail, $sujet, $message, $header))
         {echo '';}
	 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>


