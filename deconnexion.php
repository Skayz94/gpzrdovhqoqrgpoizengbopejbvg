<?php

require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';

setcookie('sid', '', -1);
// notification indiquant que l'utilisateur est déconnecté
$_SESSION['notification']['result'] = 'danger';
$_SESSION['notification']['message'] = 'Vous êtes déconnecté ';
//Redirection vers la page d'acceuil
header("location: index.php");

exit();
