<?php
require_once 'Utilisateur.php';

$utilisateurParLogin = Utilisateur::recupererUtilisateurParLogin("renjaudj");
echo $utilisateurParLogin;

if($utilisateurParLogin == null)
    echo "Utilisateur null.";
echo "<br><br>";

$nouvelUtilisateur = new Utilisateur("garceyp", "Garcey", "Pierre");
$nouvelUtilisateur->ajouter();