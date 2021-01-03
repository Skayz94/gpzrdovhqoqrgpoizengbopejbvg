<?php
require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';

if (isset($_POST['submit'])) {
    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création fr l'users
    $users = new users();
    $users->hydrate($_POST);
    $users->setMDP(password_hash($users->getMdp(), PASSWORD_DEFAULT));
    
    //print_r2($users);
    //Insertion de l'users
    $usersManager = new usersManager($bdd);
    $usersManager->add($users);
    //var_dump($usersManager);
    //Traitement de l'image

    if ($usersManager->getResult() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Votre users a été ajouté';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Une erreur est survenu pendant la création de votre users';
    }
    header("Location: index.php");
    exit();
} else {
    //echo 'Aucun formulaire posté';
    include_once 'includes/header.inc.php';
    ?>
    <!--Page Content-->
    <div class = "container">
        <div class = "row">
            <div class = "col-lg-12 text-center">
                <h1 class = "mt-5">Création d'utilisateurs</h1>
                <p class = "lead">Vas-y mamen tu peux créer ton utilisateur 🥴 </p>
                <ul class = "list-unstyled">
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class = "col-lg-6 offset-lg-3">
                <form id="usersform" method="POST" action="users.php" enctype="multipart/form-data">
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="texte" name="nom" class="form-control" id="nom" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="texte" name="prenom" class="form-control" id="prenom" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="texte" name="email" class="form-control" id="email" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="mdp">Mot de passe</label>
                            <input type="texte" name="mdp" class="form-control" id="mdp" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Créer users</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>

    <?php
    include_once 'includes/footer.inc.php';
}
