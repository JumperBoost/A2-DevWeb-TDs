<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Controleur\AbstractControleur;
use App\Covoiturage\Lib\PreferenceControleur;

$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();

$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

// Définir un paramètre par défaut
if(!isset($_GET["action"]))
    $_GET["action"] = "afficherListe";
if(!isset($_GET["controleur"]))
    $_GET["controleur"] = PreferenceControleur::existe() ? PreferenceControleur::lire() : "utilisateur";

$action = $_GET["action"];
$controleur = $_GET["controleur"];

$nomDeClasseControleur = 'App\Covoiturage\Controleur\Controleur'.ucfirst($controleur);
if(class_exists($nomDeClasseControleur) && in_array($action, get_class_methods($nomDeClasseControleur))) {
    $nomDeClasseControleur::$action();
} else {
    (new class extends AbstractControleur {
        protected static function getCheminCorpsVue(): string { return '.'; }
        public function declencherErreur(string $message): void { static::afficherErreur("utilisateur", "afficherListe", [$message]); }
    })->declencherErreur("Impossible de trouver la classe Controleur" . ucfirst($controleur) . " ou l'action associée");
}