<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use PDO;
use PDOException;

abstract class AbstractRepository {
    protected abstract function getNomTable(): string;

    /** @return string[] */
    protected abstract function getClesPrimaires(): array;

    /** @return string[] */
    protected abstract function getNomsColonnes(): array;

    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;

    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

    /**
     * @param string ...$clesPrimaires valeur(s) de(s) clé(s) primaire(s) dans l'ordre
     * @return array(array, array)
     */
    private function getClePrimaireTableauxWhereEtTag(string ...$clesPrimaires): array {
        $tableauClePrimaire = $this->getClesPrimaires();
        $tableauWhere = [];
        $tableauTag = [];

        for($i = 0; $i < count($tableauClePrimaire); $i++) {
            $clePrimaire = $tableauClePrimaire[$i];
            $tableauTag[$clePrimaire . "Tag"] = $clesPrimaires[$i];
            $tableauWhere[] = $clePrimaire . " = :" . $clePrimaire . "Tag";
        }

        return array($tableauWhere, $tableauTag);
    }

    private function getClePrimaireObjetValeurs(AbstractDataObject $objet): array {
        $tableauClePrimaire = $this->getClesPrimaires();
        $valeurs = [];

        $formatTableauSQL = $this->formatTableauSQL($objet);
        foreach($tableauClePrimaire as $clePrimaire)
            $valeurs[] = $formatTableauSQL[$clePrimaire . "Tag"];

        return $valeurs;
    }

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
     * @param string ...$clesPrimaires valeur(s) de(s) clé(s) primaire(s) dans l'ordre
     * @return AbstractDataObject|null
     */
    public function recupererParClePrimaire(string ...$clesPrimaires): ?AbstractDataObject {
        $tableauWhereEtTag = $this->getClePrimaireTableauxWhereEtTag(...$clesPrimaires);
        $sql = "SELECT * FROM {$this->getNomTable()} WHERE " . join(" AND ", $tableauWhereEtTag[0]);
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($tableauWhereEtTag[1]);

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

    public function mettreAJour(AbstractDataObject $objet): void {
        $setValues = [];
        $nomColonnes = $this->getNomsColonnes();
        $formatTableauSQL = $this->formatTableauSQL($objet);
        $tableauTag = array_keys($formatTableauSQL);
        for($i = 0; $i < count($nomColonnes); $i++)
            $setValues[] = $nomColonnes[$i] . " = :" . $tableauTag[$i];

        $tableauWhereEtTag = $this->getClePrimaireTableauxWhereEtTag(...$this->getClePrimaireObjetValeurs($objet));
        $sql = "UPDATE {$this->getNomTable()} SET " . join(",", $setValues) . " WHERE " . join(" AND ", $tableauWhereEtTag[0]);
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute($this->formatTableauSQL($objet));
    }

    public function supprimer(string ...$valeurClePrimaire): bool {
        $tableauWhereEtTag = $this->getClePrimaireTableauxWhereEtTag(...$valeurClePrimaire);
        $sql = "DELETE FROM {$this->getNomTable()} WHERE " . join(" AND ", $tableauWhereEtTag[0]);
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        try {
            $pdoStatement->execute($tableauWhereEtTag[1]);
        } catch (PDOException) {
            return false;
        }
        return $pdoStatement->rowCount() > 0;
    }
}