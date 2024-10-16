<?php
namespace App\Covoiturage\Configuration;

class ConfigurationSite {
    static private array $configurationSite = array(
        'dureeExpirationSession' => 15 * 60
    );

    public static function getDureeExpirationSession(): int {
        return self::$configurationSite['dureeExpirationSession'];
    }
}