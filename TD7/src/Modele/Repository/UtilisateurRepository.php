<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository {
    public function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur {
        return new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom']);
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

    protected function getClesPrimaires(): array {
        return ["login"];
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