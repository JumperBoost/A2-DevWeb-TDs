<?php
require_once 'Utilisateur.php';

$utilisateurParLogin = Utilisateur::recupererUtilisateurParLogin("renaudj");
echo $utilisateurParLogin;

if($utilisateurParLogin == null)
    echo "Utilisateur null.";