<?php
require_once ('../Modele/ModeleUtilisateur.php'); // chargement du modèle
class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        require ('../vue/utilisateur/liste.php');  //"redirige" vers la vue
    }
}
?>