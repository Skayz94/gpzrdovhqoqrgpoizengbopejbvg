<?php

require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';
require_once( 'components/smarty/libs/smarty.class.php');
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

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templace_c/');

$smarty->assign('listArticle', $listArticle);
$smarty->assign('userConnecte', $userConnecte);
$smarty->assign('nbPage', $nbPage);
$smarty->assign('page', $page);




//print_r2($listArticle);
//print_r2($articleManager);
include_once 'includes/header.inc.php';

$smarty->display('index.tpl');

include_once 'includes/footer.inc.php';

 unset($_SESSION['notification']);
?>