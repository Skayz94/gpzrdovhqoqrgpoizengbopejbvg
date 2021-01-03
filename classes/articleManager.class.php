<?php

class articleManager {

    // DECLARATIONS ET INSTANCIATIONS
    private $bdd; // Instance de PDO
    private $result;
    private $message;
    private $article; // Instance de article
    private $getLastInsertId;

    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }

    function getBdd() {
        return $this->bdd;
    }

    function getResult() {
        return $this->result;
    }

    function getMessage() {
        return $this->message;
    }

    function getArticle() {
        return $this->article;
    }

    function getGetLastInsertId() {
        return $this->getLastInsertId;
    }

    function setBdd($bdd): void {
        $this->bdd = $bdd;
    }

    function setResult($result): void {
        $this->result = $result;
    }

    function setMessage($message): void {
        $this->message = $message;
    }

    function setArticle($article): void {
        $this->article = $article;
    }

    function setGetLastInsertId($getLastInsertId): void {
        $this->getLastInsertId = $getLastInsertId;
    }

    public function get($id) {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM article WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $article = new article();
        $article->hydrate($donnees);

        //print_r2($article);
        return $article;
    }

    public function getList() {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT id,'
                . 'titre,'
                . 'texte,'
                . 'publie,'
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM article';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $article = new article();
            $article->hydrate($donnees);
            $listArticle[] = $article;
        }
        //print_r2($listArticle);
        return $listArticle;
    }

    public function add(article $article) {
        $sql = "INSERT INTO article "
                . "(titre, texte, publie, date) "
                . "VALUES (:titre, :texte, :publie, :date)";
        $req = $this->bdd->prepare($sql);
        // Sécurisation des variables
        $req->bindValue(':titre', $article->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $article->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $article->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':date', $article->getDate(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->result = true;
            $this->getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->result = false;
        }
        return $this;
    }

    public function countArticlePublie() {
        $sql = "SELECT COUNT(*)as total FROM article "
                . "WHERE publie = 1";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];

        return $total;
    }

    public function getListArticleAAfficher($depart, $limit) {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT id,'
                . 'titre,'
                . 'texte,'
                . 'publie,'
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM article '
                . 'WHERE publie = 1 '
                . 'LIMIT :depart, :limit';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $article = new article();
            $article->hydrate($donnees);
            $listArticle[] = $article;
        }
        //print_r2($listArticle);
        return $listArticle;
    }

// Fonction de mise à jour d'un article via son ID
    public function update(article $article) {
        //print_r2($article);
        $sql = "UPDATE article SET "
                . "titre = :titre, texte = :texte, publie = :publie "
                . "WHERE id = :id";
        $req = $this->bdd->prepare($sql);
        // Sécurisation des variables
        $req->bindValue(':titre', $article->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $article->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $article->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':id', $article->getId(), PDO::PARAM_INT);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->result = true;
            $this->getLastInsertId = $article->getId();
        } else {
            $this->result = false;
        }
        return $this;
    }
    public function getListArticlesFromRecherche($recherche) {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM article '
                . 'WHERE publie = 1 '
                . 'AND (titre LIKE :recherche '
                . 'OR texte LIKE :recherche)';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $article = new article();
            $article->hydrate($donnees);
            $listArticle[] = $article;
        }

        //print_r2($listArticle);
        return $listArticle;
    }

}
