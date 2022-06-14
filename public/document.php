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

if(!empty($_POST)){ 
  extract($_POST);
  $valid =(boolean)true;

if(isset($_POST['envoyer'])){
     $dossier = 'upload/' . $_SESSION['id'] . "/";

     if (!is_dir($dosssier)) {
       mkdir($dossier);
     }

     $fichier = basename($_FILES['document']['name']);

     if(move_uploaded_file($_FILES['document']['tmp_name'], $dossier . $fichier)){

       if(file_exists("upload" .$_SESSION['id'] . '/' . $_SESSION['document']) && isset($_SESSION['document'])){
        unlink("upload" .$_SESSION['id'] . '/' . $_SESSION['document']);
       }

      $req = $BDD->prepare("UPDATE utilisateur SET document = ? WHERE id = ?");

      $req->execute(array($fichier,$_SESSION['id']));

      $_SESSION['document'] = $fichier;

        header('Location:document.php');
        exit;
       
     } else { 
         
         header('Location:document.php');
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
      
        <div style="margin-top: 10px; background: white; box-shadow: 0 5px 10px rgba(0,0,0, .09); padding: 5px 18px; border-radius: 10px">
          
     <?php

        if(isset($voir_utilisateur['document'])){

        ?>
  <div style="background: url(<?= 'upload/' . $voir_utilisateur['id'] . '/' . $voir_utilisateur['document'] ?>) no-repeat center; background-size : cover; width: 200px; height: 120px;"></div>
     <?php

          }

        ?>
 
      <?php
      }
      ?>   
      </div>  
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
