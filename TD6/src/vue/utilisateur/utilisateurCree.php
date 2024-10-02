<p>L'utilisateur a bien été créé !</p>
<?php
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

$utilisateurs = (new UtilisateurRepository())->recuperer();
require 'liste.php';