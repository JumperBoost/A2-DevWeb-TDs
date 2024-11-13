<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur[] $utilisateurs
 * @var bool $estAdmin
 */
foreach ($utilisateurs as $utilisateur) {
    $ligne = '<p> Utilisateur de login ' . htmlspecialchars($utilisateur->getLogin()) .
        '. <i><a href="?controleur=utilisateur&action=afficherDetail&login=' . htmlspecialchars($utilisateur->getLogin()) . '">Détails</a></i>';
    if($estAdmin)
        $ligne .= ' <a href="?controleur=utilisateur&action=afficherFormulaireMiseAJour&login=' . $utilisateur->getLogin() . '">Mettre à jour</a>';
    $ligne .= '</p>';
    echo $ligne;
}

echo "<i><a href='?controleur=utilisateur&action=afficherFormulaireCreation'>Créer un utilisateur</a></i>";
