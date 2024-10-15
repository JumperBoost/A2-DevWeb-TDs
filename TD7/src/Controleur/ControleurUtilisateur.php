<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ControleurUtilisateur extends AbstractControleur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer(); //appel au modèle pour gérer la BD
        self::afficherVue("liste.php", ["titre" => "Liste des utilisateurs", 'utilisateurs' => $utilisateurs]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        $login = $_GET["login"];
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        if(!is_null($utilisateur))
            self::afficherVue("detail.php", ["titre" => "Détail d'un utilisateur", 'utilisateur' => $utilisateur]);
        else self::afficherErreur("L'utilisateur n'existe pas.");
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue("formulaireCreation.php", ["titre" => "Formulaire Utilisateur"]);
    }

    public static function creerDepuisFormulaire() : void {
        $utilisateur = self::construireDepuisFormulaire($_GET);
        if((new UtilisateurRepository())->ajouter($utilisateur))
            self::afficherVue("utilisateurCree.php", ["titre" => "Liste des utilisateurs"]);
        else self::afficherErreur("Impossible d'ajouter l'utilisateur.");
    }

    public static function supprimer() : void {
        $login = $_GET["login"];
        if((new UtilisateurRepository())->supprimer($login))
            self::afficherVue("utilisateurSupprime.php", ["titre" => "Liste des utilisateurs", "login" => $login]);
        else self::afficherErreur("Impossible de supprimer l'utilisateur.");
    }

    public static function mettreAJour() : void {
        $utilisateur = self::construireDepuisFormulaire($_GET);
        (new UtilisateurRepository())->mettreAJour($utilisateur);
        self::afficherVue("utilisateurMisAJour.php", ["titre" => "Liste des utilisateurs", "login" => $utilisateur->getLogin()]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        $login = $_GET["login"];
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        if(!is_null($utilisateur)) {
            self::afficherVue("formulaireMiseAJour.php", ["titre" => "Formulaire mise à jour utilisateur", "utilisateur" => $utilisateur]);
        } else self::afficherErreur("L'utilisateur inséré n'existe pas.");
    }

    /*public static function deposerCookie(): void {
        Cookie::enregistrer("hello", 123, 10);
        echo "Un cookie a été déposé.";
    }

    public static function lireCookie(): void {
        echo "Voici le contenu du cookie : " . Cookie::lire("hello"). ".";
    }*/

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        return (new UtilisateurRepository())->construireDepuisTableauSQL($tableauDonneesFormulaire);
    }

    protected static function getCheminCorpsVue(): string {
        return "utilisateur";
    }
}
