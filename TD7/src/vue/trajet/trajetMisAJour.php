<?php
use App\Covoiturage\Modele\Repository\TrajetRepository;

/**
 * @var string $id
 */
echo "<p>Le trajet id " . htmlspecialchars($id) . " a bien été mis à jour</p>";

$trajets = (new TrajetRepository())->recuperer();
require 'liste.php';