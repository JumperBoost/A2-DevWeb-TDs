<?php
require_once __DIR__ . '/../Modele/ModeleUtilisateur.php'; // chargement du modèle
class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        self::afficherVue("liste.php", ['utilisateurs' => $utilisateurs]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        $login = $_GET["login"];
        $utilisateur = ModeleUtilisateur::recupererUtilisateurParLogin($login);
        if(!is_null($utilisateur))
            self::afficherVue("detail.php", ['utilisateur' => $utilisateur]);
        else self::afficherVue("erreur.php");
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue("formulaireCreation.php");
    }

    public static function creerDepuisFormulaire() : void {
        $utilisateur = ModeleUtilisateur::construireDepuisTableauSQL($_GET);
        if($utilisateur->ajouter())
            self::afficherListe();
        else self::afficherVue("erreur.php");
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        require __DIR__ . "/../vue/utilisateur/$cheminVue";
    }
}
