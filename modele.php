<?php
require_once 'config/config.conf.php';
require_once 'config/bdd.conf.php';

include_once 'includes/header.inc.php';
?>
<!--Page Content-->
<div class = "container">
    <div class = "row">
        <div class = "col-lg-12 text-center">
            <h1 class = "mt-5">A Bootstrap 4 Starter Template</h1>
            <p class = "lead">Complete with pre-defined file paths and responsive navigation!</p>
            <ul class = "list-unstyled">
                <li>Bootstrap 4.5.0</li>
                <li>jQuery 3.5.1</li>
            </ul>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.inc.php';

//Créer table utilisateur
//Créer class utilisateur et utilisateurManager //creation fonction ad dans utilisateurManager
// echo password_hash("mdp",PASSWORD_DEFAULT);
// <?php if($_GET['p'] == $index){  active <?php } 