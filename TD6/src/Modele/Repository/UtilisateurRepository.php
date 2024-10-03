<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository {
    public function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur {
        return new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom']);
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

    protected function getClePrimaire(): string {
        return "login";
    }

    protected function getNomsColonnes(): array {
        return ["login", "nom", "prenom"];
    }

    /**
     * @param Utilisateur $utilisateur
     * @return array
     */
    protected function formatTableauSQL(AbstractDataObject $utilisateur): array
    {
        return array(
            "loginTag" => $utilisateur->getLogin(),
            "nomTag" => $utilisateur->getNom(),
            "prenomTag" => $utilisateur->getPrenom(),
        );
    }
}