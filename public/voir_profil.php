<?php
session_start();

include_once('db/connexiondb.php');

$utilisateur_id = (int) trim($_GET['id']);

if (empty($utilisateur_id)) {
    header('Location: membres.php');
    exit;
}
if (isset($_SESSION['id'])) {
    
$req = $BDD->prepare("SELECT u.*, r.id_receveur, r.statut, r.id_bloqueur
    FROM utilisateur u  
    LEFT JOIN relation r ON  (id_receveur = u.id AND id_demandeur = :id2) OR (id_receveur = :id2 AND id_demandeur = u.id)
    WHERE u.id = :id1");

    $req->execute(array('id1' => $utilisateur_id, 'id2' => $_SESSION['id']));
}else{
    $req = $BDD->prepare("SELECT *
    FROM utilisateur 
    WHERE id = :id1");

    $req->execute(array('id1' => $utilisateur_id));
}

    $voir_utilisateur = $req->fetch();

    if (!isset($voir_utilisateur['id'])) {
        header('Location: membres.php');
        exit;
    }

    function age($date){
      $age = date('Y') - date('Y', strtotime($date));

      if(date('md') < date('md', strtotime($date))){
        return $age - 1;
      }
      return $age;
}
if(!empty($_POST)){ 
  extract($_POST);
  $valid =(boolean)true;

  
 
if(isset($_POST['user-supprimer'])){
    $req =$BDD->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
     $req->execute(array($voir_utilisateur['id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['id']));

      header('Location: voir-profil.php?id=' .$voir_utilisateur['id']);
      exit;
      
    }elseif(isset($_POST['user-bloquer'])){
    $req =$BDD->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
     $req->execute(array($voir_utilisateur['id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['id']));

      $req = $BDD->prepare("INSERT INTO relation (id_demandeur, id_receveur, statut, id_bloqueur) VALUES (?, ?, ?, ?)");

     $req->execute(array($_SESSION['id'], $voir_utilisateur['id'], 3, $voir_utilisateur['id']));

      header('Location: voir-profil.php?id=' .$voir_utilisateur['id']);
      exit;

    }elseif(isset($_POST['user-debloquer'])){
    $req =$BDD->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
     $req->execute(array($voir_utilisateur['id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['id']));

      header('Location: voir-profil.php?id=' .$voir_utilisateur['id']);
      exit;
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

    <title>Profil de <?= $voir_utilisateur['nom'] ?></title>
  </head>
  <body>

    <?php
   require_once('menu.php');
   ?>  
  <div class="container">
      <div class="row">
         <div class="col-sm-12"> 
          <div class="membre--corps">
             <div>
           Nom : <?= $voir_utilisateur['nom'] ?><br>
    </div>
    <div>
        Prenom : <?= $voir_utilisateur['prenom'] ?><br>
    </div>    
   <div>
       Age : <?= age($voir_utilisateur['date_naissance']) ?> ans<br>
    </div>
    <div>
     Adresse: <?= $voir_utilisateur['adresse'] ?> <br>
     </div>
     <div>
       Email : <?=$voir_utilisateur['mail'] ?> <br>
    </div>
  </div>
  <?php
    if (isset($_SESSION['id'])) {
        
    ?>
   <div>
    <form method="Post">

        <?php
             }
             if (isset($voir_utilisateur['statut']) && $voir_utilisateur['statut'] < 3 && $voir_utilisateur['id_demandeur'] == $_SESSION['id']) {
             
         ?>
             <input type="submit" name="user-supprimer" value="Supprimer">
            <?php
               }
               if ((isset($voir_utilisateur['statut']) || $voir_utilisateur['statut'] == NULL) && $voir_utilisateur['statut'] < 3) {
             ?>
           <input type="submit" name="user-bloquer" value="Bloquer">
           <?php
             }elseif($voir_utilisateur['id_bloqueur'] <> $_SESSION['id']) {
            ?>
              <input type="submit" name="user-debloquer" value="Débloquer">
              <?php
              }else{ 
          ?>
          <div>Vous avez été bloquer cette utilisateur</div>
            <?php
        }
        ?>
 </form>     
         </div>
         
    </div>
</div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>