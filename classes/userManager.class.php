<?php

class userManager {

    // DECLARATIONS ET INSTANCIATIONS
    private $bdd; // Instance de PDO
    private $result;
    private $message;
    private $user; // Instance de utilisateurs
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

    function getUser() {
        return $this->user;
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

    function setUser($user): void {
        $this->user = $user;
    }

    function setGetLastInsertId($getLastInsertId): void {
        $this->getLastInsertId = $getLastInsertId;
    }

    public function get($id) {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM user WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $user = new user();
        $user->hydrate($donnees);

        //print_r2($user);
        return $user;
    }

    public function getList() {
        $listUser = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT id,'
                . 'nom,'
                . 'prenom,'
                . 'mail,'
                . 'mdp'
                . 'sid'
                . 'FROM utilisateurs';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new user();
            $user->hydrate($donnees);
            $listUser[] = $user;
        }
        //print_r2($listUser);
        return $listUser;
    }

    public function getByMail($mail) {
        //Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM user WHERE mail = :mail';
        $req = $this->bdd->prepare($sql);

        //Execution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->bindValue(':mail', $mail, PDO::PARAM_STR);
        $req->execute();

        //On stocke les donnes obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $user = new user();
        $user->hydrate($donnees);

        return $user;
    }

    public function getBySid($sid) {
        //Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM user WHERE sid = :sid';
        $req = $this->bdd->prepare($sql);

        //Execution de la requête avec attribution des valeurs aux marqueurs nominatifs
        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        //On stocke les donnes obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $user = new user();
        $user->hydrate($donnees);

        return $user;
    }

    public function add(user $user) {
        $sql = "INSERT INTO user "
                . "(nom, prenom, mail, mdp, sid) "
                . "VALUES (:nom, :prenom, :mail, :mdp, :sid)";
        $req = $this->bdd->prepare($sql);
        // Sécurisation des variables
        $req->bindValue(':nom', $user->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $user->getNom(), PDO::PARAM_STR);
        $req->bindValue(':mail', $user->getMail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $user->getMdp(), PDO::PARAM_STR);
        $req->bindValue(':sid', $user->getSid(), PDO::PARAM_STR);
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

    public function updateByMail(user $user) {
        $sql = "UPDATE user SET sid = :sid WHERE mail = :mail";
        $req = $this->bdd->prepare($sql);
        //Sécurisation des variables
        $req->bindValue(':mail', $user->getMail(), PDO::PARAM_STR);
        $req->bindValue(':sid', $user->getSid(), PDO::PARAM_STR);
        $req->execute();

        if ($req->errorCode() == 00000) {
            $this->result = true;
        } else {
            $this->result = false;
        }
        return $this;
    }

}
