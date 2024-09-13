<?php
require_once 'Utilisateur.php';
require_once 'Trajet.php';

$login = $_GET['login'];
$trajetId = $_GET['trajet_id'];

if(!is_null($login) && !is_null($trajetId)) {
    $utilisateur = Utilisateur::recupererUtilisateurParLogin($login);
    $trajet = Trajet::recupererTrajetParId($trajetId);
    if(!is_null($utilisateur) && !is_null($trajet)) {
        if($trajet->supprimerPassager($login)) {
            echo "L'utilisateur {$utilisateur->getNom()} {$utilisateur->getPrenom()} ne fait plus partis des passagers du trajet n°$trajetId.";
        } else echo "Impossible de supprimer l'utilisateur {$utilisateur->getNom()} {$utilisateur->getPrenom()} du trajet n°$trajetId.";
    } else echo "Impossible de récupérer l'utilisateur ou le trajet. Un ou plusieurs paramètres sont incorrects.";
} else echo "Un ou plusieurs paramètres sont manquants.";