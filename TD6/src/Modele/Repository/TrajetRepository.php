<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use DateTime;
use PDO;

class TrajetRepository {
    public static function construireDepuisTableauSQL(array $trajetTableau): Trajet {
        $trajet = new Trajet(
            $trajetTableau["id"] ?? null,
            $trajetTableau["depart"],
            $trajetTableau["arrivee"],
            new DateTime($trajetTableau["date"]),
            $trajetTableau["prix"],
            UtilisateurRepository::recupererUtilisateurParLogin($trajetTableau["conducteurLogin"]),
            $trajetTableau["nonFumeur"] ?? false,
        );

        // Récupérer la liste des passagers si le trajet existe déjà
        if(!is_null($trajet->getId())) {
            $trajet->setPassagers(self::recupererPassagers($trajet));
        }
        return $trajet;
    }

    /**
     * @return Trajet[]
     */
    public static function recupererTrajets(): array {
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->query("SELECT * FROM trajet", PDO::FETCH_ASSOC);

        $trajets = [];
        foreach($pdoStatement as $trajetFormatTableau) {
            $trajets[] = TrajetRepository::construireDepuisTableauSQL($trajetFormatTableau);
        }

        return $trajets;
    }

    /**
     * @return Utilisateur[]
     */
    private static function recupererPassagers(Trajet $trajet): array {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare("SELECT * FROM passager JOIN utilisateur ON passagerLogin = login WHERE trajetId = :trajetIdTag");
        $pdoStatement->execute(['trajetIdTag' => $trajet->getId()]);

        $utilisateurs = [];
        foreach($pdoStatement as $passager) {
            $utilisateurs[] = UtilisateurRepository::construireDepuisTableauSQL($passager);
        }
        return $utilisateurs;
    }
}