<?php
require_once 'Utilisateur.php';

$utilisateurs = Utilisateur::recupererUtilisateurs();
foreach ($utilisateurs as $utilisateur) {
    echo "<h2>$utilisateur</h2>";
    echo "<h3>Trajets passager</h3><ul>";
    $trajets = $utilisateur->getTrajetsCommePassager();
    foreach ($trajets as $trajet) {
        echo "<li>$trajet</li>";
    }
    echo "</ul>";
}