<?php
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

/**
 * @var string $login
 */
echo "<p>L’utilisateur de login " . htmlspecialchars($login) . " a bien été supprimé</p>";

$utilisateurs = (new UtilisateurRepository())->recuperer();
require 'liste.php';