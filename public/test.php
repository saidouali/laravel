<?php 
session_start();
include_once('db/connexiondb.php');



if (!isset($_SESSION['id']))  {
   header('Location: index.php');
    exit;
}

$utilisateur_id = (int) $_SESSION['id'];

if (empty($utilisateur_id)){
    header('Location: rdv.php');
    exit;
} 
$req = $BDD->prepare("SELECT *
    FROM utilisateur
    WHERE id =?");

    $req->execute(array($utilisateur_id));

    $voir_utilisateur = $req->fetch();

    if (!isset($voir_utilisateur['id'])) {
        header('Location: rdv.php');
        exit;
    }

  $req =$BDD->prepare("SELECT * 
    from document
    WHERE id_user = ?");

  $req->execute(array($utilisateur_id));

  $voir_document = $req->fetchAll();

if(!empty($_POST)){ 
  extract($_POST);
  $valid =(boolean)true;

if(isset($_POST['envoyer'])){
     $dossier = 'upload/' . $_SESSION['id'] . "/";

     if (!is_dir($dossier)) {
       mkdir($dossier);
     }
     
     $dossier .="document/";

 if (!is_dir($dossier)) {
       mkdir($dossier);
     }


$PoidsMax = 5242880; // Poids Max 5 Mo

//  5242880 // 5 Mo

if ($_FILES['document'] ['size'] <= $PoidsMaxImage) {
  
 $ListeExtension = array('jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'git' =>'image/git');
 $ListeExtensionIE = array('jpg' => 'image/pjpg', 'jpeg' => 'image/pjpeg');

 $ListeExtensionValides = array('jpg', 'jpeg', 'png'); // Format que l'on accepte !

     $fichier = basename($_FILES['document']['name']);
     $fichier_extension = strtolower(substr(strrtchr($fichier, '.'), 1));

     if (in_array($fichier_extension, $ListeExtensionValides)) {
       
      $fichier = md5(uniqid(rand(), true)) .'.' . $fichier_extension;

     if(move_uploaded_file($_FILES['document']['tmp_name'], $dossier . $fichier)){

       if(file_exists($dossier. $_SESSION['document']) && isset($_SESSION['document'])){
        unlink($dossier . $_SESSION['document']);
       }

$verif_ext = getimagesize($dosssier . $fichier);

if ($verif_ext['mime'] == $ListeExtension[$fichier_extension] || verif_ext['mime'] == $ListeExtensionIE[$fichier_extension]) {

  // On enregistre le chemin de l'image dans filename

  $filename = $dossier . $fichier;

  // Vérifier les extensions que je souhaite prendre pour mon travail d'image
if(in_array($fichier_extension, array('jpg', 'jpeg', 'pjpg', 'pjpeg'))){
    $image = imagecreatefromjpeg($filename);
  }
  if (in_array($fichier_extension, array('png'))) {
        $image = imagecreatefrompng($filename);
  }

  // Définir la hauteur et la largeur de l'imag
  $width = 720;
  $height = 720;

  List($width_orig, $height_orig) = getimagesize($filename);

  $whFact = $width / $height;
  $imgWhFact = $width_orig / $height_orig;

  if ($whFact <= $imgWhFact) {
    $width = $width;
    $height = $width / $imgWhFact;
  }else{
    $height = $height;
    $width= $height = $imgWhFact;
  }

  // Rédimensionnement
  $image_p = imagecreatecolor($width, $height);
  imagealphablending($image_p, false);
  imagesavealpha($image_p, true);

  // // Calcul des nouvelles dimensions de l'image
  // $point = 0;
  // $ratio = null;

  // if ($width_orig <= $height_orig) {
  //   $ratio = $width / $width_orig;

  // }elseif($width_orig > $height_orig){
  //     $ratio = $height / $height_orig;
  // }

  // $width = ($width_orig = $ratio) + 1;
  // $height = ($height_orig = $ratio) + 1;

  imagecopyresampled($image_p,$image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
  imagedestroy($image);
}
if(in_array($fichier_extension, array('jpg', 'jpeg', 'pjpg', 'pjpeg'))){ 

// Content type
  header('Content-Type: image/jpeg');

  $exif = exif_read_data($filename);

  if (!empty($exif['Orientation'])) {
    switch ($exif['Orientation']) {
      case '0':
        $image_p = imagerotate($image_p, 90, 0);
        break;
      case '3':
        $image_p = imagerotate($image_p, 100, 0);
        break;
      case '6':
        $image_p = imagerotate($image_p, -90, 0);
        break;
    }
  }

  // Affichage
  imagejpg($image_p, $filename, 75);
  imagedestroy($image_p);
}

if(in_array($fichier_extension, array('png'))){
  header('Content-Type: image/png');

  imagepng($image_p, $filename, 8);
  imagedestroy($image_p);

}
      $req = $BDD->prepare("INSERT INTO document (id_user, nom, date) VALUES(?,?,?)");

      $req->execute(array($_SESSION ['id'], $fichier, $date['Y-m-d H:i:s']));

        header('Location:document.php');
        exit;
       
     } else { 
         unlink("upload/" .$_SESSION['id'] .'/' . $dossier . $fichier); // Suppression de l'image
         echo "Impossible de déplacer le fichier";
         header('Location:document.php');
         exit;
       }

       header('Location:document.php');
         exit;
     }else{
      echo'extention non valide 1';
      header('Location:document.php');
         exit;
     }

   }else{
    echo'Le poids de l\'image doit faire au moins 5 mo';
    header('Location: document.php');
         exit; 
   }
 }
}


?>

<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     <link rel="stylesheet" href="css/style.css">

     <link rel="stylesheet" href="css/projet.css">

    <title>document</title>
  </head>
  <body>
 <?php
   require_once('menu.php');

    ?>
    
   <br><br>
</div>

<div style="margin-top: 20px; background: white; box-shadow: 0 5px 15px rgba(0,0,0, .15); padding: 5px 10px; border-radius: 10px">
      <h3>Ajouter un document</h3>
<div class="membre-corps" style="text-align: left">
    
            <form method="Post" enctype="multipart/form-data">
              <div>
              Fichier : <input type="file" name="document">
            </div>
            <br>
            <div>
              <input type="submit" name="envoyer" value="Envoyer le fichier">
</div>    <br>       </form>
         </div>
         <?php
         if (isset($_SESSION['document'])) {
           ?>
        
         <div style="margin-top: 20px; background: white; box-shadow: 0 5px 15px rgba(0,0,0, .15); padding: 5px 10px; border-radius: 10px">
      <h3>Mes Documents</h3>
      </div>
      
      <?php
      foreach($voir_document as $vd){

        if (file_exists(__DIR__ .'/upload/' . $voir_utilisateur['id'] . '/document' . $vd['nom'])) {
          $chemin_document = '/upload/' .$voir_utilisateur['id'] . '/document' . $vd['nom'];
        }
      
       ?>  

    <div style="background: url(<?= $document ?>);"></div>
     
 
      <?php
      }
      ?>   
      </div> 
       <?php
      }
      ?>   
    </div>
</div>
 <?php
   require_once('pages.php');
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>