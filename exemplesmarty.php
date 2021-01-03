<?php

require_once 'config/config.conf.php';

require_once 'components/smarty/libs/smarty.class.php';

$prenom = "Antoine";

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templace_c/');

$smarty->assign('prenom', $prenom);

$smarty->display('SmartyTemplate.tpl');

