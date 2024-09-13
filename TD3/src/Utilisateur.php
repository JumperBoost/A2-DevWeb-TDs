<?php
require_once 'ConnexionBaseDeDonnees.php';
require_once 'Trajet.php';

class Utilisateur {

    private string $login;
    private string $nom;
    private string $prenom;

    /**
     * @var Trajet[]|null
     */
    private ?array $trajetsCommePassager;

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

    public function getTrajetsCommePassager(): ?array
    {
        if(is_null($this->trajetsCommePassager))
            $this->setTrajetsCommePassager($this->recupererTrajetsCommePassager());
        return $this->trajetsCommePassager;
    }

    public function setTrajetsCommePassager(?array $trajetsCommePassager): void
    {
        $this->trajetsCommePassager = $trajetsCommePassager;
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
        $this->trajetsCommePassager = null;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString(): string {
        return "Utilisateur $this->nom $this->prenom de login $this->login";
    }

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur {
        return new Utilisateur($utilisateurFormatTableau['login'], $utilisateurFormatTableau['nom'], $utilisateurFormatTableau['prenom']);
    }

    /**
     * @return Utilisateur[]
     */
    public static function recupererUtilisateurs(): array {
        $pdo = ConnexionBaseDeDonnees::getPdo();
        $pdoStatement = $pdo->query("SELECT * FROM utilisateur", PDO::FETCH_ASSOC);

        $utilisateurs = [];
        foreach ($pdoStatement as $ligne) {
            $utilisateurs[] = self::construireDepuisTableauSQL($ligne);
        }
        return $utilisateurs;
    }

    public static function recupererUtilisateurParLogin(string $login) : ?Utilisateur {
        $sql = "SELECT * from utilisateur WHERE login = :loginTag";
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $login
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant
        $utilisateurFormatTableau = $pdoStatement->fetch();

        if($utilisateurFormatTableau)
            return Utilisateur::construireDepuisTableauSQL($utilisateurFormatTableau);
        else return null;
    }

    public function ajouter(): bool {
        $sql = "INSERT INTO utilisateur VALUES (:loginTag, :nomTag, :prenomTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'loginTag' => $this->login,
            'nomTag' => $this->nom,
            'prenomTag' => $this->prenom
        ];
        try {
            $pdoStatement->execute($values);
        } catch (PDOException) {
            return false;
        }
        return true;
    }

    /**
     * @return Trajet[]
     */
    private function recupererTrajetsCommePassager() : array {
        $sql = "SELECT * FROM passager JOIN trajet ON trajetId = id WHERE passagerLogin = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = ['loginTag' => $this->login];
        $pdoStatement->execute($values);

        $trajets = [];
        foreach ($pdoStatement as $trajet) {
            $trajets[] = Trajet::construireDepuisTableauSQL($trajet);
        }
        return $trajets;
    }
}