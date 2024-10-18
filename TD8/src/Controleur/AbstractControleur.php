<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;

abstract class AbstractControleur {
    protected static abstract function getCheminCorpsVue(): string;

    protected static function afficherErreur(string $messageErreur = "") : void {
        if(empty($messageErreur))
            $messageErreur = "Problème avec " . static::class;
        else $messageErreur = "Problème avec " . static::class . " : $messageErreur";
        self::afficherVue("erreur.php", ["titre" => "Erreur " . static::class, "message" => $messageErreur]);
    }

    protected static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        $cheminCorpsVue = static::getCheminCorpsVue() . "/$cheminVue";
        $_estConnecte = ConnexionUtilisateur::estConnecte();
        require __DIR__ . "/../vue/vueGenerale.php";
    }
}