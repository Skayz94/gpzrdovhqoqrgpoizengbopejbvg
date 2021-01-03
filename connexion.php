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

    //Encryption du mot de passe
    //$user->setMDP(password_hash($user->getMdp(), PASSWORD_DEFAULT));

    //Recherche de l'utilisateur dans la base
    $userManager = new userManager($bdd);
    $userEnBdd = $userManager->getByMail($user->getMail());
    
//print_r2($user);
//print_r2($userEnBdd);
    $isConnect = password_verify($user->getMdp(), $userEnBdd->getMdp());
    //var_dump($isConnect);
//exit();
    if ($isConnect == true) {
        $sid = md5($user->getMail() . time());
        //echo $sid;
        //Création du cookie
        setcookie("sid", $sid, time() + 86400);
        //mise en bdd du sid
        $user->setSid($sid);
        $userManager->updateByMail($user);
        //var_dump($userManager->getResult());
    }

    if ($isConnect == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Connexion réussi';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Mail ou Mot de Passe incorrect';
        header("Location: connexion.php");
        exit();
    }
} else {
    //echo 'Aucun formulaire posté';
    include_once 'includes/header.inc.php';
    ?>
    <!--Page Content-->
    <div class = "container">
        <div class = "row">
            <div class = "col-lg-12 text-center">
                <h1 class = "mt-5">Connectez-vous</h1>
                <p class = "lead"></p>
                <ul class = "list-unstyled">
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <?php if (isset($_SESSION['notification'])) { ?>
            <div class='row'>
                <div class="col-lg-12">
                    <div class="alert alert-<?= $_SESSION['notification']['result'] ?>" role='alert'>
                        <?= $_SESSION['notification']['message'] ?>         
                    </div>
                </div>
            </div>
            <?php
            unset($_SESSION['notification']);
        }
        ?>
        <div class="row">
            <div class = "col-lg-6 offset-lg-3">
                <form id="usersform" method="POST" action="connexion.php" enctype="multipart/form-data">
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="mail">Mail</label>
                            <input type="texte" name="mail" class="form-control" id="mail" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="mdp">Mot de passe</label>
                            <input type="password" name="mdp" class="form-control" id="mdp" value="" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Connexion</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>

    <?php
    include_once 'includes/footer.inc.php';
}