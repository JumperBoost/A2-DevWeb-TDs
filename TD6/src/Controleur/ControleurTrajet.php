<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\Repository\TrajetRepository;

class ControleurTrajet {
    public static function afficherListe() : void {
        $trajets = (new TrajetRepository())->recuperer();
        self::afficherVue("liste.php", ["titre" => "Liste des trajets", 'trajets' => $trajets]);
    }

    public static function afficherDetail() : void {
        $id = $_GET["id"];
        $trajet = (new TrajetRepository())->recupererParClePrimaire($id);
        if(!is_null($trajet))
            self::afficherVue("detail.php", ["titre" => "Détail d'un trajet", 'trajet' => $trajet]);
        else self::afficherErreur("Le trajet n'existe pas.");
    }

    public static function afficherFormulaireCreation(): void {
        self::afficherVue("formulaireCreation.php", ["titre" => "Formulaire trajet"]);
    }

    public static function supprimer(): void {
        $id = $_GET["id"];
        if((new TrajetRepository())->supprimer($id))
            self::afficherVue("trajetSupprime.php", ["titre" => "Détail d'un trajet", 'id' => $id]);
        else self::afficherErreur("Le trajet n'existe pas.");
    }

    public static function afficherErreur(string $messageErreur = "") : void {
        if(empty($messageErreur))
            $messageErreur = "Problème avec le trajet";
        else $messageErreur = "Problème avec le trajet : $messageErreur";
        self::afficherVue("erreur.php", ["titre" => "Erreur trajet", "message" => $messageErreur]);
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        $cheminCorpsVue = "trajet/$cheminVue";
        require __DIR__ . "/../vue/vueGenerale.php";
    }
}