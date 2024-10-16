<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\MotDePasse;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\HTTP\Session;
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
        $mdpInput1 = $_GET['mdpHache'];
        $mdpInput2 = $_GET['mdpHache2'];
        if($mdpInput1 == $mdpInput2) {
            $utilisateur = self::construireDepuisFormulaire($_GET);
            if((new UtilisateurRepository())->ajouter($utilisateur))
                self::afficherVue("utilisateurCree.php", ["titre" => "Liste des utilisateurs"]);
            else self::afficherErreur("Impossible d'ajouter l'utilisateur.");
        } else self::afficherErreur("Mots de passe distincts");
    }

    public static function supprimer() : void {
        $login = $_GET["login"];
        if((new UtilisateurRepository())->supprimer($login))
            self::afficherVue("utilisateurSupprime.php", ["titre" => "Liste des utilisateurs", "login" => $login]);
        else self::afficherErreur("Impossible de supprimer l'utilisateur.");
    }

    public static function mettreAJour() : void {
        $mdpInput1 = $_GET['mdpHache'];
        $mdpInput2 = $_GET['mdpHache2'];
        // TODO: Vérification de l'ancien mot de passe depuis la bdd à implémenter
        if($mdpInput1 == $mdpInput2) {
            $utilisateur = self::construireDepuisFormulaire($_GET);
            (new UtilisateurRepository())->mettreAJour($utilisateur);
            self::afficherVue("utilisateurMisAJour.php", ["titre" => "Liste des utilisateurs", "login" => $utilisateur->getLogin()]);
        } else self::afficherErreur("Mots de passe distincts");
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

    public static function creerSession(): void {
        Session::getInstance()->enregistrer("key1", "value1");
        Session::getInstance()->enregistrer("key2", 2);
        Session::getInstance()->enregistrer("key3", ["subkey_1" => "subvalue_1", "subkey_2" => 2.5]);

        echo "<p>" . Session::getInstance()->lire("key1") . "</p>";
        echo "<p>" . Session::getInstance()->lire("key2") . "</p>";
        echo "<p>key2 existe: " . intval(Session::getInstance()->contient("key2")) . "</p>";
        var_dump(Session::getInstance()->lire("key3"));

        Session::getInstance()->supprimer("key2");
        echo "<p>key2 existe: " . intval(Session::getInstance()->contient("key2")) . "</p>";

        Session::getInstance()->detruire();
        echo "<p>" . intval(isset($_SESSION['key1'])) . "</p>";
    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        $tableauDonneesFormulaire['mdpHache'] = MotDePasse::hacher($tableauDonneesFormulaire['mdpHache']);
        return (new UtilisateurRepository())->construireDepuisTableauSQL($tableauDonneesFormulaire);
    }

    protected static function getCheminCorpsVue(): string {
        return "utilisateur";
    }
}
