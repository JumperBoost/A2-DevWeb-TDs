<p>L'utilisateur a bien été créé !</p>
<?php

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

$utilisateurs = (new UtilisateurRepository())->recuperer();
$estAdmin = ConnexionUtilisateur::estAdministrateur();
require 'liste.php';