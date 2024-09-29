<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Trajet[] $trajets
 */
foreach ($trajets as $trajet)
    echo '<p> Trajet d\'id ' . htmlspecialchars($trajet->getId()) .
        '. <i><a '/*href="?action=afficherDetail&id=' . rawurlencode($trajet->getId())*/ . '">Détails</a> ' .
        '<a '/*href="?action=afficherFormulaireMiseAJour&id=' . $trajet->getId()*/ . '">Mettre à jour</a> ' .
        '<a '/*href="?action=supprimer&id=' . rawurlencode($trajet->getId())*/ . '">Supprimer</a></i></p>';

echo "<i><a "/*href='?action=afficherFormulaireCreation'*/ . ">Créer un trajet</a></i>";
