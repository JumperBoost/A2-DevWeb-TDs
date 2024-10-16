<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use DateTime;

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
            $trajet->setPassagers($this->recupererPassagers($trajet));
        }
        return $trajet;
    }

    /**
     * @return Utilisateur[]
     */
    private function recupererPassagers(Trajet $trajet): array {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare("SELECT * FROM passager JOIN utilisateur ON passagerLogin = login WHERE trajetId = :trajetIdTag");
        $pdoStatement->execute(['trajetIdTag' => $trajet->getId()]);

        $utilisateurs = [];
        foreach($pdoStatement as $passager) {
            $utilisateurs[] = (new UtilisateurRepository)->construireDepuisTableauSQL($passager);
        }
        return $utilisateurs;
    }

    /**
     * @param Trajet $trajet
     * @return Utilisateur[]
     */
    public function recupererPassagersOuConducteursPotentiel(Trajet $trajet): array {
        $passagersPotentiel = (new UtilisateurRepository())->recuperer();
        $passagersASupprimer = array_merge(array_values($trajet->getPassagers()), [$trajet->getConducteur()]);
        foreach($passagersASupprimer as $passagerASup)
            unset($passagersPotentiel[array_keys(array_filter($passagersPotentiel, fn ($p) => $p->getLogin() == $passagerASup->getLogin()))[0]]);

        return $passagersPotentiel;
    }

    protected function getNomTable(): string {
        return "trajet";
    }

    protected function getClesPrimaires(): array {
        return ["id"];
    }

    protected function getNomsColonnes(): array {
        return ["id", "depart", "arrivee", "date", "prix", "conducteurLogin", "nonFumeur"];
    }

    /**
     * @param Trajet $trajet
     * @return array
     */
    protected function formatTableauSQL(AbstractDataObject $trajet): array {
        return array(
            "idTag" => $trajet->getId(),
            "departTag" => $trajet->getDepart(),
            "arriveeTag" => $trajet->getArrivee(),
            "dateTag" => $trajet->getDate()->format("Y-m-d"),
            "prixTag" => $trajet->getPrix(),
            "conducteurLoginTag" => !is_null($trajet->getConducteur()) ? $trajet->getConducteur()->getLogin() : null,
            "nonFumeurTag" => intval($trajet->isNonFumeur())
        );
    }
}