<?php
header('Access-Control-Allow-Origin: *');

$id_affiliate = 0;
$id_affiliate = $_POST['id_affiliate'];
$location = '/homepages/0/d492946058/htdocs/fichiers/affilies/photos/profil/';
$uploadfile = $_FILES['file']['name'];
$uploadfilename = $_FILES['file']['tmp_name'];


$uploadfile = "affilie_" . $id_affiliate . "_profile.png";

 
if(move_uploaded_file($uploadfilename, $location.$uploadfile)){
        echo 'File successfully uploaded!';
} else {
        echo 'Upload error!';
}
                      
 // On rogne l'image
 $urlphoto = "/homepages/0/d492946058/htdocs/fichiers/affilies/photos/profil";
 $urldest  = "/homepages/0/d492946058/htdocs/fichiers/affilies/photos/images_resize/";

  if(rogner_image($urlphoto, $uploadfile, $urldest)) {
                         
  }
  
  ///////////////////////////// ROGNER IMAGE /////////////////////////////////////////////////////////////////////
// Cette fonction permet de rogner une image de tel sorte qu'on aura comme dimension: largeur = hauteur et la copier dans un dossier donné
// Paramètres :
// $urlphoto : chemin absolu de l'image
// $fichier : nom de l'image
// $urldest : dosssier de ou sera copiée l'image après l'avoir rogner
function ROGNER_IMAGE($urlphoto, $fichier, $urldest) {

    if (!file_exists($urlphoto)) {
        return 0;
    }
    if (!file_exists($urlphoto . "/" . $fichier)) {
        return 0;
    }
    if (!file_exists($urldest)) {
        return 0;
    }


    if ($fichier != "." && $fichier != "..") {

        // Récupérer les dimension de l'image 
        $chemin = $urlphoto . "/" . $fichier;
        $size = getimagesize($chemin);
        $width = $size[0];
        $height = $size[1];
		//echo  $chemin."<br/>";

        //Calculer les nouvelles dimensions de l'image

        $dest_x = 0; // On colle l'image sur l'autre a 0 en abscisse
        $dest_y = 0; // On colle l'image sur l'autre a 0 en ordonnee

        if ($width > $height) {

            $src_departx = ceil(($width - $height) / 2); // on part de 50 en largeur
            $src_departy = 0;  // on part de 20 en hauteur
            $src_largeur = $height; // on copie de 50 en largeur
            $src_hauteur = $height; // on copie de 20 en hauteur
        } else
        if ($width < $height) {

            $src_departx = 0;
            $src_departy = ceil(($height - $width) / 2);
            $src_largeur = $width;
            $src_hauteur = $width;
        } else {
            $src_departx = 0;
            $src_departy = 0;
            $src_largeur = $width;
            $src_hauteur = $height;
        }


        $destination = imagecreatetruecolor($src_largeur, $src_hauteur); // on creer une image de la taille du cadre à copier
        $sourcejpeg = @imagecreatefromjpeg($urlphoto . '/' . $fichier); // celle qui sera copiée
        $sourcepng = @imagecreatefrompng($urlphoto . '/' . $fichier); // celle qui sera copiée


        if ($sourcejpeg) {
            imagecopy($destination, $sourcejpeg, $dest_x, $dest_y, $src_departx, $src_departy, $src_largeur, $src_hauteur);
            imagepng($destination, $urldest . $fichier);
            return 1;
        } else if ($sourcepng) {
            imagecopy($destination, $sourcepng, $dest_x, $dest_y, $src_departx, $src_departy, $src_largeur, $src_hauteur);
            imagepng($destination, $urldest . $fichier);
            return 1;
        } else {

            return 0;
        }
    } else {
        return 0;
    }
}




?>