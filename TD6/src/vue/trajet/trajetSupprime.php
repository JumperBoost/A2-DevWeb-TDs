<?php
use App\Covoiturage\Modele\Repository\TrajetRepository;

/**
 * @var integer $id
 */
echo "<p>Le trajet id " . htmlspecialchars($id) . " a été supprimé avec succès.";

$trajets = (new TrajetRepository())->recuperer();
require 'liste.php';