<?php
namespace App\Covoiturage\Modele\HTTP;

use App\Covoiturage\Configuration\ConfigurationSite;
use Exception;

class Session {
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct() {
        if(session_start() === false)
            throw new Exception("La session n'a pas réussi à démarrer.");
    }

    public static function getInstance(): Session {
        if(is_null(Session::$instance) || self::$instance->verifierDerniereActivite()) {
            Session::$instance = new Session();
            $_SESSION['derniereActivite'] = time();
        }
        return Session::$instance;
    }

    public function contient($nom): bool {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed {
        return $_SESSION[$nom];
    }

    public function supprimer($nom): void {
        unset($_SESSION[$nom]);
    }

    public function detruire(): void {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
        // Il faudra reconstruire la session au prochain appel de getInstance()
        Session::$instance = null;
    }

    public function verifierDerniereActivite(): bool {
        if (isset($_SESSION['derniereActivite'])) {
            if(time() - $_SESSION['derniereActivite'] > ConfigurationSite::getDureeExpirationSession()) {
                $this->detruire();
                return true;
            } else $_SESSION['derniereActivite'] = time();
        }
        return false;
    }
}