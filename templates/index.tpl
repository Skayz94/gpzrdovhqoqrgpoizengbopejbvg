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
    {if isset($smarty.session.notification)}
        <div class='row'>
            <div class="col-lg-12">
                <div class="alert alert-{$smarty.session.notification.result}" role='alert'>
                    {$smarty.session.notification.message}                           
                </div>
            </div>
        </div>
      
    {/if}
    <div class="row">       
            {foreach from=$listArticle item=$article}           
            <div class="col-md-6">
                <div class="card" style="">
                    <img src="img/{$article->getId()}.png" class="card-img-top" alt="="{$article->getTitre()}" style="width:100px">
                    <div class="card-body">
                        <h5 class="card-title">{$article->getTitre()}</h5>
                        <p class="card-text">{substr($article->getTexte(), 0, 200)}...</p>
                        <a href="#" class="btn btn-primary">{$article->getDate()}</a>
                        {if $userConnecte->isConnect == true}
                        <a href="article.php?id=<?= $article->getId(); ?>" class="btn btn-warning" >Modifier</a>
                        {/if}
                    </div>
                </div>
            </div>
            {/foreach}
       
    </div>
    <div class="row mt-3">
        <div class="col-12"
             <nav aria-label="Navigation entre les pages">
            <ul class="pagination justify-content-center">
                
                {for $index=1 to $nbPage}
                    
                    <li class="page-item {if ($page == $index)}active{/if}"><a class="page-link" href="index.php?p={$index}">{$index}</a></li>
                {/for}  
            </ul>
            </nav>
        </div>
    </div>  
</div>

