<?php
session_start();
include_once('db/connexiondb.php');

if (isset($_SESSION['id'])) {
    $afficher_rdv = $BDD->prepare("SELECT r.* , u.nom, m.Prenom
    FROM rdv r
    LEFT JOIN medecin m ON m.id = r.id_medecin
    LEFT JOIN utilisateur u ON u.id = r.id_user
    WHERE r.id_user = ?
    ORDER BY r.date_creation Desc");

$afficher_rdv->execute(array($_SESSION['id']));

}else{
    $afficher_rdv = $BDD->prepare("SELECT *
    FROM rdv");
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

    <title>Rendez-vous </title>
  </head>
  <body>

    <?php
   require_once('menu.php');
   ?>  

      <div class="container">
      <div class="row">


  <div class="col-sm-0 col-md-0 col-lg-0"></div>
  <div class="col-sm-12 col-md-12 col-lg-12">

     <?php
 if (isset($_SESSION['id'])) {

  ?>  
  
              <h3>Mes rendez-vous</h3>
              
            <?php
               foreach($afficher_rdv as $ar){ 
            ?>
    
    <div style="position: relative; display: flex; justify-content: center;">
        </div>
      
        <div style="margin-top: 10px; background: white; box-shadow: 0 5px 10px rgba(0,0,0, .09); padding: 5px 18px; border-radius: 10px">

       Mr : <?= $ar['nom']?></a> 
   
 le : <?= date_format(date_create($ar['date_creation']), 'D d M Y ');  ?>
 
      Avec :  <?= nl2br($ar['Prenom']); ?>
      
Statut : <?= nl2br($ar['statut']); ?>
     
        </div>  

    <?php
   }
?>

<?php
    }
 ?> 

 <a href="index.php">Prendre un Nouveau Rendez-vous</a>

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