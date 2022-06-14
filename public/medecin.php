<?php
session_start();
  require_once 'db/config.php';
  require_once('db/connexiondb.php');

  if (isset($_POST['submit'])) {
    $Nom = $_POST['search'];

    $sql = 'SELECT * FROM medecin WHERE nom = :nom';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['nom' => $Nom]);
    $row = $stmt->fetch();
  } else {
    header('location: .');
    exit();
  }

  $id_medecin = (int) trim($_GET['id']);

if(empty($id_medecin)) {
  header('Location: index.php ');
  exit;
}
  $req = $DB->query("SELECT *
       FROM medecin
       WHERE id = ?",
       array($id_medecin));

    $req = $req->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Details : <?= $row['Prenom'] ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <?php
   require_once('menu.php');
   ?>  
  <div class="">
    <div class="">
         <div class="col-sm-12"> 
          <div class="membre--corps">
          <div >
             <div> ID : <?= $row['id'] ?></div>
             <div> Nom : <?= $row['Nom'] ?></div>
            <div>Prenom : <?= $row['Prenom'] ?></div>
            <div>Fonction : <?= $row['Fonction'] ?></div>
        
          </div>
 
       </div>
       <?php
 if (isset($_SESSION['id'])) {
  ?>  
  <a href="ajout-rdv.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="background: #1abc9c">Prendre un Rendez-vous</a>
    <?php
    }
 ?> 
       </div>
       </div>
       </div>   
       <?php
   require_once('pages.php');
   ?>
</body>

</html>