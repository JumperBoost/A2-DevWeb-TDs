<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use PDO;
use PDOException;

class UtilisateurRepository extends AbstractRepository {
    public function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur {
        return new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom']);
    }

    public static function recupererUtilisateurParLogin(string $login): ?Utilisateur {
        $sql = "SELECT * FROM utilisateur WHERE login = :loginTag";
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
            return (new UtilisateurRepository)->construireDepuisTableauSQL($utilisateurFormatTableau);
        else return null;
    }

    public static function ajouter(Utilisateur $utilisateur): bool {
        $sql = "INSERT INTO utilisateur VALUES (:loginTag, :nomTag, :prenomTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'loginTag' => $utilisateur->getLogin(),
            'nomTag' => $utilisateur->getNom(),
            'prenomTag' => $utilisateur->getPrenom()
        ];
        try {
            $pdoStatement->execute($values);
        } catch (PDOException) {
            return false;
        }
        return true;
    }

    public static function supprimerParLogin(string $login): bool {
        $sql = "DELETE FROM utilisateur WHERE login = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'loginTag' => $login
        ];
        try {
            $pdoStatement->execute($values);
        } catch (PDOException) {
            return false;
        }
        return true;
    }

    public static function mettreAJour(Utilisateur $utilisateur): void {
        $sql = "UPDATE utilisateur SET nom = :nomTag, prenom = :prenomTag WHERE login = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'loginTag' => $utilisateur->getLogin(),
            'nomTag' => $utilisateur->getNom(),
            'prenomTag' => $utilisateur->getPrenom()
        ];
        $pdoStatement->execute($values);
    }

    /**
     * @return Trajet[]
     */
    public static function recupererTrajetsCommePassager(Utilisateur $utilisateur): array {
        $sql = "SELECT * FROM passager JOIN trajet ON trajetId = id WHERE passagerLogin = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = ['loginTag' => $utilisateur->getLogin()];
        $pdoStatement->execute($values);

        $trajets = [];
        foreach($pdoStatement as $trajet) {
            $trajets[] = (new TrajetRepository)->construireDepuisTableauSQL($trajet);
        }
        return $trajets;
    }

    /**
     * @return Trajet[]
     */
    public static function recupererTrajetsCommeConducteur(Utilisateur $utilisateur): array {
        $sql = "SELECT * FROM trajet WHERE conducteurLogin = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = ['loginTag' => $utilisateur->getLogin()];
        $pdoStatement->execute($values);

        $trajets = [];
        foreach($pdoStatement as $trajet) {
            $trajets[] = (new TrajetRepository)->construireDepuisTableauSQL($trajet);
        }
        return $trajets;
    }

    protected function getNomTable(): string {
        return "utilisateur";
    }
}