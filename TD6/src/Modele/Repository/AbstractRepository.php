<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use PDO;

abstract class AbstractRepository {
    protected abstract function getNomTable(): string;

    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;

    /**
     * @return AbstractDataObject[]
     */
    public function recuperer(): array {
        $pdo = ConnexionBaseDeDonnees::getPdo();
        $pdoStatement = $pdo->query("SELECT * FROM {$this->getNomTable()}", PDO::FETCH_ASSOC);

        $dataObjects = [];
        foreach($pdoStatement as $ligne) {
            $dataObjects[] = $this->construireDepuisTableauSQL($ligne);
        }
        return $dataObjects;
    }
}