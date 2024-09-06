<?php
require_once 'ConnexionBaseDeDonnees.php';
require_once 'Utilisateur.php';

$pdo = ConnexionBaseDeDonnees::getPdo();
$pdoStatement = $pdo->query("SELECT * FROM utilisateur", PDO::FETCH_ASSOC);

foreach ($pdoStatement as $ligne) {
    $utilisateur = new Utilisateur($ligne['loginBaseDeDonnees'], $ligne['nomBaseDeDonnees'], $ligne['prenomBaseDeDonnees']);
    echo "<p>$utilisateur</p>";
}