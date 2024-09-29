<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\Repository\TrajetRepository;

class ControleurTrajet {
    public static function afficherListe() : void {
        $trajets = TrajetRepository::recupererTrajets();
        self::afficherVue("liste.php", ["titre" => "Liste des trajets", 'trajets' => $trajets]);
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