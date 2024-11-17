<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Passager;
use App\Covoiturage\Modele\Repository\PassagerRepository;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ControleurPassager extends AbstractControleur {
    public static function inscrire(): void {
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_GET["login"]);
        $trajet = (new TrajetRepository())->recupererParClePrimaire($_GET["id"]);
        if(is_null($utilisateur) || is_null($trajet))
            self::afficherErreur("trajet", "afficherListe", ["Impossible de récupérer l'utilisateur ou l'id du trajet"]);

        if((new PassagerRepository())->ajouter(new Passager($trajet, $utilisateur))) {
            $trajet->ajouterPassager($utilisateur);
            self::afficherVue("passagerInscrit.php", ["titre" => "Détail d'un trajet", "trajet" => $trajet, "utilisateur" => $utilisateur, "passagersPotentiel" => (new TrajetRepository())->recupererPassagersOuConducteursPotentiel($trajet)]);
        } else self::afficherErreur("trajet", "afficherDetail", ["Impossible d'inscrire le passager"], ["id" => $trajet->getId()]);
    }

    public static function desinscrire(): void {
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_GET["login"]);
        $trajet = (new TrajetRepository())->recupererParClePrimaire($_GET["id"]);
        if(is_null($utilisateur) || is_null($trajet))
            self::afficherErreur("trajet", "afficherListe", ["Impossible de récupérer l'utilisateur ou l'id du trajet"]);

        if((new PassagerRepository())->supprimer($trajet->getId(), $utilisateur->getLogin())) {
            $trajet->supprimerPassager($utilisateur);
            self::afficherVue("passagerDesinscrit.php", ["titre" => "Détail d'un trajet", "trajet" => $trajet, "utilisateur" => $utilisateur, "passagersPotentiel" => (new TrajetRepository())->recupererPassagersOuConducteursPotentiel($trajet)]);
        } else self::afficherErreur("trajet", "afficherDetail", ["Impossible de désinscrire le passager"], ["id" => $trajet->getId()]);
    }

    protected static function getCheminCorpsVue(): string {
        return "passager";
    }
}