<?php
require_once 'Utilisateur.php';

$login = $_POST['login'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];

$utilisateur = new Utilisateur($login, $nom, $prenom);
echo $utilisateur;
?>