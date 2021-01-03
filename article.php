<?php
require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';

if ($userConnecte->isConnect == false) {
    $_SESSION['notification']['result'] = 'danger';
    $_SESSION['notification']['message'] = 'Vous devez être connecté pour accéder à la page';
    header("Location: connexion.php");
    exit();
}
//Récupérer l'id de l'article
if (isset($_GET['id'])) {
    $id_article = $_GET['id'];
    $articleManager = new articleManager($bdd);
    $article = $articleManager->get($id_article);
    //print_r2($id_article_final);
} else {
    $articleManager = new articleManager($bdd);
    $article = new article;
    $article->hydrate(array());
    //print_r2($article);
}

if (isset($_POST['submit'])) {
    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création de l'article
    $article = new article();
    $article->hydrate($_POST);

    $article->setDate(date('Y-m-d'));

    $publie = $article->getPublie() === 'on' ? 1 : 0;

    $article->setPublie($publie);
    //print_r2($article);
    //exit();
    //Insertion de l'article selon si c'est une modification ou une création 
    $articleManager = new articleManager($bdd);
    if ($_POST['submit'] == 'modifier') {
        $articleManager->update($article);
    } else {
        $articleManager->add($article);
    }
    //var_dump($articleManager);
    //Traitement de l'image
    if ($_FILES['image']['error'] == 0) {
        $fileInfos = pathinfo($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $articleManager->getGetLastInsertId() . '.' . $fileInfos['extension']);
    }
    //Affichage du message selon si c'est une modification ou une création
    if ($_POST['submit'] == 'modifier') {
        if ($articleManager->getResult() == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Votre article a été modifié';
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Une erreur est survenu pendant de la modification de votre article';
        }
    } else {
        if ($articleManager->getResult() == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Votre article a été ajouté';
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Une erreur est survenu pendant de la création de votre article';
        }
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
            <!-- Affiche de la page de modifs ou de création -->
            <?php if (isset($_GET['id'])) {
                ?>
                <div class = "col-lg-12 text-center">
                    <h1 class = "mt-5">Modification d'un Article</h1>
                    <p class = "lead">Sur cette page vous allez pouvoir modifier votre article</p>
                    <ul class = "list-unstyled">
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class = "col-lg-12 text-center">
                    <h1 class = "mt-5">Création d'un article</h1>
                    <p class = "lead">Sur cette page vous allez pouvoir ajouter un article au Blog</p>
                    <ul class = "list-unstyled">
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class = "col-lg-6 offset-lg-3">
                <form id="articleform" method="POST" action="article.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="texte" name="titre" class="form-control" id="titre" value="<?= $article->getTitre() ?>" placeholder="" required="">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="texte">Le contenu de mon article</label>
                            <textarea class="form-control" id="texte" name="texte" rows="3" required=""><?= $article->getTexte() ?></textarea>
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group">
                            <label for="image">L'image de mon article</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <div class="form-group form-check">
                            <input type="checkbox" <?php if ($article->getPublie() == true) { ?> checked <?php } ?> class="form-check-input" id="publie" name="publie">
                            <label class="form-check-label" for="publie">Article Publié ?</label>
                        </div>
                    </div>
                    <div class = "col-lg-12">
                        <?php
                        if (isset($_GET['id'])) {
                            ?>
                            <button type = "submit" id = "submit" name = "submit" class = "btn btn-primary" value="modifier">Modifier mon article</button>
                        <?php } else {
                            ?>
                            <?php ?>
                            <button type = "submit" id = "submit" name = "submit" class = "btn btn-primary" value="ajouter">Créer mon article</button>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include_once 'includes/footer.inc.php';
}

                        