<?php
namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\HTTP\Session;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ConnexionUtilisateur {
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void {
        if(!self::estConnecte())
            Session::getInstance()->enregistrer(self::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    public static function estAdministrateur() : bool {
        /** @var Utilisateur $utilisateur */
        if(self::estConnecte()) {
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(self::getLoginUtilisateurConnecte());
            return $utilisateur->isAdmin();
        }
        return false;
    }

    public static function deconnecter(): void {
        if(self::estConnecte())
            Session::getInstance()->supprimer(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string {
        return self::estConnecte() ? Session::getInstance()->lire(self::$cleConnexion) : null;
    }

    public static function estUtilisateur(string $login): bool {
        return self::estConnecte() && self::getLoginUtilisateurConnecte() == $login;
    }
}