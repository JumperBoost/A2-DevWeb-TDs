<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur[] $utilisateurs
 */
foreach ($utilisateurs as $utilisateur)
    echo '<p> Utilisateur de login ' . htmlspecialchars($utilisateur->getLogin()) .
        '. <i><a href="?controleur=utilisateur&action=afficherDetail&login=' . rawurlencode($utilisateur->getLogin()) . '">Détails</a> ' .
        '<a href="?controleur=utilisateur&action=afficherFormulaireMiseAJour&login=' . $utilisateur->getLogin() . '">Mettre à jour</a> ' .
        '<a href="?controleur=utilisateur&action=supprimer&login=' . rawurlencode($utilisateur->getLogin()) . '">Supprimer</a></i></p>';

echo "<i><a href='?controleur=utilisateur&action=afficherFormulaireCreation'>Créer un utilisateur</a></i>";
