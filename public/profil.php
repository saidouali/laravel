<?php
session_start();
include_once('db/connexiondb.php');

if (!isset($_SESSION['id']))  {
   header('Location: index.php');
    exit;
}

$utilisateur_id = (int) $_SESSION['id'];

$req= $BDD->prepare("SELECT * 
FROM utilisateur
WHERE id =?");

$req->execute(array($utilisateur_id));

    $voir_utilisateur = $req->fetch();

    function age($date){
      $age = date('Y') - date('Y', strtotime($date));

      if(date('md') < date('md', strtotime($date))){
        return $age -1;
      }
      return $age;
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

    <title>Profil de <?=$voir_utilisateur['nom'] ?></title>
  </head>
  <body>

    <?php
   require_once('menu.php');
   ?>  
   <br><br>
   <h3>Compte</h3>
  <div class="">
    <div class="">
         <div class="col-sm-12"> 
          <div class="membre--corps">
            
            <div>
           Nom : <?= $voir_utilisateur['nom'] ?><br>
    </div>
    <div>
        Prenom : <?= $voir_utilisateur['prenom'] ?><br>
    </div>    
    <div>
     Adresse: <?= $voir_utilisateur['adresse'] ?> <br>
     </div>
     <div>
       Email : <?=$voir_utilisateur['mail'] ?> <br>
    </div>
         <div>
      </div>
    </div>
     <div>
      <a href="editer_profil.php" style="font-style: italic;">Modifier mes informations ?</a>
                     

</div>    <br>       </form>
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