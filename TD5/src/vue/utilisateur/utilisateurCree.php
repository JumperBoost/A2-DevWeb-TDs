<p>L'utilisateur a bien été créé !</p>
<?php
use App\Covoiturage\Modele\ModeleUtilisateur;

$utilisateurs = ModeleUtilisateur::recupererUtilisateurs();
require 'liste.php';