<?php
namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Session;

class MessageFlash {
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    private static function lireTab(): array {
        return Session::getInstance()->contient(static::$cleFlash) ? Session::getInstance()->lire(static::$cleFlash) : [];
    }

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void {
        $tab = self::lireTab();
        $tab[$type][] = $message;
        Session::getInstance()->enregistrer(static::$cleFlash, $tab);
    }

    public static function contientMessage(string $type): bool {
        $tab = self::lireTab();
        return in_array($type, $tab);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array {
        $tab = self::lireTab();
        $messages = [$type => $tab[$type] ?? []];
        unset($tab[$type]);
        Session::getInstance()->enregistrer(static::$cleFlash, $tab);
        return $messages;
    }

    public static function lireTousMessages(): array {
        $tab = self::lireTab();
        Session::getInstance()->supprimer(static::$cleFlash);
        return $tab;
    }
}