<?php
namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Session;

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

    public static function deconnecter(): void {
        if(self::estConnecte())
            Session::getInstance()->supprimer(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string {
        return self::estConnecte() ? Session::getInstance()->lire(self::$cleConnexion) : null;
    }
}