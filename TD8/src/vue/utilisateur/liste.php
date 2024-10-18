<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur[] $utilisateurs
 */
foreach ($utilisateurs as $utilisateur)
    echo '<p> Utilisateur de login ' . htmlspecialchars($utilisateur->getLogin()) .
        '. <i><a href="?controleur=utilisateur&action=afficherDetail&login=' . htmlspecialchars($utilisateur->getLogin()) . '">Détails</a></i></p>';

echo "<i><a href='?controleur=utilisateur&action=afficherFormulaireCreation'>Créer un utilisateur</a></i>";
