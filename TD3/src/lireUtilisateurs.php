<?php
require_once 'Utilisateur.php';

$utilisateurs = Utilisateur::recupererUtilisateurs();
foreach ($utilisateurs as $utilisateur) {
    echo "<h2>$utilisateur</h2>";
    echo "<h3>Trajets passager</h3><ul>";
    $trajets_p = $utilisateur->getTrajetsCommePassager();
    foreach ($trajets_p as $trajet_p) {
        echo "<li>$trajet_p</li>";
    }
    echo "</ul><h3>Trajets conducteur</h3><ul>";
    $trajets_c = $utilisateur->getTrajetsCommeConducteur();
    foreach ($trajets_c as $trajet_c) {
        echo "<li>$trajet_c</li>";
    }
    echo "</ul>";
}