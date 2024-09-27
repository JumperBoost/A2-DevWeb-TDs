<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\Utilisateur;
use PDO;
use PDOException;

class UtilisateurRepository
{
    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur
    {
        return new Utilisateur($utilisateurFormatTableau['login'], $utilisateurFormatTableau['nom'], $utilisateurFormatTableau['prenom']);
    }

    /**
     * @return Utilisateur[]
     */
    public static function recupererUtilisateurs(): array
    {
        $pdo = ConnexionBaseDeDonnees::getPdo();
        $pdoStatement = $pdo->query("SELECT * FROM utilisateur", PDO::FETCH_ASSOC);

        $utilisateurs = [];
        foreach ($pdoStatement as $ligne) {
            $utilisateurs[] = self::construireDepuisTableauSQL($ligne);
        }
        return $utilisateurs;
    }

    public static function recupererUtilisateurParLogin(string $login): ?Utilisateur
    {
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

        if ($utilisateurFormatTableau)
            return UtilisateurRepository::construireDepuisTableauSQL($utilisateurFormatTableau);
        else return null;
    }

    public static function ajouter(Utilisateur $utilisateur): bool
    {
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

    public static function mettreAJour(Utilisateur $utilisateur) : void {
        $sql = "UPDATE utilisateur SET nom = :nomTag, prenom = :prenomTag WHERE login = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'loginTag' => $utilisateur->getLogin(),
            'nomTag' => $utilisateur->getNom(),
            'prenomTag' => $utilisateur->getPrenom()
        ];
        $pdoStatement->execute($values);
    }
}