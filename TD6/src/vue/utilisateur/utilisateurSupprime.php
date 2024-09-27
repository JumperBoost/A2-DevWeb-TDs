<p>L'utilisateur a bien été supprimé !</p>
<?php
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

$utilisateurs = UtilisateurRepository::recupererUtilisateurs();
require 'liste.php';