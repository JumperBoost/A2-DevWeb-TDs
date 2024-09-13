<?php
require_once 'ConnexionBaseDeDonnees.php';

class Utilisateur {

    private string $login;
    private string $nom;
    private string $prenom;

    // un getter
    public function getNom(): string {
        return $this->nom;
    }

    // un setter
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin(string $login): void {
        $this->login = substr($login, 0, 64);
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom($prenom): void {
        $this->prenom = $prenom;
    }

    // un constructeur
    public function __construct(
        string $login,
        string $nom,
        string $prenom,
    ) {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString(): string {
        return "Utilisateur $this->nom $this->prenom de login $this->login";
    }

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur {
        return new Utilisateur($utilisateurFormatTableau['login'], $utilisateurFormatTableau['nom'], $utilisateurFormatTableau['prenom']);
    }

    public static function recupererUtilisateurs(): array {
        $pdo = ConnexionBaseDeDonnees::getPdo();
        $pdoStatement = $pdo->query("SELECT * FROM utilisateur", PDO::FETCH_ASSOC);

        $utilisateurs = [];
        foreach ($pdoStatement as $ligne) {
            $utilisateurs[] = self::construireDepuisTableauSQL($ligne);
        }
        return $utilisateurs;
    }
}