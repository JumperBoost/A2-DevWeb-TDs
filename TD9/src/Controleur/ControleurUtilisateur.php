<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Lib\MotDePasse;
use App\Covoiturage\Lib\VerificationEmail;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\HTTP\Session;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ControleurUtilisateur extends AbstractControleur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer(); //appel au modèle pour gérer la BD
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        self::afficherVue("liste.php", ["titre" => "Liste des utilisateurs", 'utilisateurs' => $utilisateurs, "estAdmin" => $estAdmin]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        $login = $_GET["login"] ?? ConnexionUtilisateur::getLoginUtilisateurConnecte();
        if(!is_null($login)) {
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if(!is_null($utilisateur))
                self::afficherVue("detail.php", ["titre" => "Détail d'un utilisateur", 'utilisateur' => $utilisateur]);
            else self::afficherWarning("utilisateur", "afficherListe", ["Login inconnu"]);
        } else self::afficherErreur("utilisateur", "afficherListe", ["Impossible de récupérer le login."]);
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue("formulaireCreation.php", ["titre" => "Formulaire Utilisateur"]);
    }

    public static function creerDepuisFormulaire() : void {
        $mdpInput1 = $_GET['mdpHache'];
        $mdpInput2 = $_GET['mdpHache2'];
        if($mdpInput1 == $mdpInput2) {
            $_GET['emailAValider'] = $_GET['email'];
            $_GET['email'] = "";
            if(filter_var($_GET['emailAValider'], FILTER_VALIDATE_EMAIL)) {
                $_GET['nonce'] = MotDePasse::genererChaineAleatoire();
                $utilisateur = self::construireDepuisFormulaire($_GET);
                if((new UtilisateurRepository())->ajouter($utilisateur)) {
                    VerificationEmail::envoiEmailValidation($utilisateur);
                    self::afficherSucces("utilisateur", "afficherListe", ["L'utilisateur a bien été créé !"]);
                } else self::afficherErreur("utilisateur", "afficherFormulaireCreation", ["Impossible d'ajouter l'utilisateur."]);
            } else self::afficherWarning("utilisateur", "afficherFormulaireCreation", ["L'email indiqué n'est pas une adresse mail valide."]);
        } else self::afficherWarning("utilisateur", "afficherFormulaireCreation", ["Mots de passe distincts"]);
    }

    public static function supprimer() : void {
        $login = $_GET["login"] ?? null;
        if(!is_null($login)) {
            if(!is_null((new UtilisateurRepository())->recupererParClePrimaire($login))) {
                if(ConnexionUtilisateur::estUtilisateur($login)) {
                    if((new UtilisateurRepository())->supprimer($login)) {
                        ConnexionUtilisateur::deconnecter();
                        self::afficherSucces("utilisateur", "afficherListe", ["L'utilisateur a bien été supprimé !"]);
                    } else self::afficherErreur("utilisateur", "afficherListe", ["Impossible de supprimer l'utilisateur."]);
                } else self::afficherWarning("utilisateur", "afficherListe", ["Vous ne pouvez modifier que votre compte."]);
            } else self::afficherWarning("utilisateur", "afficherListe", ["L'utilisateur référencé est incorrect."]);
        } else self::afficherErreur("utilisateur", "afficherListe", ["Le champ de l'identifiant est manquant."]);
    }

    public static function mettreAJour() : void {
        $login = $_GET['login'] ?? null;
        $mdpInput1 = $_GET['mdpHache'] ?? null;
        $mdpInput2 = $_GET['mdpHache2'] ?? null;
        $ancienMdp = $_GET['oldMdpHache'] ?? null;
        $email = $_GET['email'] ?? null;
        if(!is_null($login) && isset($_GET['nom']) && isset($_GET['prenom']) && !is_null($ancienMdp)
            && !is_null($mdpInput1) && !is_null($mdpInput2) && !is_null($email)) {
            if(ConnexionUtilisateur::estUtilisateur($login) || ConnexionUtilisateur::estAdministrateur()) {
                if(!is_null((new UtilisateurRepository())->recupererParClePrimaire($login))) {
                    if(ConnexionUtilisateur::estUtilisateur($login)) {
                        $utilisateur = self::construireDepuisFormulaire($_GET);
                        if(ConnexionUtilisateur::estAdministrateur() || MotDePasse::verifier($ancienMdp, $utilisateur->getMdpHache())) {
                            if($mdpInput1 == $mdpInput2) {
                                /** @var Utilisateur $utilisateurBDD */
                                $utilisateurBDD = (new UtilisateurRepository())->recupererParClePrimaire($login);
                                if($utilisateurBDD->getEmail() != $utilisateur->getEmail()) {
                                    if(filter_var($utilisateur->getEmail(), FILTER_VALIDATE_EMAIL)) {
                                        $utilisateur->setEmailAValider($utilisateur->getEmail());
                                        $utilisateur->setEmail($utilisateurBDD->getEmail());
                                        $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());
                                        VerificationEmail::envoiEmailValidation($utilisateur);
                                    } else self::afficherWarning("utilisateur", "afficherFormulaireMisAJour", ["L'email indiqué n'est pas une adresse mail valide."]);
                                }
                                (new UtilisateurRepository())->mettreAJour($utilisateur);
                                self::afficherSucces("utilisateur", "afficherListe", ["L’utilisateur de login " . htmlspecialchars($login) . " a bien été mis à jour"]);
                            } self::afficherWarning("utilisateur", "afficherFormulaireMisAJour", ["Mots de passe distincts"], ["login" => $utilisateur->getLogin()]);
                        } else self::afficherWarning("utilisateur", "afficherFormulaireMisAJour", ["L'ancien mot de passe indiqué est incorrect."], ["login" => $utilisateur->getLogin()]);
                    } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["Vous ne pouvez modifier que votre compte."]);
                } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["Login inconnu."]);
            } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["La mise à jour n'est possible que pour l'utilisateur connecté."]);
        } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["Un ou plusieurs champs sont manquants."]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        $login = $_GET["login"] ?? null;
        if(!is_null($login) && (ConnexionUtilisateur::estUtilisateur($login) || ConnexionUtilisateur::estAdministrateur())) {
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if(!is_null($utilisateur)) {
                self::afficherVue("formulaireMiseAJour.php", ["titre" => "Formulaire mise à jour utilisateur", "utilisateur" => $utilisateur]);
            } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["Login inconnu."]);
        } else self::afficherErreur("utilisateur", "afficherFormulaireMisAJour", ["La mise à jour n'est possible que pour l'utilisateur connecté."]);
    }

    public static function afficherFormulaireConnexion(): void {
        self::afficherVue("formulaireConnexion.php", ["titre" => "Formulaire de connexion"]);
    }

    public static function validerEmail(): void {
        $login = $_GET['login'] ?? null;
        $nonce= $_GET['nonce'] ?? null;
        if(!is_null($login) && !is_null($nonce)) {
            if(VerificationEmail::traiterEmailValidation($login, $nonce)) {
                ConnexionUtilisateur::connecter($login);
                self::afficherSucces("utilisateur", "afficherDetail", ["L'adresse mail a été validé avec succès."]);
            } else self::afficherErreur("utilisateur", "afficherListe", ["Le login et/ou le nonce est incorrect."]);
        } else self::afficherErreur("utilisateur", "afficherListe", ["Le login et/ou le nonce est manquant."]);
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

    public static function connecter(): void {
        $login = $_GET['login'] ?? null;
        $mdp = $_GET['mdp'] ?? null;
        if(!is_null($login) && !is_null($mdp)) {
            /** @var Utilisateur $utilisateur */
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if(!is_null($utilisateur) && MotDePasse::verifier($mdp, $utilisateur->getMdpHache())) {
                if(VerificationEmail::aValideEmail($utilisateur)) {
                    ConnexionUtilisateur::connecter($login);
                    self::afficherSucces("utilisateur", "afficherDetail", ["Utilisateur connecté"]);
                } else self::afficherWarning("utilisateur", "afficherFormulaireConnexion", ["L'adresse mail de l'utilisateur n'a pas encore été vérifié."]);
            } else self::afficherWarning("utilisateur", "afficherFormulaireConnexion", ["Login et/ou mot de passe incorrect."]);
        } else self::afficherErreur("utilisateur", "afficherFormulaireConnexion", ["Login et/ou mot de passe manquant."]);
    }

    public static function deconnecter(): void {
        if(ConnexionUtilisateur::estConnecte()) {
            ConnexionUtilisateur::deconnecter();
            $utilisateurs = (new UtilisateurRepository())->recuperer();
            $estAdmin = ConnexionUtilisateur::estAdministrateur();
            self::afficherSucces("utilisateur", "afficherListe", ["Utilisateur déconnecté"]);
        } else self::afficherErreur("utilisateur", "afficherFormulaireConnexion", ["Impossible de vous deconnecter : vous n'êtes pas connecté."]);
    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        $tableauDonneesFormulaire['mdpHache'] = MotDePasse::hacher($tableauDonneesFormulaire['mdpHache']);
        $tableauDonneesFormulaire['estAdmin'] = ConnexionUtilisateur::estAdministrateur() && isset($tableauDonneesFormulaire['estAdmin']);
        return (new UtilisateurRepository())->construireDepuisTableauSQL($tableauDonneesFormulaire);
    }

    protected static function getCheminCorpsVue(): string {
        return "utilisateur";
    }
}
