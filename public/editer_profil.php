<?php
session_start();

include_once('db/connexiondb.php');

if (!isset($_SESSION['id']))  {
   header('Location: index.php');
    exit;
}

$utilisateur_id = (int) $_SESSION['id'];

if (empty($utilisateur_id)){
    header('Location: profil.php');
    exit;
} 


$req = $BDD->prepare("SELECT *
    FROM utilisateur 
    WHERE id =?");

    $req->execute(array($utilisateur_id));

    $voir_utilisateur = $req->fetch();

    if (!isset($voir_utilisateur['id'])) {
        header('Location: profil.php');
        exit;
    }


if(!empty($_POST)){ 
  extract($_POST);
  $valid =(boolean)true;

  
  if(isset($_POST['modifier'])){
    $nom = (String) trim ($nom);
    $prenom = (String) trim ($prenom);
    $adresse = (String) trim($adresse);
    $mail = (String) strtolower(trim ($mail));  
  

     if(empty($nom)){
      $valid = false;
      $err_nom = "Veuillez renseigner ce champs !";
    }else{
      $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE nom = ? AND id <> ?");

      $req->execute(array($nom, $_SESSION['id']));
      $utilisateur = $req->fetch();

      if(isset($utilisateur['id'])){
        $valid = false;
        $err_nom = "Ce nom existe déja";
      }
    }

      if(empty($prenom)){
      $valid = false;
      $err_prenom = "Veuillez renseigner ce champs !";
    }else{
      $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE prenom = ? AND id <> ?");

      $req->execute(array($prenom, $_SESSION['id']));
      $utilisateur = $req->fetch();

      if(isset($utilisateur['id'])){
        $valid = false;
        $err_prenom = "Ce prenom existe déja";
      }
    }

     if(empty($err_adresse)){
      $valid = false;
      $err_adresse = "Veuillez renseigner ce champs !";
    }else{
      $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE adresse = ? AND id <> ?");

      $req->execute(array($adresse, $_SESSION['id']));
      $utilisateur = $req->fetch();

      if(isset($utilisateur['id'])){
        $valid = false;
        $err_adresse = "Ce adresse existe déja";
      }
    }


     if(empty($mail)){
      $valid = false;
      $err_mail = "Veuillez renseigner ce champs !";
    }else{
      $req = $BDD->prepare("SELECT id
        FROM utilisateur
        WHERE mail = ? AND id <> ?");

      $req->execute(array($mail, $_SESSION['id']));
      $utilisateur = $req->fetch();

      if(isset($utilisateur['id'])){
        $valid = false;
        $err_mail = "Ce mail existe déja";
      }
    }

   if($valid){

     $req = $BDD->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, mail = ?, tel = ? WHERE id = ?");

      $req->execute(array($nom, $prenom, $mail, $tel, $_SESSION['id ']));

      header('Location:profil.php');
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
      

    <title>Editer mon profil</title>
  </head>
  <body>

    <?php
   require_once('menu.php');
   ?>  
  <div class="container">
      <div class="row">
         <div class="col-sm-12"> 
          <div class="membre-corps" style="text-align: left">
            <form method="Post">
              <br><br>

              <h3>Modifier mes Informations</h3>

            <div class="form">
                <?php
                  if(isset($err_nom)){
                  echo $err_nom;
          }
                  if (!isset($nom)) {
                      $nom = $voir_utilisateur['nom'];
                  }

                ?>
                <label>Nom :</label>
                <br>
        <input type="text" name="nom" value="<?= $nom ?>">

    <?php
                  if(isset($err_prenom)){
                  echo $err_prenom;
          }
                  if (!isset($prenom)) {
                      $prenom = $voir_utilisateur['prenom'];
                  }

                ?>
                <label>Prenom :</label>
                <br>
        <input type="text" name="prenom" value="<?= $prenom ?>">

            <?php
                  if(isset($err_adresse)){
                  echo $err_adresse;
          }
                  if (!isset($adresse)) {
                      $adresse = $voir_utilisateur['adresse'];
                  }

                ?>
                <label>Adresse :</label>
                <br>
        <input type="text" name="adresse" value="<?= $adresse ?>">

    
    <?php
      if(isset($err_mail)){
            echo $err_mail;
          }
                  if (!isset($mail)) {
                      $mail = $voir_utilisateur['mail'];
                  }

                ?>
                         <label>Mail :</label>
                <br>
        <input type="text" name="mail" value="<?= $mail ?>">

       
   
        <input type="submit" name="modifier" value="Modifier">
</form>
</div>
   
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