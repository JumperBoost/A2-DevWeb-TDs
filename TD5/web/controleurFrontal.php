<?php
require_once __DIR__ . '/../src/Controleur/ControleurUtilisateur.php';

$action = $_GET["action"];
ControleurUtilisateur::$action();