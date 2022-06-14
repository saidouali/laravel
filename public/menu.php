 

 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
       <li class="nav-item ">
        <a class="nav-link" href="index.php"></a>
      </li>
    </ul>
      
    <ul class="navbar-nav ml-md-auto">
      <?php
       if (isset($_SESSION['id'])) {
      ?>
       <?php
       if (isset($_SESSION['id']) && $_SESSION['role'] == 1) {
      ?>
       <li class="nav-item ">
        <a class="nav-link" href="membres.php">Membres</a>
      </li>
       <li class="nav-item ">
        <a class="nav-link" href="inscription.php">Ajouter</a>
      </li>
      <?php
    }
    ?>
        <li class="nav-item ">
        <a class="nav-link" href="" data-toggle="modal" data-target="#exampleModal">Mon Profil</a>
      </li>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paramétres</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="modal-body">
        <li>
        <a href="profil.php" class="Bare">Profil</a>
      </li>
     
        <a  href="deconnection.php">Déconnexion</a>
      </li>
        
       
      </div>
    </div>
     
  </div>
</div>

      <?php
     }else{

      ?>

 <a href="connexion.php" style="color: white;">Mon compte</a>
      
      <?php
    }

    ?>
     </ul>
  </div>
     </ul>
  </div>
</nav>


