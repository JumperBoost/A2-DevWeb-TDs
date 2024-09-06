<?php
require_once 'ConnexionBaseDeDonnees.php';
require_once 'Utilisateur.php';

$pdo = ConnexionBaseDeDonnees::getPdo();
$pdoStatement = $pdo->query("SELECT * FROM utilisateur", PDO::FETCH_ASSOC);

$utilisateurs = Utilisateur::getUtilisateurs();
foreach ($utilisateurs as $utilisateur) {
    echo "<p>$utilisateur</p>";
}