<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Trajet $trajet
 */
$nonFumeur = $trajet->isNonFumeur() ? " non fumeur" : " ";
echo "Le trajet$nonFumeur du {$trajet->getDate()->format("d/m/Y")} partira de " . htmlspecialchars($trajet->getDepart()) . " pour aller à " . htmlspecialchars($trajet->getArrivee()) . " (conducteur: " . htmlspecialchars($trajet->getConducteur()->getPrenom()) . " " . htmlspecialchars($trajet->getConducteur()->getNom()) . ".";
