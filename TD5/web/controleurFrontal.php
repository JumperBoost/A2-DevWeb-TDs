<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
use App\Covoiturage\Controleur\ControleurUtilisateur;

$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();

$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

$action = $_GET["action"];
ControleurUtilisateur::$action();