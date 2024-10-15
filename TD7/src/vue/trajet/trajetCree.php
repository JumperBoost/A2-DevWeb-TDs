<p>Le trajet a bien été créé.</p>
<?php
use App\Covoiturage\Modele\Repository\TrajetRepository;

$trajets = (new TrajetRepository())->recuperer();
require 'liste.php';