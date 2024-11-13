<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur $utilisateur
 */

use App\Covoiturage\Lib\ConnexionUtilisateur;

echo "Utilisateur " . htmlspecialchars($utilisateur->getNom()) . " " . htmlspecialchars($utilisateur->getPrenom()) . " de login " . htmlspecialchars($utilisateur->getLogin());
if(ConnexionUtilisateur::estUtilisateur($utilisateur->getLogin())) {
    echo ' <i><a href="?controleur=utilisateur&action=afficherFormulaireMiseAJour&login=' . htmlspecialchars($utilisateur->getLogin()) . '">Mettre à jour</a></i> ' .
         '<i><a href="?controleur=utilisateur&action=supprimer&login=' . htmlspecialchars($utilisateur->getLogin()) . '">Supprimer</a></i>';
}