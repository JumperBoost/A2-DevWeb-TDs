<?php
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\DataObject\Trajet;

/**
 * @var Trajet $trajet
 * @var Utilisateur $utilisateur
 */
echo "<p>Le passager " . htmlspecialchars($utilisateur->getNom()) . " " . htmlspecialchars($utilisateur->getPrenom()) . " de login " . htmlspecialchars($utilisateur->getLogin()) . " a bien été inscrit au trajet id {$trajet->getId()}</p>";

require __DIR__ . "/../trajet/detail.php";