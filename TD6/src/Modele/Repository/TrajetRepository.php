<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use DateTime;
use PDO;

class TrajetRepository extends AbstractRepository {
    public function construireDepuisTableauSQL(array $objetFormatTableau): Trajet {
        $trajet = new Trajet(
            $objetFormatTableau["id"] ?? null,
            $objetFormatTableau["depart"],
            $objetFormatTableau["arrivee"],
            new DateTime($objetFormatTableau["date"]),
            $objetFormatTableau["prix"],
            (new UtilisateurRepository())->recupererParClePrimaire($objetFormatTableau["conducteurLogin"]),
            $objetFormatTableau["nonFumeur"] ?? false,
        );

        // Récupérer la liste des passagers si le trajet existe déjà
        if(!is_null($trajet->getId())) {
            $trajet->setPassagers(self::recupererPassagers($trajet));
        }
        return $trajet;
    }

    /**
     * @return Utilisateur[]
     */
    private static function recupererPassagers(Trajet $trajet): array {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare("SELECT * FROM passager JOIN utilisateur ON passagerLogin = login WHERE trajetId = :trajetIdTag");
        $pdoStatement->execute(['trajetIdTag' => $trajet->getId()]);

        $utilisateurs = [];
        foreach($pdoStatement as $passager) {
            $utilisateurs[] = (new UtilisateurRepository)->construireDepuisTableauSQL($passager);
        }
        return $utilisateurs;
    }

    protected function getNomTable(): string {
        return "trajet";
    }

    protected function getClePrimaire(): string {
        return "id";
    }
}