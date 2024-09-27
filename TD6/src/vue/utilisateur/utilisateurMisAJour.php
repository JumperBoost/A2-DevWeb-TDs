<?php
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

/**
 * @var string $login
 */
echo "<p>L’utilisateur de login $login a bien été mis à jour</p>";

$utilisateurs = UtilisateurRepository::recupererUtilisateurs();
require 'liste.php';