<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
use App\Covoiturage\Controleur\ControleurUtilisateur;

$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();

$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

// Définir un paramètre par défaut
if(!isset($_GET["action"]))
    $_GET["action"] = "afficherListe";
if(!isset($_GET["controleur"]))
    $_GET["controleur"] = "utilisateur";

$action = $_GET["action"];
$controleur = $_GET["controleur"];

$nomDeClasseControleur = "App\\Covoiturage\\Controleur\\Controleur" . ucfirst($controleur);
if(class_exists($nomDeClasseControleur)) {
    $methodes = get_class_methods($nomDeClasseControleur);
    if (in_array($action, $methodes))
        $nomDeClasseControleur::$action();
    else $nomDeClasseControleur::afficherErreur("La méthode $action n'existe pas.");
} else ControleurUtilisateur::afficherErreur("La classe " . ucfirst($controleur) . " n'existe pas."); // ControleurUtilisateur est temporairement utilisé pour afficher une erreur