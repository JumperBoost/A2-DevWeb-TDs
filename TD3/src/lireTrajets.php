<?php
require_once 'Trajet.php';

$trajets = Trajet::recupererTrajets();
foreach ($trajets as $trajet) {
    echo "<h1>$trajet</h1>";
    $passagers = $trajet->getPassagers();
    foreach ($passagers as $passager) {
        echo "<p>$passager</p>";
    }
}