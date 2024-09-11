<?php
require_once 'Trajet.php';

$trajets = Trajet::recupererTrajets();
foreach ($trajets as $trajet) {
    echo "<p>$trajet</p>";
}