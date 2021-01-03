<?php

require_once 'bdd.conf.php';
//print_r2($_COOKIE);
if (isset($_COOKIE['sid'])) {
    $sid = $_COOKIE['sid'];
    $userManager = new userManager($bdd);
    $userConnecte = $userManager->getBySid($sid);
    if ($userConnecte->getMail() != '') {
        $userConnecte->isConnect = true;
    } else {
        $userConnecte->isConnect = false;
    }
    //print_r2($userConnecte);
} else {
    $userConnecte = new user();
    $userConnecte->isConnect = false;
    //print_r2($userConnecte);
}
