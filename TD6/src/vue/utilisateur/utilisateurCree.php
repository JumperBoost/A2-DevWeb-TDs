<p>L'utilisateur a bien été créé !</p>
<?php
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

$utilisateurs = UtilisateurRepository::recupererUtilisateurs();
require 'liste.php';