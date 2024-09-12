<?php
require_once 'Trajet.php';

$trajet = Trajet::construireDepuisTableauSQL($_POST);
$trajet->ajouter();
echo "Le trajet a été créé avec succès.";