<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\PreferenceControleur;

class ControleurGenerique extends AbstractControleur {
    public static function afficherFormulairePreference(): void {
        $preference = PreferenceControleur::existe() ? PreferenceControleur::lire() : "utilisateur";
        self::afficherVue("formulairePreference.php", ["titre" => "Formulaire de préférences", "preference" => $preference]);
    }

    public static function enregistrerPreference(): void {
        $controleur = $_GET['controleur_defaut'];
        PreferenceControleur::enregistrer($controleur);
        self::afficherVue("preferenceEnregistree.php", ["titre" => "Confirmation d'enregistrement"]);
    }

    protected static function getCheminCorpsVue(): string {
        return ".";
    }
}