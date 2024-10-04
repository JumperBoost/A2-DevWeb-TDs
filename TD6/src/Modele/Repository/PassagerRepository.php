<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Passager;

class PassagerRepository extends AbstractRepository {

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Passager {
        return new Passager($objetFormatTableau["id"],$objetFormatTableau["passagerLogin"]);
    }

    protected function getNomTable(): string {
        return "passager";
    }

    /**
     * @return string[]
     */
    protected function getClesPrimaires(): array {
        return ["trajetId", "passagerLogin"];
    }

    protected function getNomsColonnes(): array {
        return $this->getClesPrimaires();
    }

    /**
     * @param Passager $objet
     * @return array
     */
    protected function formatTableauSQL(AbstractDataObject $objet): array {
        return array(
            "trajetIdTag" => $objet->getTrajet()->getId(),
            "passagerLoginTag" => $objet->getPassager()->getLogin()
        );
    }
}