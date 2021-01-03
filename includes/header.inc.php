<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog - Cours de PHP/BDD</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container">
                <a class="navbar-brand" href="#">Projet Blog IUT</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="http://localhost/Project/index.php">Acceuil
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <?php
                        if ($userConnecte->isConnect == true) {
                            ?>

                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/Project/article.php">Article</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($userConnecte->isConnect == false) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/Project/user.php">Création de Compte</a>
                            </li>

                            <?php
                        }
                        ?>
                        <?php
                        if ($userConnecte->isConnect == false) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/Project/connexion.php">Connexion</a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/Project/deconnexion.php">Déconnexion</a>
                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>