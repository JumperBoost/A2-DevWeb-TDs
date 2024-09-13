<?php
require_once 'Trajet.php';

$trajets = Trajet::recupererTrajets();
foreach ($trajets as $trajet) {
    echo "<h1>$trajet</h1>";
    echo "<h3>Passagers</h3><ul>";
    $passagers = $trajet->getPassagers();
    foreach ($passagers as $passager) {
        echo "<li>$passager <i><a href='supprimerPassager.php?login={$passager->getLogin()}&trajet_id={$trajet->getId()}'>Désinscrire</a></i></li>";
    }
    echo "</ul>";
}