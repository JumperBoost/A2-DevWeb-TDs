<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ControleurTrajet extends AbstractControleur {
    public static function afficherListe() : void {
        $trajets = (new TrajetRepository())->recuperer();
        self::afficherVue("liste.php", ["titre" => "Liste des trajets", 'trajets' => $trajets]);
    }

    public static function afficherDetail() : void {
        $id = $_GET["id"];
        $trajet = (new TrajetRepository())->recupererParClePrimaire($id);
        if(!is_null($trajet))
            self::afficherVue("detail.php", ["titre" => "Détail d'un trajet", "trajet" => $trajet, "passagersPotentiel" => (new TrajetRepository())->recupererPassagersOuConducteursPotentiel($trajet)]);
        else self::afficherErreur("Le trajet n'existe pas.");
    }

    public static function afficherFormulaireCreation(): void {
        $conducteurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue("formulaireCreation.php", ["titre" => "Formulaire création trajet", "conducteurs" => $conducteurs]);
    }

    public static function creerDepuisFormulaire(): void {
        $trajet = self::construireDepuisFormulaire($_GET);
        if((new TrajetRepository())->ajouter($trajet))
            self::afficherVue("trajetCree.php", ["titre" => "Liste des trajets"]);
        else self::afficherErreur("Impossible d'ajouter le trajet.");
    }

    public static function afficherFormulaireMiseAJour(): void {
        $trajet = (new TrajetRepository())->recupererParClePrimaire($_GET["id"]);
        if(!is_null($trajet)) {
            $conducteurs = (new TrajetRepository())->recupererPassagersOuConducteursPotentiel($trajet);
            self::afficherVue("formulaireMiseAJour.php", ["titre" => "Formulaire mise à jour trajet", "trajet" => $trajet, "conducteurs" => $conducteurs]);
        } else self::afficherErreur("Impossible de récupérer le trajet.");
    }

    public static function supprimer(): void {
        $id = $_GET["id"];
        if((new TrajetRepository())->supprimer($id))
            self::afficherVue("trajetSupprime.php", ["titre" => "Détail d'un trajet", 'id' => $id]);
        else self::afficherErreur("Le trajet n'existe pas.");
    }

    public static function mettreAJour(): void {
        $trajet = self::construireDepuisFormulaire($_GET);
        (new TrajetRepository())->mettreAJour($trajet);
        self::afficherVue("trajetMisAJour.php", ["titre" => "Liste des trajets", "id" => $trajet->getId()]);
    }

    /**
     * @return Trajet
     */
    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Trajet {
        return (new TrajetRepository())->construireDepuisTableauSQL($tableauDonneesFormulaire);
    }

    protected static function getCheminCorpsVue(): string {
        return "trajet";
    }
}