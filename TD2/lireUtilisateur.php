<?php
require_once 'Utilisateur.php';

$utilisateurs = Utilisateur::getUtilisateurs();
foreach ($utilisateurs as $utilisateur) {
    echo "<p>$utilisateur</p>";
}