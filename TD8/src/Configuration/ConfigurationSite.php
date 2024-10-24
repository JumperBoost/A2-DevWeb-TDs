<?php
namespace App\Covoiturage\Configuration;

class ConfigurationSite {
    static private array $configurationSite = array(
        'dureeExpirationSession' => 15 * 60
    );

    public static function getDureeExpirationSession(): int {
        return self::$configurationSite['dureeExpirationSession'];
    }

    public static function getURLAbsolue(): string {
        $ref = $_SERVER['REQUEST_URI'] ?? null;
        return "http://{$_SERVER['HTTP_HOST']}" . str_contains($_SERVER['REQUEST_URI'], "?") ? explode("?", $ref)[0] : $_SERVER["REQUEST_URI"];
    }
}