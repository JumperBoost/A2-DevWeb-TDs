<?php
require_once 'Utilisateur.php';

$utilisateurs = Utilisateur::recupererUtilisateurs();
foreach ($utilisateurs as $utilisateur) {
    echo "<p>$utilisateur</p>";
}