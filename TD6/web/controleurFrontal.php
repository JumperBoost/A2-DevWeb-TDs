<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
use App\Covoiturage\Controleur\ControleurUtilisateur;

$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();

$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

// Définir un paramètre par défaut
if(!isset($_GET["action"]))
    $_GET["action"] = "afficherListe";
$action = $_GET["action"];

$methodes = get_class_methods("App\\Covoiturage\\Controleur\\ControleurUtilisateur");
if(in_array($action, $methodes))
    ControleurUtilisateur::$action();
else ControleurUtilisateur::afficherErreur("La méthode $action n'existe pas.");