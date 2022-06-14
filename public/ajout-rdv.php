<?php
session_start();

include_once('db/connexiondb.php');

if (!isset($_SESSION['id'])) {
  header('Location: rdv.php');
  exit;
}

if(!empty($_POST)){
  extract($_POST);
  $valid = true;

  if(isset($_POST['ajout-rdv'])) {

  $date_creation = (String) htmlentities(trim($date_creation));
  

  if(empty($date_creation)){
    $valid = false;
    $er_date_creation = ("il faut mettre une date");
  }

  
  if ($valid) {
    

    $DB->insert("INSERT INTO 
      rdv (id_user, id_medecin, date_creation, statut) VALUES(?,?,?,?)",
      array($_SESSION['id'], $id_medecin, $date_creation, $statut));
    header('Location: rdv.php');
    exit;
  }
}
}
?>
<!Doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     <link rel="stylesheet" href="css/style.css">

    <title>Ajout rdv </title>
  </head>
  <body>

    <?php
   require_once('menu.php');
   ?>  
    <div class="container">
    <div class="row">
  
    <div class="col-sm-12 col-md-12 col-lg-12">
     <div class="cdr-ins"></div>
         <h1>Ajouter un Rendez-vous </h1>
         <?php
         if (isset($er_rdv)) {
           ?>
           <div class="er_msg"><?= $er_rdv ?></div>
           <?php
         }

         ?>
         <form method="Post">
         <div class="form-group">
          <input class="form-control" type="date" name="titre" placeholder="inserez une date" >
         </div>
    
         <div class="form-group">
           <button class="btn btn-primary" type="submit" name="ajout-rdv" style="background: #1abc9c">Envoyer</button>
         </div>
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
