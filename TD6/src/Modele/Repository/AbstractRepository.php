<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use PDO;
use PDOException;

abstract class AbstractRepository {
    protected abstract function getNomTable(): string;

    protected abstract function getClePrimaire(): string;

    /** @return string[] */
    protected abstract function getNomsColonnes(): array;

    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;

    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

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

    public function ajouter(AbstractDataObject $objet): bool {
        $formatTableauSqlTag = array_keys($this->formatTableauSQL($objet));
        for($i = 0; $i < count($formatTableauSqlTag); $i++)
            $formatTableauSqlTag[$i] = ":" . $formatTableauSqlTag[$i];

        $sql = "INSERT INTO {$this->getNomTable()} (" . join(",", $this->getNomsColonnes()) . ") VALUES (" . join(",", $formatTableauSqlTag) . ")";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        try {
            $pdoStatement->execute($this->formatTableauSQL($objet));
        } catch (PDOException) {
            return false;
        }
        return true;
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