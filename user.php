<?php
require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';

if (isset($_POST['submit'])) {
    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création de l'utilisateur
    $user = new user();
    $user->hydrate($_POST);
    $user->setMDP(password_hash($user->getMdp(), PASSWORD_DEFAULT));

    //print_r2($user);
    //Insertion de l'utilisateur
    $userManager = new userManager($bdd);
    $userManager->add($user);

    //var_dump($userManager);
    //Traitement de l'image

    if ($userManager->getResult() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Votre compte a été créé';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Une erreur est survenu pendant la création de votre compte';
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
                <h1 class = "mt-5">Création de compte Utilisateur</h1>
                <p class = "lead">Veuillez remplir les champs ci-dessous</p>
                <ul class = "list-unstyled">
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class = "col-lg-6 offset-lg-3">
                <form id="usersform" method="POST" action="user.php" enctype="multipart/form-data">
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
                            <label for="email">Mail</label>
                            <input type="texte" name="mail" class="form-control" id="mail" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="mdp">Mot de Passe</label>
                            <input type="password" name="mdp" class="form-control" id="mdp" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Créer le Compte</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>

    <?php
    include_once 'includes/footer.inc.php';
}
