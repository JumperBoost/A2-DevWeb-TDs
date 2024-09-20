<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\ModeleUtilisateur;

class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        self::afficherVue("liste.php", ["titre" => "Liste des utilisateurs", 'utilisateurs' => $utilisateurs]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        $login = $_GET["login"];
        $utilisateur = ModeleUtilisateur::recupererUtilisateurParLogin($login);
        if(!is_null($utilisateur))
            self::afficherVue("detail.php", ["titre" => "Détail d'un utilisateur", 'utilisateur' => $utilisateur]);
        else self::afficherErreur();
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue("formulaireCreation.php", ["titre" => "Formulaire Utilisateur"]);
    }

    public static function creerDepuisFormulaire() : void {
        $utilisateur = ModeleUtilisateur::construireDepuisTableauSQL($_GET);
        if($utilisateur->ajouter())
            self::afficherVue("utilisateurCree.php", ["titre" => "Liste des utilisateurs"]);
        else self::afficherErreur();
    }

    private static function afficherErreur() : void {
        self::afficherVue("erreur.php", ["titre" => "Erreur utilisateur"]);
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        $cheminCorpsVue = "utilisateur/$cheminVue";
        require __DIR__ . "/../vue/vueGenerale.php";
    }
}
