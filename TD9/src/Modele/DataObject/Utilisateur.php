<?php
namespace App\Covoiturage\Modele\DataObject;

use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class Utilisateur extends AbstractDataObject {
    private string $login;
    private string $nom;
    private string $prenom;
    private string $mdpHache;
    private string $email;
    private string $emailAValider;
    private string $nonce;
    private bool $estAdmin;

    /**
     * @var ?Trajet[]
     */
    private ?array $trajetsCommePassager;

    /**
     * @var ?Trajet[]
     */
    private ?array $trajetsCommeConducteur;

    // un getter
    public function getNom(): string {
        return $this->nom;
    }

    // un setter
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin(string $login): void {
        $this->login = substr($login, 0, 64);
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom($prenom): void {
        $this->prenom = $prenom;
    }

    public function getMdpHache(): string {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void {
        $this->mdpHache = $mdpHache;
    }

    // un constructeur
    public function __construct(
        string $login,
        string $nom,
        string $prenom,
        string $mdpHache,
        string $email,
        string $emailAValider,
        string $nonce,
        bool $estAdmin = false
    ) {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdpHache = $mdpHache;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
        $this->estAdmin = $estAdmin;
    }

    public function getTrajetsCommePassager(): ?array {
        if(is_null($this->trajetsCommePassager))
            $this->setTrajetsCommePassager(UtilisateurRepository::recupererTrajetsCommePassager($this));
        return $this->trajetsCommePassager;
    }

    public function setTrajetsCommePassager(?array $trajetsCommePassager): void {
        $this->trajetsCommePassager = $trajetsCommePassager;
    }

    public function getTrajetsCommeConducteur(): ?array {
        if(is_null($this->trajetsCommeConducteur))
            $this->setTrajetsCommeConducteur(UtilisateurRepository::recupererTrajetsCommeConducteur($this));
        return $this->trajetsCommeConducteur;
    }

    public function setTrajetsCommeConducteur(?array $trajetsCommeConducteur): void {
        $this->trajetsCommeConducteur = $trajetsCommeConducteur;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getEmailAValider(): string {
        return $this->emailAValider;
    }

    public function setEmailAValider(string $emailAValider): void {
        $this->emailAValider = $emailAValider;
    }

    public function getNonce(): string {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void {
        $this->nonce = $nonce;
    }

    public function isAdmin(): bool {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void {
        $this->estAdmin = $estAdmin;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    /*public function __toString(): string
    {
        return "Utilisateur $this->nom $this->prenom de login $this->login";
    }*/
}