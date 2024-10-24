<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository {
    public function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur {
        return new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom'], $objetFormatTableau['mdpHache'], $objetFormatTableau['email'] ?? "", $objetFormatTableau['emailAValider'] ?? "", $objetFormatTableau['nonce'] ?? "", $objetFormatTableau['estAdmin']);
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
        return ["login", "nom", "prenom", "mdpHache", "estAdmin", "email", "emailAValider", "nonce"];
    }

    /**
     * @param Utilisateur $objet
     * @return array
     */
    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "loginTag" => $objet->getLogin(),
            "nomTag" => $objet->getNom(),
            "prenomTag" => $objet->getPrenom(),
            "mdpHacheTag" => $objet->getMdpHache(),
            "estAdminTag" => intval($objet->isAdmin()),
            "emailTag" => $objet->getEmail(),
            "emailAValiderTag" => $objet->getEmailAValider(),
            "nonceTag" => $objet->getNonce()
        );
    }
}