<?php
require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';
//$article = new article();
//$article->hydrate(array());
//print_r2($article);

$page = !empty($_GET['p']) ? $_GET['p'] : 1;

$articleManager = new articleManager($bdd);

$nbArticleTotalAPublie = $articleManager->countArticlePublie();
//print_r2($nbArticleTotalAPublie);

$indexDepart = ($page - 1) * nb_article_par_page;

$nbPage = ceil($nbArticleTotalAPublie / nb_article_par_page);

$listArticle = $articleManager->getListArticleAAfficher($indexDepart, nb_article_par_page);

//print_r2($listArticle);
//print_r2($articleManager);
include_once 'includes/header.inc.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center mt-5">
            <form class="form-inline" id="rechercheForm" method="GET" action="recherche.php" >
                <label class="sr-only" for="recherche">Recherche</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="recherche" placeholder="Rechercher un article" name="recherche" value="">
                <button type="submit" class="btn btn-primary mb-2" name="submitRecherche">Rechercher</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Projet moteur de blog</h1>
            <p class="lead">Voici les articles disponibles :</p>
            <ul class="list-unstyled">
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
        <?php
        foreach ($listArticle as $key => $article) {
            ?>
            <div class="col-md-6">
                <div class="card" style="">
                    <img src="img/<?= $article->getId(); ?>.png" class="card-img-top" alt="<?= $article->getTitre(); ?>" style="width:100px">
                    <div class="card-body">
                        <h5 class="card-title"><?= $article->getTitre(); ?></h5>
                        <p class="card-text"><?= substr($article->getTexte(), 0, 200) . '...'; ?></p>
                        <a href="#" class="btn btn-primary"><?= $article->getDate(); ?></a>
                        <a href="article.php?id=<?= $article->getId(); ?>" class="btn btn-warning" >Modifier</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row mt-3">
        <div class="col-12"
             <nav aria-label="Navigation entre les pages">
            <ul class="pagination justify-content-center">
                <?php
                for ($index = 1; $index <= $nbPage; $index++) {
                    ?>
                    <li class="page-item <?php if ($page == $index) { ?> active <?php } ?>"><a class="page-link" href="index.php?p=<?= $index ?>"><?= $index ?></a></li>
                        <?php
                    }
                    ?>
            </ul>
            </nav>
        </div>
    </div>  
</div>

<?php
include_once 'includes/footer.inc.php';
