<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Trajet[] $trajets
 */
foreach ($trajets as $trajet)
    echo '<p>Trajet d\'id ' . htmlspecialchars($trajet->getId()) .
        '. <i><a href="?controleur=trajet&action=afficherDetail&id=' . rawurlencode($trajet->getId()) . '">Détails</a> ' .
        '<a href="?controleur=trajet&action=afficherFormulaireMiseAJour&id=' . rawurlencode($trajet->getId()) . '">Mettre à jour</a> ' .
        '<a href="?controleur=trajet&action=supprimer&id=' . rawurlencode($trajet->getId()) . '">Supprimer</a></i></p>';

echo "<i><a href='?controleur=trajet&action=afficherFormulaireCreation'>Créer un trajet</a></i>";
