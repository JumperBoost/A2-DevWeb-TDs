<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use PDO;
use PDOException;

abstract class AbstractRepository {
    protected abstract function getNomTable(): string;

    protected abstract function getClePrimaire(): string;

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

    /**
     * @return AbstractDataObject|null
     */
    public function recupererParClePrimaire(string $clePrimaire): ?AbstractDataObject {
        $sql = "SELECT * FROM {$this->getNomTable()} WHERE {$this->getClePrimaire()} = :clePrimaireTag";
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "clePrimaireTag" => $clePrimaire
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant
        $objetFormatTableau = $pdoStatement->fetch();

        if($objetFormatTableau)
            return $this->construireDepuisTableauSQL($objetFormatTableau);
        else return null;
    }

    public function supprimer(string $valeurClePrimaire): bool {
        $sql = "DELETE FROM {$this->getNomTable()} WHERE {$this->getClePrimaire()} = :clePrimaireTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = [
            'clePrimaireTag' => $valeurClePrimaire
        ];
        try {
            $pdoStatement->execute($values);
        } catch (PDOException) {
            return false;
        }
        return true;
    }
}