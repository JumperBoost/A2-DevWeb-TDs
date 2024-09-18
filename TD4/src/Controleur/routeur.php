<?php
require_once 'ControleurUtilisateur.php';

$action = $_GET["action"];
ControleurUtilisateur::$action();