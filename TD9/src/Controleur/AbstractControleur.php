<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Lib\MessageFlash;

abstract class AbstractControleur {
    protected static abstract function getCheminCorpsVue(): string;

    /**
     * @param string $controleur Controleur de la redirection
     * @param string $action Action de la redirection
     * @param array $messages Messages
     * @param array $args Arguments optionnels
     * @return void
     */
    protected static function afficherErreur(string $controleur, string $action, array $messages, array $args = []): void {
        $url = "?controleur=$controleur&action=$action";
        foreach($args as $key => $value)
            $url .= "&$key=$value";
        foreach($messages as $message)
            MessageFlash::ajouter("danger", $message);
        ControleurGenerique::redirectionVersURL($url);
    }

    /**
     * @param string $controleur Controleur de la redirection
     * @param string $action Action de la redirection
     * @param array $messages Messages
     * @param array $args Arguments optionnels
     * @return void
     */
    protected static function afficherWarning(string $controleur, string $action, array $messages, array $args = []): void {
        $url = "?controleur=$controleur&action=$action";
        foreach($args as $key => $value)
            $url .= "&$key=$value";
        foreach($messages as $message)
            MessageFlash::ajouter("warning", $message);
        ControleurGenerique::redirectionVersURL($url);
    }

    /**
     * @param string $controleur Controleur de la redirection
     * @param string $action Action de la redirection
     * @param array $messages Messages
     * @param array $args Arguments optionnels
     * @return void
     */
    protected static function afficherSucces(string $controleur, string $action, array $messages, array $args = []): void {
        $url = "?controleur=$controleur&action=$action";
        foreach($args as $key => $value)
            $url .= "&$key=$value";
        foreach($messages as $message)
            MessageFlash::ajouter("success", $message);
        ControleurGenerique::redirectionVersURL($url);
    }

    protected static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres);
        $cheminCorpsVue = static::getCheminCorpsVue() . "/$cheminVue";
        $_estConnecte = ConnexionUtilisateur::estConnecte();
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../vue/vueGenerale.php";
    }
}