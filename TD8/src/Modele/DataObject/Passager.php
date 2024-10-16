<?php
namespace App\Covoiturage\Modele\DataObject;

class Passager extends AbstractDataObject {
    private Trajet $trajet;
    private Utilisateur $passager;

    public function __construct(Trajet $trajet, Utilisateur $passagerLogin) {
        $this->trajet = $trajet;
        $this->passager = $passagerLogin;
    }

    public function getTrajet(): Trajet {
        return $this->trajet;
    }

    public function setTrajet(Trajet $trajet): void {
        $this->trajet = $trajet;
    }

    public function getPassager(): Utilisateur {
        return $this->passager;
    }

    public function setPassager(Utilisateur $passager): void {
        $this->passager = $passager;
    }
}