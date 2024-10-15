<?php
namespace App\Covoiturage\Modele\HTTP;

class Cookie {
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void {
        $_COOKIE[$cle] = $valeur;
        setcookie($cle, $valeur, !is_null($dureeExpiration) ? time() + $dureeExpiration : 0);
    }

    public static function lire(string $cle): mixed {
        return $_COOKIE[$cle];
    }

    public static function contient($cle) : bool {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer($cle) : void {
        unset($_COOKIE[$cle]);
        setcookie($cle, "", 1);
    }
}