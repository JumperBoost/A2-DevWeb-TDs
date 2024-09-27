<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur[] $utilisateurs
 */
foreach ($utilisateurs as $utilisateur)
    echo '<p> Utilisateur de login ' . htmlspecialchars($utilisateur->getLogin()) . '. <i><a href="?action=afficherDetail&login=' . rawurlencode($utilisateur->getLogin()) . '">Détails</a></i></p>';

echo "<i><a href='?action=afficherFormulaireCreation'>Créer un utilisateur</a></i>";
